<?php

namespace SebenzaTaxi\LaravelAppInit\Providers;

use Illuminate\Support\ServiceProvider;
use SebenzaTaxi\LaravelAppInit\Console\Commands\ApplicationInitialisationHandlerCommand;

class AppInitServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        // Migrations
        $this->loadMigrationsFrom(__DIR__ . '/../../database/migrations');
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Console command
        if ($this->app->runningInConsole()) {
            $this->commands([
                ApplicationInitialisationHandlerCommand::class
            ]);
        }
    }
}