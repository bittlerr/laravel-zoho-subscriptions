<?php

namespace ZohoSubscriptions;

use ZohoSubscriptions\Support\Model;

class Invoice extends Model
{
    protected $endPoint = 'invoices';

    protected $apiDataField = 'invoice';

    protected $allowedMethods = ['find', 'get'];

    protected $updateMethod = 'put';

    protected $apiMultipleDataField = 'invoices';

    public function getApiMultipleDataField()
    {
        return $this->apiMultipleDataField;
    }

    public function void()
    {
        if ($this->exists()) {
            return $this->newQuery()
                ->sendRequest('post', ['invoices/' . $this->invoice_id . '/void', ['reason' => 'void']])
                ->successful();
        }
    }
}
