<?php

namespace ZohoSubscriptions\Support;

use MacsiDigital\API\Support\ApiResource;

class Model extends ApiResource
{
    protected $apiDataField = '';

    protected $dateFormat = \DateTime::ATOM;
}
