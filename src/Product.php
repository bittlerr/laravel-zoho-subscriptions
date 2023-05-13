<?php

namespace ZohoSubscriptions;

use ZohoSubscriptions\Support\Model;

class Product extends Model
{
    protected $endPoint = 'products';

    protected $allowedMethods = ['get', 'post', 'delete'];

    protected $apiMultipleDataField = 'products';

    public function getApiMultipleDataField()
    {
        return $this->apiMultipleDataField;
    }
}
