<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Option;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Exception;

class DocusignController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return render
     */
    public function index()
    {
        return view('admin.docusign.index')
        ->with('active', 'docusign');
    }

    /**
     * Get Docusign Auth URL
     *
     * @return url
     */
    public function connect()
    {
        try {
            $params = [
                'response_type' => 'code',
                'scope' => "signature click.manage",
                'client_id' => env('DOCUSIGN_CLIENT_ID'),
                'redirect_uri' => route('admin.docusign.callback'),
            ];
            $queryBuild = http_build_query($params);

            $url = "https://account-d.docusign.com/oauth/auth?";

            $botUrl = $url . $queryBuild;
            return redirect()->to($botUrl);
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Something Went wrong !');
        }
    }

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function callback(Request $request)
    {
        $code = $request->code;

        $integrator_and_secret_key = $this->getSecretKey();

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, 'https://account-d.docusign.com/oauth/token');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        $post = array(
            'grant_type' => 'authorization_code',
            'code' => $code,
        );
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post);

        $headers = array();
        $headers[] = 'Cache-Control: no-cache';
        $headers[] = "authorization: $integrator_and_secret_key";
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        $result = curl_exec($ch);
        if (curl_errno($ch)) {
            echo 'Error:' . curl_error($ch);
        }
        curl_close($ch);
        $decodedData = json_decode($result);

        if (empty(Option::get_option('docusign_auth_code'))) {
            Option::Create(
                [
                    'name' => 'docusign_auth_code',
                    'value' => $decodedData->access_token,
                ],
            );
            Option::Create(
                [
                    'name' => 'docusign_refresh_code',
                    'value' => $decodedData->refresh_token,
                ],
            );
        }
        return redirect()->route('admin.docusign')->with('msg', 'Docusign Succesfully Connected');
    }

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function revoke()
    {
        if (!empty(Option::get_option('docusign_auth_code'))) {
            Option::where('name', 'docusign_auth_code')->delete();
            Option::where('name', 'docusign_refresh_code')->delete();
        }
        return redirect()->route('admin.docusign')->with('msg', 'Docusign Succesfully revoked');
    }

    /**
     * Generate secret key combination
     *
     * @return string
     */
    public function getSecretKey()
    {
        $client_id = env('DOCUSIGN_CLIENT_ID');
        $client_secret = env('DOCUSIGN_CLIENT_SECRET');
        return "Basic " . utf8_decode(base64_encode("{$client_id}:{$client_secret}"));
    }

    /**
     * Refresh the token on auth token expiration
     *
     * @return void
     */
    public function refreshToken()
    {
        try {
            $toDate = Option::where('name', 'docusign_refresh_code')->pluck('updated_at')->first();
            $to = Carbon::createFromFormat('Y-m-d H:s:i', $toDate);
            $from = Carbon::createFromFormat('Y-m-d H:s:i', Carbon::now());

            $diff_in_days = $to->diffInDays($from);

            $integrator_and_secret_key = $this->getSecretKey();
            $ch = curl_init();

            curl_setopt($ch, CURLOPT_URL, 'https://account-d.docusign.com/oauth/token');
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_POST, 1);
            $post = array(
                'grant_type' => 'refresh_token',
                'refresh_token' => Option::get_option('docusign_refresh_code'),
            );
            curl_setopt($ch, CURLOPT_POSTFIELDS, $post);

            $headers = array();
            $headers[] = 'Cache-Control: no-cache';
            $headers[] = "authorization: $integrator_and_secret_key";
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

            $result = curl_exec($ch);
            
            if (curl_errno($ch)) {
                echo 'Error:' . curl_error($ch);
            }
            curl_close($ch);
            
            $decodedData = json_decode($result);
            // if ($diff_in_days > 28) {
            //     Option::where('name', 'docusign_refresh_code')->update(['value' => $decodedData->refresh_token]);
            // }
            Option::where('name', 'docusign_auth_code')->update(['value' => $decodedData->access_token]);
            Option::where('name', 'docusign_refresh_code')->update(['value' => $decodedData->refresh_token]);

        } catch (Exception $e) {
            return redirect()->back()->with('msg', $e->getMessage());
        }
    }
}
