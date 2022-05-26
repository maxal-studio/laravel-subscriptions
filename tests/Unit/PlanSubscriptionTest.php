<?php

namespace MaxAl\Subscriptions\Tests\Unit;

use LogicException;
use MaxAl\Subscriptions\Models\Plan;
use MaxAl\Subscriptions\Models\PlanSubscription;
use MaxAl\Subscriptions\Tests\TestCase;

class PlanSubscriptionTest extends TestCase
{

  /**
   * @test
   */
  public function subscription_creation()
  {
    $plan = $this->model_helper->plan_create();
    $subscription =  $this->model_helper->plan_subscription_create($plan->id);
    $this->assertNotNull($subscription);
    $this->assertEquals(1, PlanSubscription::count());
  }


  /**
   * @test
   */
  public function subscription_delete()
  {
    $plan = $this->model_helper->plan_create();
    $subscription = $this->model_helper->plan_subscription_create($plan->id);
    $subscription->delete();
    $this->assertEquals(0, PlanSubscription::count());
  }


  /**
   * @test
   */
  public function subscription_belongs_to_plan()
  {
    $plan = $this->model_helper->plan_create();
    $subscription =  $this->model_helper->plan_subscription_create($plan->id);

    // Method 1: Test by count that a subscription has a parent relationship with plan
    $this->assertEquals(1, $subscription->plan->count());

    // Method 2: 
    $this->assertInstanceOf(Plan::class, $subscription->plan);
  }

  /**
   * @test
   */
  public function subscription_has_usages()
  {
    $plan = $this->model_helper->plan_create();
    $subscription =  $this->model_helper->plan_subscription_create($plan->id);
    $feature = $this->model_helper->plan_feature_create($plan->id);
    $usage = $this->model_helper->plan_subscription_usage_create($subscription->id, $feature->id);


    // Method 1: A usage exists in a plan's subscription collections.
    $this->assertTrue($subscription->usages->contains($usage));

    // Method 2: Count that a usages collection exists.
    $this->assertEquals(1, $subscription->usages->count());

    // Method 3: usages are related to subscription and is a collection instance.
    $this->assertInstanceOf('Illuminate\Database\Eloquent\Collection', $subscription->usages);
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

  /**
   * @test
   */
  public function renew_plan()
  {
    $plan = $this->model_helper->plan_create();
    $subscription = $this->model_helper->plan_subscription_ended_create($plan->id);
    $this->assertTrue($subscription->ended());

    $subscription = $subscription->renew();
    $this->assertFalse($subscription->ended());
  }

  /**
   * @test
   */
  public function renew_exception()
  {
    $plan = $this->model_helper->plan_create();
    $subscription = $this->model_helper->plan_subscription_ended_create($plan->id);
    $subscription->cancel();
    $this->expectException(LogicException::class);
    $subscription = $subscription->renew();
  }
}
