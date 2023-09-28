<?php

namespace ZohoSubscriptions\Support;

use MacsiDigital\API\Support\Entry as ApiEntry;
use ZohoSubscriptions\Facades\Client;

class Entry extends ApiEntry
{
    protected $modelNamespace = '\ZohoSubscriptions\\';

    public function newRequest()
    {
        $config = config('zoho');
        $class = $config['tokenModel'];
        $organizationId = $config['organizationId'];
        $token = new $class('zoho');

        if ($token->hasExpired()) {
            $token = $token->renewToken();
        }

        return Client::baseUrl($config['baseUrl'])
            ->withHeaders(['X-com-zoho-subscriptions-organizationid' => $organizationId])
            ->withToken($token->accessToken());
    }
}
