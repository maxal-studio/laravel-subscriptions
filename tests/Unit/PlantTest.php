<?php

namespace Rinvex\Subscriptions\Tests\Unit;

use Rinvex\Subscriptions\Models\Plan;
use Rinvex\Subscriptions\Tests\TestCase;

class PlantTest extends TestCase
{
  /**
   * @test
   */
  public function test_plan_creation()
  {
    $plan = Plan::create([
      'slug' => 'something',
      'name' => 'something',
      'description' => 'something',
      'is_active' => true,
      'price' => 10,
      'signup_fee' => 10,
      'currency' => 'USD',
      'trial_period' => 1,
      'trial_interval' => 'month',
      'invoice_period' => 1,
      'invoice_interval' => 'month',
      'grace_period' => 1,
      'grace_interval' => 'month',
      'prorate_day' => 1,
      'prorate_period' => 1,
      'prorate_extend_due' => 1,
      'active_subscribers_limit' => 1,
      'sort_order' => 1,
    ]);
    $this->assertNotNull($plan);
    $this->assertEquals(1, Plan::count());
  }
}
