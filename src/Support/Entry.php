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
        $token = new $class('zoho');

        if ($token->hasExpired()) {
            $token = $token->renewToken();
        }

        return Client::baseUrl($config['baseUrl'])->withToken($token->accessToken());
    }
}
