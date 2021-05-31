<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use DocuSign;
use Illuminate\Http\Request;
use SignatureClientService;
use DocuSign\eSign\Configuration;
use DocuSign\eSign\Api\EnvelopesApi;
use DocuSign\eSign\Client\ApiClient;
use App\Models\Option;
// use Auth;

class DocusignController extends Controller
{   

    /** signatureClientService */
    private $clientService;

    private $signer_client_id = 1000; # Used to indicate that the signer will use embedded

    /** Specific template arguments */
    private $args;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->args = $this->getTemplateArgs();
        $config = new Configuration();
        $config->setHost($this->args['base_path']);
        $config->addDefaultHeader('Authorization', 'Bearer ' . $this->args['ds_access_token']);    
        $this->apiClient = new ApiClient($config);
    }

    public function signDocument($domain)
    {   
        dd(\Auth::user());
        $this->worker($this->args);
    }

    public function worker(array $args)
    {
        $envelope_args = $args["envelope_args"];

        # Create the envelope request object
        $envelope_definition = $this->make_envelope($args["envelope_args"]);
        $envelope_api = $this->getEnvelopeApi();
        # Call Envelopes::create API method
        # Exceptions will be caught by the calling function
        $config = new \DocuSign\eSign\Configuration();
        $config->setHost($args['base_path']);
        $config->addDefaultHeader('Authorization', 'Bearer ' . $args['ds_access_token']);

        $api_client = new \DocuSign\eSign\client\ApiClient($config);
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
            'user_name' => $envelope_args['signer_name'], 'email' => $envelope_args['signer_email']
        ]);

        $results = $envelope_api->createRecipientView($args['account_id'], $envelope_id,$recipient_view_request);
        
        return redirect()->to($results['url']);
        
    }

    private function make_envelope($args)
    {   
        
        $demo_docs_path = asset('doc/World_Wide_Corp_lorem.pdf');
        // print_r($demo_docs_path); die;
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
        'email' => $args['signer_email'], 'name' => $args['signer_name'],
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
            'email_subject' => "Please sign this document sent from the PHP SDK",
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
        return new EnvelopesApi($this->apiClient);
    }

    /**
     * Get specific template arguments
     *
     * @return array
     */
    private function getTemplateArgs()
    {   
        dd(\Auth::user());
        $signer_name = Auth::user()->name;
        $signer_email = Auth::user()->email;
        $envelope_args = [
            'signer_email' => $signer_email,
            'signer_name' => $signer_name,
            'signer_client_id' => $this->signer_client_id,
            'ds_return_url' => url('/'),
        ];
        $args = [
            'account_id' => Option::get_option('docusign_client_id'),
            'base_path' => 'https://demo.docusign.net/restapi',
            'ds_access_token' => Option::get_option('docusign_auth_code'),
            'envelope_args' => $envelope_args
        ];

        return $args;
    }
}
