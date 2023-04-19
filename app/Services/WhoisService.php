<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Exception;

class WhoisService
{
    private $accountIdentifier;
    private $authKey;
    private $authEmail;
    const API_ENDPOINT = "https://api.cloudflare.com/client/v4/";
    const ACCOUNT_ENDPOINT = "accounts/";
    const WHOIS_ENDPOINT = "/intel/whois/?";

    public function __construct()
    {
        $this->setAccountDetails();
    }

    /**
     * Set the account details e.g keys etc
     */

    public function setAccountDetails()
    {
        try {
            $this->accountIdentifier = env('CLOUDFLARE_ACCOUNT_IDENTIFIER');
            $this->authKey = env('CLOUDFLARE_ACCOUNT_API_KEY');
            $this->authEmail = env('CLOUDFLARE_ACCOUNT_EMAIL');
            if ($this->accountIdentifier == null || $this->authKey == null || $this->authEmail == null) {
                throw new Exception("Cloudflare API Details are Missing. Please Set Them In ENV");
            }
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    /**
     * Get Domain Whois Info
     * @param $domain
     * @return Array
     */

    public function domainWhois($domain)
    {
        try {
            $endpoint = self::API_ENDPOINT . self::ACCOUNT_ENDPOINT . $this->accountIdentifier . self::WHOIS_ENDPOINT;
            $params = http_build_query([
                'domain' => $domain
            ]);
            $headers = [
                'Content-Type' => 'application/json',
                'X-Auth-Key' => $this->authKey,
                'X-Auth-Email' => $this->authEmail,
            ];
            $response = Http::withHeaders($headers)->get($endpoint . $params);
            $response->onError([$this, 'requestError']);
            $whoisData = json_decode($response->body(), true);
            return $whoisData['result'];
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    /**
     * Return the request error
     * @param Http $request
     */

    public function requestError($request)
    {
        try {
            $errorData = json_decode($request->body(), true);
            if (isset($errorData['errors'][0])) {
                throw new Exception("Error: " . $errorData['errors'][0]['message'] . ' Code: ' . $errorData['errors'][0]['code']);
            } else {
                throw new Exception($request->body());
            }
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }
}
