<?php

declare(strict_types=1);

namespace MaxAl\Subscriptions\Providers;

use MaxAl\Subscriptions\Models\Plan;
use Illuminate\Support\ServiceProvider;
use Rinvex\Support\Traits\ConsoleTools;
use MaxAl\Subscriptions\Models\PlanFeature;
use MaxAl\Subscriptions\Models\PlanSubscription;
use MaxAl\Subscriptions\Models\PlanSubscriptionUsage;
use MaxAl\Subscriptions\Console\Commands\MigrateCommand;
use MaxAl\Subscriptions\Console\Commands\PublishCommand;
use MaxAl\Subscriptions\Console\Commands\RollbackCommand;

class SubscriptionsServiceProvider extends ServiceProvider
{
    use ConsoleTools;

    /**
     * The commands to be registered.
     *
     * @var array
     */
    protected $commands = [
        MigrateCommand::class => 'command.maxal.subscriptions.migrate',
        PublishCommand::class => 'command.maxal.subscriptions.publish',
        RollbackCommand::class => 'command.maxal.subscriptions.rollback',
    ];

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register(): void
    {
        $this->mergeConfigFrom(realpath(__DIR__ . '/../../config/config.php'), 'maxal.subscriptions');

        // Bind eloquent models to IoC container
        $this->registerModels([
            'maxal.subscriptions.plan' => Plan::class,
            'maxal.subscriptions.plan_feature' => PlanFeature::class,
            'maxal.subscriptions.plan_subscription' => PlanSubscription::class,
            'maxal.subscriptions.plan_subscription_usage' => PlanSubscriptionUsage::class,
        ]);

        // Register console commands
        $this->registerCommands($this->commands);
        $this->app->register('Rinvex\Support\Providers\SupportServiceProvider');
    }

    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot(): void
    {
        // Publish Resources
        $this->publishesConfig('maxal/laravel-subscriptions');
        $this->publishesMigrations('maxal/laravel-subscriptions');
        !$this->autoloadMigrations('maxal/laravel-subscriptions') || $this->loadMigrationsFrom(__DIR__ . '/../../database/migrations');
    }
}
