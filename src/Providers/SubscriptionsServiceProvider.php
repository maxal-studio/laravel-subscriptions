<?php

declare(strict_types=1);

namespace MaxAl\Subscriptions\Providers;

use MaxAl\Subscriptions\Models\Plan;
use Illuminate\Support\ServiceProvider;
use MaxAl\Subscriptions\Models\PlanFeature;
use MaxAl\Subscriptions\Models\PlanSubscription;
use MaxAl\Subscriptions\Models\PlanSubscriptionUsage;
use MaxAl\Subscriptions\Console\Commands\MigrateCommand;
use MaxAl\Subscriptions\Console\Commands\PublishCommand;
use MaxAl\Subscriptions\Console\Commands\RollbackCommand;

class SubscriptionsServiceProvider extends ServiceProvider
{

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__ . '/../../config/config.php', 'maxal.subscriptions');
    }

    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot(): void
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__ . '/../../config/config.php' => $this->app->configPath('maxal/subscriptions.php'),
            ], 'config');

            $this->publishes([
                __DIR__ . '/../../database/migrations' => $this->app->databasePath('migrations'),
            ], 'migrations');
            $this->commands([
                MigrateCommand::class,
                PublishCommand::class,
                RollbackCommand::class,
            ]);
        }
    }
}
