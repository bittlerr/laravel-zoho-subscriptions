<?php

namespace ZohoSubscriptions\Requests;

use MacsiDigital\API\Support\PersistResource;

class StoreSubscription extends PersistResource
{
    protected $persistAttributes = [
        'id' => '',
        'customer_id' => 'nullable|string',
        'payment_terms' => 'nullable|integer',
        'payment_terms_label' => 'nullable|string',
        'custom_fields' => 'nullable|array',
        'card_id' => 'nullable|string',
        'starts_at' => 'nullable|string',
        'exchange_rate' => 'nullable|integer',
        'place_of_supply' => 'nullable|string',
        'plan' => 'nullable|object',
        'addons' => 'nullable|array',
        'coupon_code' => 'nullable|string',
        'auto_collect' => 'nullable|bool',
        'reference_id' => 'nullable|string',
        'salesperson_name' => 'nullable|string',
        'payment_gateways' => 'nullable|array',
        'create_backdated_invoice' => 'nullable|bool',
        'can_charge_setup_fee_immediately' => 'nullable|bool',
        'template_id' => 'nullable|string',
        'cfdi_usage' => 'nullable|string',
        'allow_partial_payments' => 'nullable|bool',
    ];
}
