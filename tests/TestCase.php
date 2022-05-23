<?php

namespace Rinvex\Subscriptions\Tests;

use Illuminate\Foundation\Testing\RefreshDatabase;

class TestCase extends \Orchestra\Testbench\TestCase
{
  use RefreshDatabase;

  protected function getPackageProviders($app)
  {
    return [\Rinvex\Subscriptions\Providers\SubscriptionsServiceProvider::class];
  }

  protected function getEnvironmentSetUp($app)
  {
    // Setup default database to use sqlite :memory:
    $app['config']->set('database.default', 'testbench');
    $app['config']->set('database.connections.testbench', [
      'driver'   => 'sqlite',
      'database' => ':memory:',
      'prefix'   => '',
    ]);
  }

  public function setUp(): void
  {
    parent::setUp();
    $this->artisan(
      'migrate',
      ['--database' => 'testbench']
    )->run();
  }
}
