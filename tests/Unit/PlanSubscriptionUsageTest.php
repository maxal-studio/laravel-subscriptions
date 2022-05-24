<?php

namespace Rinvex\Subscriptions\Tests\Unit;

use Rinvex\Subscriptions\Models\PlanFeature;
use Rinvex\Subscriptions\Models\PlanSubscription;
use Rinvex\Subscriptions\Models\PlanSubscriptionUsage;
use Rinvex\Subscriptions\Tests\TestCase;

class PlanSubscriptionUsageTest extends TestCase
{

  /**
   * @test
   */
  public function plan_subscription_usage_create()
  {
    $plan = $this->model_helper->plan_create();
    $subscription =  $this->model_helper->plan_subscription_create($plan->id);
    $feature = $this->model_helper->plan_feature_create($plan->id);
    $this->model_helper->plan_subscription_usage_create($subscription->id, $feature->id);

    $this->assertEquals(1, PlanSubscriptionUsage::count());
  }

  /**
   * @test
   */
  public function usage_belongs_to_feature()
  {
    $plan = $this->model_helper->plan_create();
    $subscription =  $this->model_helper->plan_subscription_create($plan->id);
    $feature = $this->model_helper->plan_feature_create($plan->id);
    $usage = $this->model_helper->plan_subscription_usage_create($subscription->id, $feature->id);

    // Method 1: Test by count that a usage has a parent relationship with feature
    $this->assertEquals(1, $usage->feature->count());

    // Method 2: 
    $this->assertInstanceOf(PlanFeature::class, $usage->feature);
  }


  /**
   * @test
   */
  public function usage_belongs_to_subscription()
  {
    $plan = $this->model_helper->plan_create();
    $subscription =  $this->model_helper->plan_subscription_create($plan->id);
    $feature = $this->model_helper->plan_feature_create($plan->id);
    $usage = $this->model_helper->plan_subscription_usage_create($subscription->id, $feature->id);

    // Method 1: Test by count that a usage has a parent relationship with subscription
    $this->assertEquals(1, $usage->subscription->count());

    // Method 2: 
    $this->assertInstanceOf(PlanSubscription::class, $usage->subscription);
  }

  /**
   * @test
   */
  public function usage_not_expired()
  {
    $plan = $this->model_helper->plan_create();
    $subscription =  $this->model_helper->plan_subscription_create($plan->id);
    $feature = $this->model_helper->plan_feature_create($plan->id);
    $usage = $this->model_helper->plan_subscription_usage_create($subscription->id, $feature->id);

    $this->assertFalse($usage->expired());
  }


  /**
   * @test
   */
  public function usage_expired()
  {
    $plan = $this->model_helper->plan_create();
    $subscription =  $this->model_helper->plan_subscription_create($plan->id);
    $feature = $this->model_helper->plan_feature_create($plan->id);
    $usage = $this->model_helper->plan_subscription_usage_expired_create($subscription->id, $feature->id);

    $this->assertTrue($usage->expired());
  }
}
