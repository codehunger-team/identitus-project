<?php

namespace App\Traits;

use App\Models\Option;
use App\Models\Domain;
use DocuSign\Click\Client\ApiClient;
use DocuSign\Click\Configuration;
use DocuSign\Click\Model\Document;
use DocuSign\Click\Model\DisplaySettings;
use DocuSign\Click\Api\AccountsApi;
use DocuSign\Click\Model\ClickwrapRequest;
use Illuminate\Support\Facades\Storage;

trait DocusignTrait {

    public function docusignClickWrap($domain)
    {   
        // dd($domain);
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
                'require_accept' => true,
                'document_display' => 'document'
            ]
        );

        if(str_contains($domain,'.pdf')) {
            $filename = $domain;
            $demo_docs_path = public_path().'/'.'pdf/'.$domain;
            $content_bytes = file_get_contents($demo_docs_path);

            $base64_file_content = base64_encode($content_bytes);

        } else {
              # Read the PDF from the disk
            # The exception will be raised if the file doesn't exist
            $lessorID = Domain::where('domain', $domain)->pluck('user_id')->first();

            $filename = 'pdf/contract_' . $lessorID . '.pdf';

            $demo_docs_path = Storage::disk('public')->path($filename);
            $content_bytes = file_get_contents($demo_docs_path);

            $base64_file_content = base64_encode($content_bytes);
        }
      
        # Build array of documents.
        $documents = [
            new Document([  # create the DocuSign document object
                'document_base64' => $base64_file_content,
                'document_name' => $filename,
                'file_extension' => 'pdf',
                'order' => '1'
            ])
        ];

        # Build ClickwrapRequest
        $clickwrap = new ClickwrapRequest(
            [
                'clickwrap_name' => $filename,
                'display_settings' => $displaySettings,
                'documents' => $documents,
                'require_reacceptance' => true
            ]
        );

        $clickwrap =  $accountsApi->createClickwrap(env('DOCUSIGN_ACCOUNT_ID'), $clickwrap);

        $clickwrap_request = new ClickwrapRequest(['status' => 'active']);

        $response = $accountsApi->updateClickwrapVersion(env('DOCUSIGN_ACCOUNT_ID'), $clickwrap['clickwrap_id'], '1', $clickwrap_request);

        $params = [
            'accountId' => env('DOCUSIGN_ACCOUNT_ID'),
            'clickwrapId' => $clickwrap['clickwrap_id'],
            'environment' => 'https://demo.docusign.net',
            'clientUserId' => rand(1111111111, 9999999999),
            'created_time' => $response['created_time'],
        ];
        return $params;
    }

    /**
     * Getter for the AccountsApi
    */
    public function accountsApi(): AccountsApi
    {
        $args['ds_access_token'] = Option::get_option('docusign_auth_code');
        $config = new Configuration();
        $config->setHost('https://demo.docusign.net/clickapi');
        $config->addDefaultHeader('Authorization', 'Bearer ' . $args['ds_access_token']);
        $this->apiClient = new ApiClient($config);
        return new AccountsApi($this->apiClient);
    }
    
}
