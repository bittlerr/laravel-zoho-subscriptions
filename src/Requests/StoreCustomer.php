<?php

namespace ZohoSubscriptions\Requests;

use MacsiDigital\API\Support\PersistResource;

class StoreCustomer extends PersistResource
{
    protected $persistAttributes = [
        'id' => '',
        'display_name' => 'required|string',
        'email' => 'required|string',
        'salutation' => 'nullable|string',
        'first_name' => 'nullable|string',
        'last_name' => 'nullable|string',
        'tags' => 'nullable|array',
        'company_name' => 'nullable|string',
        'phone' => 'nullable|string',
        'mobile' => 'nullable|string',
        'department' => 'nullable|string',
        'designation' => 'nullable|string',
        'website' => 'nullable|string',
        'billing_address' => 'nullable|object',
        'shipping_address' => 'nullable|object',
        'payment_terms' => 'nullable|integer',
        'payment_terms_label' => 'nullable|string',
        'currency_code' => 'nullable|string',
        'ach_supported' => 'nullable|bool',
        'twitter' => 'nullable|string',
        'facebook' => 'nullable|string',
        'skype' => 'nullable|string',
        'notes' => 'nullable|string',
        'is_portal_enabled' => 'nullable|bool',
        'gst_no' => 'nullable|string',
        'gst_treatment' => 'nullable|string',
        'place_of_contact' => 'nullable|string',
        'vat_treatment' => 'nullable|string',
        'tax_reg_no' => 'nullable|string',
        'tds_tax_id' => 'nullable|string',
        'tax_treatment' => 'nullable|string',
        'tax_regime' => 'nullable|string',
        'tax_id' => 'nullable|string',
        'tax_authority_id' => 'nullable|string',
        'tax_authority_name' => 'nullable|string',
        'tax_exemption_id' => 'nullable|string',
        'tax_exemption_code' => 'nullable|string',
        'is_tds_registered' => 'nullable|bool',
        'vat_reg_no' => 'nullable|string',
        'is_taxable' => 'nullable|bool',
        'default_templates' => 'nullable|object',
        'custom_fields' => 'nullable|array',
    ];
}
