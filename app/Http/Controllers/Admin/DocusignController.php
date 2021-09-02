<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Option;
use Illuminate\Http\Request;
use DocuSign\Click\Client\ApiClient;
use DocuSign\Click\Configuration;
use DocuSign\Click\Model\Document;
use DocuSign\Click\Model\DisplaySettings;
use DocuSign\Click\Api\AccountsApi;
use DocuSign\Click\Model\ClickwrapRequest;
class DocusignController extends Controller
{   
    protected $clientService;

    protected $apiClient;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->args = $this->getTemplateArgs();
        // $this->clientService = new ClickApiClientService($this->args);
    }

    /**
     * Create a new controller instance.
     *
     * @return render
     */
    public function index()
    {
        return view('admin.docusign.index');

        // dd($this->apiClient);

        $accountsApi = $this->accountsApi();
        # Build the display settings
        $displaySettings = new DisplaySettings(
            [
                'consent_button_text' => 'I Agree',
                'display_name' => 'Terms of Service',
                'downloadable' => true,
                'format' => 'modal',
                'has_decline_button' => true,
                'must_read' => true,
                'must_view' => true,
                'require_accept' => true,
                'document_display' => 'document'
            ]
        );
        # Read the PDF from the disk
        # The exception will be raised if the file doesn't exist

        $filename = 'pdf/contract_6.pdf';


        $demo_docs_path = \Storage::disk('public')->path($filename);
        $content_bytes = file_get_contents($demo_docs_path);

        $base64_file_content = base64_encode($content_bytes);

        # Build array of documents.
        $documents = [
            new Document([  # create the DocuSign document object
                'document_base64' => $base64_file_content,
                'document_name' => 'Lorem Ipsum',
                'file_extension' => 'pdf',
                'order' => '1'
            ])
        ];

        # Build ClickwrapRequest
        $clickwrap = new ClickwrapRequest(
            [
                'clickwrap_name' => 'test',
                'display_settings' => $displaySettings,
                'documents' => $documents,
                'require_reacceptance' => true
            ]
        );
        // dd($clickwrap);
        $response =  $accountsApi->createClickwrap(env('DOCUSIGN_ACCOUNT_ID'), $clickwrap);
        // dd($response);

        $clickwrap_request = new ClickwrapRequest(['status' => 'active']);

        // $accounts_api = $this->accountsApi();
        $response = $accountsApi->updateClickwrapVersion(env('DOCUSIGN_ACCOUNT_ID'), 'eda8cb9c-11bf-40d7-96d1-03ace60d849b', '1', $clickwrap_request);
        // https://developers.docusign.com/click-api/test-clickwrap?a={API_ACCOUNT_ID}&cw={CLICKWRAP_ID}&eh={ENVIRONMENT}
        // $url = 'https://demo.docusign.net/clickapi/v1/accounts/d80c3d92-abb5-4d3e-b77a-f73b31017826/clickwraps/eda8cb9c-11bf-40d7-96d1-03ace60d849b/versions/1';

        $params = [
            'a' => env('DOCUSIGN_ACCOUNT_ID'),
            'cw' => 'eda8cb9c-11bf-40d7-96d1-03ace60d849b',
            'eh' => 'demo',
        ];
        $queryBuild = http_build_query($params);

        $url = "https://developers.docusign.com/click-api/test-clickwrap?";

        $botUrl = $url . $queryBuild;


        // return $url;
        return redirect()->to($botUrl);
        // dd($response);
    }

     /**
     * Getter for the AccountsApi
     */
    public function accountsApi(): AccountsApi
    {       
        $args['ds_access_token'] = 'eyJ0eXAiOiJNVCIsImFsZyI6IlJTMjU2Iiwia2lkIjoiNjgxODVmZjEtNGU1MS00Y2U5LWFmMWMtNjg5ODEyMjAzMzE3In0.AQsAAAABAAUABwAAaoQ3oGvZSAgAAKqnReNr2UgCABGFr4nSYb1Cp1lo4sm3rdUVAAEAAAAYAAIAAAAFAAAAUQAAAA0AJAAAADJkMjA5NGY3LTNlYWQtNGNhNS05ZTI3LWU2MzQzNzUzOGNiZiIAJAAAADJkMjA5NGY3LTNlYWQtNGNhNS05ZTI3LWU2MzQzNzUzOGNiZhIAAQAAAAsAAABpbnRlcmFjdGl2ZTAAAD1TNqBr2Ug3AHLXDyx8ZdhFpqYLTc39zwk.140Ihl4g1tgXzJpdMmpBhuotHr51tN6CTIAZgPT013GgZuLk5qxxTVwVYG5X6LDXz_7bfjw_9GpOnwzRSAGTaUg0tZl_LZnSBmQ4mDJqFyjSM34C-qWqLsEdjFvBZjTzz9P6ombpRfnQljQ34_0lY2SUECexqXJ6Ek3iT7X254t-rtMH3JXMGHLMK5OPsa4XX-S7lNy12B7qlzzXQLlDXqK_rUcuC8QWI2iGbSNwHsFMcTqCtT_xzvrrOiLgJKJAjPdtuK8nFFKhtkUXl-lzb2ffx7sTunndjQz-QEp5ab4FOZii0hUqbY9NFJ2beb--71dIM6OlrbXvRHzjweZGjA';

        $config = new Configuration();
        $config->setHost('https://demo.docusign.net/clickapi');
        $config->addDefaultHeader('Authorization', 'Bearer ' . $args['ds_access_token']);
        $this->apiClient = new ApiClient($config);
        // dd($this->apiClient);
        return new AccountsApi($this->apiClient);
    }

    /**
     * Get specific template arguments
     *
     * @return array
     */
    private function getTemplateArgs(): array
    {
        // $clickwrap_name = preg_replace('/([^\w \-\@\.\,])+/', '', $_POST['clickwrap_name']);
        return [
            'account_id' => $_SESSION['ds_account_id'],
            'ds_access_token' => $_SESSION['ds_access_token'],
            'clickwrap_name' => 'test'
        ];
    }

    /**
     * Get Docusign Auth URL
     *
     * @return url
     */
    public function connect()
    {   
        // https://account-d.docusign.com/oauth/auth?response_type=code&scope=signature%20click.manage&client_id=7c2b8d7e-xxxx-xxxx-xxxx-cda8a50dd73f&state=a39fh23hnf23&redirect_uri=http://example.com/callback

        // https://account-d.docusign.com/oauth/auth?response_type=code&scope=signature+click.manage&client_id=2d2094f7-3ead-4ca5-9e27-e63437538cbf&redirect_uri=http%3A%2F%2Flocalhost%3A8000%2Fadmin%2Fdocusign%2Fcallback

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
            // dd($botUrl);
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

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function revoke()
    {
        if (!empty(Option::get_option('docusign_auth_code'))) {
            Option::where('name', 'docusign_auth_code')->delete();
        }
        return redirect()->route('admin.docusign')->with('msg', 'Docusign Succesfully revoked');
    }

}
