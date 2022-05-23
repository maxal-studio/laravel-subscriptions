<?php

namespace Rinvex\Subscriptions\Tests\Unit;

use Rinvex\Subscriptions\Models\PlanSubscription;
use Rinvex\Subscriptions\Tests\TestCase;

class PlanSubscriptionTest extends TestCase
{

  /**
   * @test
   */
  public function subscription_creation()
  {
    $plan = $this->model_helper->plan_create();
    $this->model_helper->plan_subscription_create($plan->id);
    $this->assertEquals(1, PlanSubscription::count());
  }
}
