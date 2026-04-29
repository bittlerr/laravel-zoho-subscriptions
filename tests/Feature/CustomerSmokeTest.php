<?php

namespace ZohoSubscriptions\Tests\Feature;

use MacsiDigital\API\Contracts\Relation;
use ZohoSubscriptions\Customer;
use ZohoSubscriptions\Subscription;
use ZohoSubscriptions\Support\Entry;
use ZohoSubscriptions\Tests\TestCase;

class CustomerSmokeTest extends TestCase
{
    public function test_customer_sets_and_gets_attributes(): void
    {
        $customer = new Customer(null, [
            'customer_id' => 'abc-123',
            'display_name' => 'Acme Co',
            'email' => 'billing@acme.example',
        ]);

        $this->assertSame('abc-123', $customer->customer_id);
        $this->assertSame('Acme Co', $customer->display_name);
    }

    public function test_customer_toArray_includes_attributes(): void
    {
        $customer = new Customer(null, ['customer_id' => 'abc-123']);

        $this->assertArrayHasKey('customer_id', $customer->toArray());
    }

    public function test_customer_subscriptions_relation_returns_relation(): void
    {
        $customer = new Customer(null, []);

        $this->assertInstanceOf(Relation::class, $customer->subscriptions());
    }

    public function test_subscription_model_instantiates(): void
    {
        $subscription = new Subscription(null, ['subscription_id' => 'sub-1', 'status' => 'live']);

        $this->assertSame('sub-1', $subscription->subscription_id);
        $this->assertSame('live', $subscription->status);
    }

    // Regression: guards the $dates fix in macsidigital/laravel-api-client.
    // Setting a truthy non-date attribute used to hit in_array($key, null)
    // inside Eloquent's isDateAttribute() on PHP 8+.
    public function test_setting_truthy_attribute_does_not_explode_on_php8(): void
    {
        $customer = new Customer(null, []);
        $customer->reference_id = 'ref-42';

        $this->assertSame('ref-42', $customer->reference_id);
    }

    // Regression: the 'zoho-subscriptions' container binding used to point
    // at a Contracts\ZohoSubscriptions interface that itself extended a
    // Facade class — syntactically broken but unreferenced until L12's
    // optimized autoloader started resolving it.
    public function test_zoho_subscriptions_binding_resolves_to_entry(): void
    {
        $this->assertInstanceOf(Entry::class, $this->app->make('zoho-subscriptions'));
    }
}
