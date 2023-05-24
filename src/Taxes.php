<?php

namespace ZohoSubscriptions;

use ZohoSubscriptions\Support\Model;

class Taxes extends Model
{
    protected $endPoint = 'settings/taxes';

    protected $allowedMethods = ['get'];

    protected $apiMultipleDataField = 'taxes';

    public function getApiMultipleDataField()
    {
        return $this->apiMultipleDataField;
    }
}
