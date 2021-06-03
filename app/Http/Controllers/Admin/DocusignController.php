<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Option;
use Illuminate\Http\Request;

class DocusignController extends Controller
{
    public function index()
    {
        return view('admin.docusign.index');
    }

    public function connect()
    {
        try {
            $params = [
                'response_type' => 'code',
                'scope' => 'signature',
                'client_id' => env('DOCUSIGN_CLIENT_ID'),
                'state' => 'a39fh23hnf23',
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

    public function callback(Request $request)
    {
        $code = $request->code;

        $client_id = env('DOCUSIGN_CLIENT_ID');
        $client_secret = env('DOCUSIGN_CLIENT_SECRET');

        $integrator_and_secret_key = "Basic " . utf8_decode(base64_encode("{$client_id}:{$client_secret}"));

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
        }
        return redirect()->route('admin.docusign')->with('msg', 'Docusign Succesfully Connected');
    }

    public function revoke()
    {
        if (!empty(Option::get_option('docusign_auth_code'))) {
            Option::where('name','docusign_auth_code')->delete();
        }
        return redirect()->route('admin.docusign')->with('msg', 'Docusign Succesfully revoked');   
    }
}
