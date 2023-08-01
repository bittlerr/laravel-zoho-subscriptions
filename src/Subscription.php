<?php

namespace ZohoSubscriptions;

use ZohoSubscriptions\Support\Model;

class Subscription extends Model
{
    protected $insertResource = 'ZohoSubscriptions\Requests\StoreSubscription';
    protected $updateResource = 'ZohoSubscriptions\Requests\UpdateSubscription';

    protected $endPoint = 'subscriptions';

    protected $allowedMethods = ['find', 'get', 'post', 'delete'];

    protected $apiMultipleDataField = 'subscriptions';

    public function getApiMultipleDataField()
    {
        return $this->apiMultipleDataField;
    }

    public function cancel(bool $cancel_at_end = false)
    {
        if ($this->exists()) {
            return $this->newQuery()
                ->sendRequest('post', ['subscriptions/' . $this->subscription['subscription_id'] . '/cancel', ['cancel_at_end' => $cancel_at_end]])
                ->successful();
        }
    }
}
