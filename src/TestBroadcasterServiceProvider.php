<?php

namespace Jlndk\TestBroadcaster;

use Illuminate\Foundation\Application;
use Illuminate\Broadcasting\BroadcastManager;
use Illuminate\Support\ServiceProvider;

class TestBroadcasterServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(TestBroadcaster::class, function () {
            return new TestBroadcaster();
        });
    }

    /**
     * Bootstrap services.
     *
     * @param BroadcastManager $broadcastManager
     */
    public function boot(BroadcastManager $broadcastManager)
    {
        $broadcastManager->extend('test', function (Application $app, array $config) {
            return $app->make(TestBroadcaster::class);
        });
    }
}
