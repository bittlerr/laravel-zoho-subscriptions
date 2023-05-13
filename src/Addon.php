<?php

namespace ZohoSubscriptions;

use ZohoSubscriptions\Support\Model;

class Addon extends Model
{
    protected $endPoint = 'addons';

    protected $allowedMethods = ['get', 'post', 'delete'];

    protected $apiMultipleDataField = 'addons';

    public function getApiMultipleDataField()
    {
        return $this->apiMultipleDataField;
    }
}
