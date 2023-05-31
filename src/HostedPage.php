<?php

namespace ZohoSubscriptions;

use ZohoSubscriptions\Support\Model;

class HostedPage extends Model
{
    protected $endPoint = 'hostedpages';

    protected $allowedMethods = ['find', 'get'];

    protected $apiMultipleDataField = 'hostedpages';

    public function getApiMultipleDataField()
    {
        return $this->apiMultipleDataField;
    }

    public function customer()
    {
        return $this->hasOne(Customer::class);
    }
}
