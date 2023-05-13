<?php

namespace ZohoSubscriptions\Support;

class AuthorisationProcessor
{
    public function __construct($accessToken, $integration)
    {
        $config = config($integration);
        $token = $config['tokenModel'];
        $token = (new $token($integration))->set([
            'accessToken' => $accessToken->getToken(),
            'refreshToken' => $accessToken->getRefreshToken(),
            'expires' => $accessToken->getExpires(),
        ])->save();
    }
}
