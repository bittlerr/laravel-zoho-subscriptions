<?php

namespace ZohoSubscriptions;

use ZohoSubscriptions\Support\Model;

class Customer extends Model
{
    protected $insertResource = 'ZohoSubscriptions\Requests\StoreCustomer';

    protected $endPoint = 'customers';

    protected $allowedMethods = ['find', 'get', 'post', 'delete'];

    protected $apiMultipleDataField = 'customers';

    protected $primaryKey = 'customer_id';

    public function getApiMultipleDataField()
    {
        return $this->apiMultipleDataField;
    }

    public function subscriptions()
    {
        return $this->hasMany(Subscription::class);
    }
}
