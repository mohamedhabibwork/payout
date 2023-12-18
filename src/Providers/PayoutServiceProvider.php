<?php

namespace Habib\Payout\Providers;

use Habib\Payout\HyperSplitService;
use Illuminate\Support\ServiceProvider;

class PayoutServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/../../config/payout.php', 'payout');

        $this->app->bind('hyper_split', function($app) {
            return new HyperSplitService($app['config']);
        });
    }

    public function boot()
    {
        if ($this->app->runningInConsole()) {

            $this->publishes([
                __DIR__.'/../../config/payout.php' => config_path('payout.php'),
            ], 'config');

        }
    }
}
