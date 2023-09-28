<?php

return [
    'baseUrl' => 'https://www.zohoapis.com/subscriptions/v1',
    'identityUrl' => 'https://accounts.zoho.com/',
    'organizationId' => env('ZOHO_ORGANIZATION_ID'),
    'oauth2' => [
        'clientId' => env('ZOHO_CLIENT_ID'),
        'clientSecret' => env('ZOHO_CLIENT_SECRET'),
        'urlAuthorize' => 'https://accounts.zoho.com/oauth/v2/auth',
        'urlAccessToken' => 'https://accounts.zoho.com/oauth/v2/token',
        'urlResourceOwnerDetails' => 'https://accounts.zoho.com/oauth/v2/resource'
    ],
    'options' => [
        'scope' => [env('ZOHO_OAUTH_SCOPE')],
        'access_type' => 'offline'
    ],
    'tokenModel' => '\ZohoSubscriptions\Support\Token\DB',
    'tokenProcessor' => '\ZohoSubscriptions\Support\AuthorisationProcessor',
    'authorisedRedirect' => '',
    'failedRedirect' => '',
];
