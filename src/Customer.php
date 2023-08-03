<?php

namespace ZohoSubscriptions;

use ZohoSubscriptions\Support\Model;

class Customer extends Model
{
    protected $insertResource = 'ZohoSubscriptions\Requests\StoreCustomer';
    protected $updateResource = 'ZohoSubscriptions\Requests\UpdateCustomer';

    protected $endPoint = 'customers';

    protected $apiDataField = 'customer';

    protected $allowedMethods = ['find', 'get', 'post', 'put', 'delete'];

    protected $updateMethod = 'put';

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
