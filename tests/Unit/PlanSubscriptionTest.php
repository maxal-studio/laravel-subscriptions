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

  /**
   * @test
   */
  public function subscription_ended()
  {
    $plan = $this->model_helper->plan_create();
    $subscription = $this->model_helper->plan_subscription_ended_create($plan->id);
    $this->assertTrue($subscription->ended());
  }

  /**
   * @test
   */
  public function subscription_on_trial()
  {
    $plan = $this->model_helper->plan_create();
    $subscription = $this->model_helper->plan_subscription_create($plan->id);
    $this->assertTrue($subscription->onTrial());
  }

  /**
   * @test
   */
  public function subscription_active()
  {
    $plan = $this->model_helper->plan_create();
    $subscription = $this->model_helper->plan_subscription_create($plan->id);
    $this->assertTrue($subscription->active());
  }

  /**
   * @test
   */
  public function subscription_inactive()
  {
    $plan = $this->model_helper->plan_create();
    $subscription = $this->model_helper->plan_subscription_inactive_create($plan->id);
    $this->assertTrue($subscription->inactive());
  }

  /**
   * @test
   */
  public function cancel_subscription()
  {
    $plan = $this->model_helper->plan_create();
    $subscription = $this->model_helper->plan_subscription_create($plan->id);
    $subscription->cancel();
    $this->assertTrue($subscription->canceled());
  }

  /**
   * @test
   */
  public function change_plan()
  {
    $plan = $this->model_helper->plan_create();
    $plan2 = $this->model_helper->plan_create(1, 'week');
    $subscription = $this->model_helper->plan_subscription_create($plan->id);
    $subscription = $subscription->changePlan($plan2);
    $this->assertEquals(1, $subscription->ends_at->diffInWeeks($subscription->starts_at));
  }
}
