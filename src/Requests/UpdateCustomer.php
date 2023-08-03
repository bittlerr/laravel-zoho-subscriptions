<?php

namespace ZohoSubscriptions\Requests;

use MacsiDigital\API\Support\PersistResource;

class UpdateCustomer extends PersistResource
{
    protected $persistAttributes = [
        'id' => '',
        'display_name' => 'sometimes|string',
        'email' => 'sometimes|string',
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
        'billing_address.attention' => 'nullable|string',
        'billing_address.street' => 'nullable|string',
        'billing_address.city' => 'nullable|string',
        'billing_address.state' => 'nullable|string',
        'billing_address.zip' => 'nullable|string',
        'billing_address.country' => 'nullable|string',
        'billing_address.state_code' => 'nullable|string',
        'billing_address.fax' => 'nullable|string',
        'shipping_address.attention' => 'nullable|string',
        'shipping_address.street' => 'nullable|string',
        'shipping_address.city' => 'nullable|string',
        'shipping_address.state' => 'nullable|string',
        'shipping_address.zip' => 'nullable|string',
        'shipping_address.country' => 'nullable|string',
        'shipping_address.state_code' => 'nullable|string',
        'shipping_address.fax' => 'nullable|string',
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
        'default_templates.invoice_template_id' => 'sometimes|required|string',
        'default_templates.creditnote_template_id' => 'sometimes|required|string',
        'custom_fields.*.label' => 'sometimes|required|string',
        'custom_fields.*.value' => 'sometimes|required|string',
    ];
}
