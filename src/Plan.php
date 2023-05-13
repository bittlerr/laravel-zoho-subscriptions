<?php

namespace ZohoSubscriptions;

use ZohoSubscriptions\Support\Model;

class Plan extends Model
{
    protected $endPoint = 'plans';

    protected $allowedMethods = ['get', 'post', 'delete'];

    protected $apiMultipleDataField = 'plans';

    public function getApiMultipleDataField()
    {
        return $this->apiMultipleDataField;
    }
}
