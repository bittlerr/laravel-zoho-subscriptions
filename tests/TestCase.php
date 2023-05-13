<?php

namespace ZohoSubscriptions\Tests;

use ZohoSubscriptions\Providers\ZohoSubscriptionsServiceProvider;
use Orchestra\Testbench\TestCase as Orchestra;

abstract class TestCase extends Orchestra
{
    public function setUp(): void
    {
        parent::setUp();

        $this->setupEnvironment(app());
    }

    /**
     * @param \Illuminate\Foundation\Application $app
     *
     * @return array
     */
    protected function getPackageProviders($app)
    {
        return [
            ZohoSubscriptionsServiceProvider::class,
        ];
    }

    /**
     * Set up the environment.
     *
     * @param \Illuminate\Foundation\Application $app
     */
    protected function setupEnvironment($app)
    {
        if (env('USE_LIVE_API')) {
            $app['config']->set('zoho.oauth2.clientId');
            $app['config']->set('zoho.oauth2.clientSecret');
        } else {
        }
    }
}
