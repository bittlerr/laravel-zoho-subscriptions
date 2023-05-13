<?php

namespace ZohoSubscriptions\Facades;

use Illuminate\Support\Facades\Facade;

class ZohoSubscriptions extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'zoho-subscriptions';
    }
}
