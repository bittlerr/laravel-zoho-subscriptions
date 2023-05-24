<?php

namespace ZohoSubscriptions;

use ZohoSubscriptions\Support\Model;

class HostedSubscription extends Model
{
    protected $insertResource = 'ZohoSubscriptions\Requests\StoreSubscription';

    protected $endPoint = 'hostedpages/newsubscription';

    protected $allowedMethods = ['get', 'post'];

    protected $apiMultipleDataField = 'subscriptions';

    public function getApiMultipleDataField()
    {
        return $this->apiMultipleDataField;
    }
}
