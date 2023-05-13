<?php

namespace ZohoSubscriptions;

use ZohoSubscriptions\Support\Model;

class Customer extends Model
{
    protected $insertResource = 'ZohoSubscriptions\Requests\StoreCustomer';

    // protected $updateResource = 'ZohoSubscriptions\Requests\UpdateCustomer';

    protected $endPoint = 'customers';

    protected $allowedMethods = ['find', 'get', 'post', 'delete'];

    protected $apiMultipleDataField = 'customers';

    public function getApiMultipleDataField()
    {
        return $this->apiMultipleDataField;
    }

    public function subscriptions()
    {
        return $this->hasMany(Subscription::class);
    }
}
