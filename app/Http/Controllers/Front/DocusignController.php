<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use DocuSign\eSign\Configuration;
use DocuSign\eSign\Api\EnvelopesApi;
use DocuSign\eSign\Client\ApiClient;
use App\Models\Option;
use Auth;
use App\Models\Domain;

class DocusignController extends Controller
{   

     /** hold config value */
     private $config;

    private $signer_client_id = 1000; # Used to indicate that the signer will use embedded

    /** Specific template arguments */
    private $args;


    public function signDocument($domain)
    {   
        $this->args = $this->getTemplateArgs($domain);

        $lessorID = Domain::where('domain',$domain)->pluck('user_id')->first();

        $args = $this->args;

        $envelope_args = $args["envelope_args"];

        # Create the envelope request object
        $envelope_definition = $this->make_envelope($args["envelope_args"],$lessorID);
        $envelope_api = $this->getEnvelopeApi();
        # Call Envelopes::create API method
        # Exceptions will be caught by the calling function
       

        $api_client = new \DocuSign\eSign\client\ApiClient($this->config);
        $envelope_api = new \DocuSign\eSign\Api\EnvelopesApi($api_client);
        $results = $envelope_api->createEnvelope($args['account_id'], $envelope_definition);
        $envelope_id = $results->getEnvelopeId();

        $authentication_method = 'None'; # How is this application authenticating
        # the signer? See the `authenticationMethod' definition
        # https://developers.docusign.com/esign-rest-api/reference/Envelopes/EnvelopeViews/createRecipient
        $recipient_view_request = new \DocuSign\eSign\Model\RecipientViewRequest([
            'authentication_method' => $authentication_method,
            'client_user_id' => $envelope_args['signer_client_id'],
            'recipient_id' => '1',
            'return_url' => $envelope_args['ds_return_url'],
            'user_name' => Auth::user()->name, 'email' => Auth::user()->email
        ]);

        $results = $envelope_api->createRecipientView($args['account_id'], $envelope_id,$recipient_view_request);

        return redirect()->to($results['url']);
    }


    private function make_envelope($args,$lessorID)
    {   
        
        $filename = 'pdf\contract_'.$lessorID.'.pdf';

        $demo_docs_path = \Storage::disk('public')->path($filename);
        $content_bytes = file_get_contents($demo_docs_path);

        $base64_file_content = base64_encode($content_bytes);
        # Create the document model
        $document = new \DocuSign\eSign\Model\Document([# create the DocuSign document object
        'document_base64' => $base64_file_content,
            'name' => 'Example document', # can be different from actual file name
            'file_extension' => 'pdf', # many different document types are accepted
            'document_id' => 1, # a label used to reference the doc
        ]);
        # Create the signer recipient model
        $signer = new \DocuSign\eSign\Model\Signer([# The signer
        'email' => Auth::user()->email, 'name' => Auth::user()->name,
            'recipient_id' => "1", 'routing_order' => "1",
            # Setting the client_user_id marks the signer as embedded
            'client_user_id' => $args['signer_client_id'],
        ]);
        # Create a sign_here tab (field on the document)
        $sign_here = new \DocuSign\eSign\Model\SignHere([# DocuSign SignHere field/tab
        'anchor_string' => '/sn1/', 'anchor_units' => 'pixels',
            'anchor_y_offset' => '10', 'anchor_x_offset' => '20',
        ]);
        # Add the tabs model (including the sign_here tab) to the signer
        # The Tabs object wants arrays of the different field/tab types
        $signer->settabs(new \DocuSign\eSign\Model\Tabs(['sign_here_tabs' => [$sign_here]]));
        # Next, create the top level envelope definition and populate it.
        $envelope_definition = new \DocuSign\eSign\Model\EnvelopeDefinition([
            'email_subject' => "Please sign this document sent from the IDENTITUS",
            'documents' => [$document],
            # The Recipients object wants arrays for each recipient type
            'recipients' => new \DocuSign\eSign\Model\Recipients(['signers' => [$signer]]),
            'status' => "sent", # requests that the envelope be created and sent.
        ]);
        return $envelope_definition;
    }

    /**
     * Getter for the EnvelopesApi
     */
    public function getEnvelopeApi(): EnvelopesApi
    {   
        $this->config = new Configuration();
        $this->config->setHost($this->args['base_path']);
        $this->config->addDefaultHeader('Authorization', 'Bearer ' . $this->args['ds_access_token']);    
        $this->apiClient = new ApiClient($this->config);

        return new EnvelopesApi($this->apiClient);
    }

    /**
     * Get specific template arguments
     *
     * @return array
     */
    private function getTemplateArgs($domainName)
    {   
        $envelope_args = [
            'signer_client_id' => $this->signer_client_id,
            'ds_return_url' => route('ajax.add.to.cart',$domainName),
        ];
        $args = [
            'account_id' => env('DOCUSIGN_ACCOUNT_ID'),
            'base_path' => env('DOCUSIGN_BASE_URL'),
            'ds_access_token' => Option::get_option('docusign_auth_code'),
            'envelope_args' => $envelope_args
        ];

        return $args;
        
    }
}
