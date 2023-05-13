<?php

namespace ZohoSubscriptions;

use ZohoSubscriptions\Support\Model;

class Subscription extends Model
{
    protected $insertResource = 'ZohoSubscriptions\Requests\StoreSubscription';
    protected $updateResource = 'ZohoSubscriptions\Requests\UpdateSubscription';

    protected $endPoint = 'subscriptions';

    protected $allowedMethods = ['get', 'post', 'delete'];

    protected $apiMultipleDataField = 'subscriptions';

    public function getApiMultipleDataField()
    {
        return $this->apiMultipleDataField;
    }

    public function customer()
    {
        return $this->hasOne(Customer::class);
    }
}
