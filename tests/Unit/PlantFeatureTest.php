<?php

namespace Rinvex\Subscriptions\Tests\Unit;

use Rinvex\Subscriptions\Models\Plan;
use Rinvex\Subscriptions\Models\PlanFeature;
use Rinvex\Subscriptions\Tests\TestCase;

class PlantFeatureTest extends TestCase
{
  /**
   * @test
   */
  public function feature_creation()
  {
    $plan = $this->model_helper->plan_create();
    $this->model_helper->plan_feature_create($plan->id);
    $this->assertEquals(1, PlanFeature::count());
  }


  /**
   * @test
   */
  public function feature_belongs_to_plan()
  {
    $plan = $this->model_helper->plan_create();
    $feature = $this->model_helper->plan_feature_create($plan->id);

    // Method 1: Test by count that a feature has a parent relationship with plan
    $this->assertEquals(1, $feature->plan->count());

    // Method 2: 
    $this->assertInstanceOf(Plan::class, $feature->plan);
  }

  /**
   * @test
   */
  public function a_plan_feature_has_usages()
  {
    $plan    = $this->model_helper->plan_create();
    $feature = $this->model_helper->plan_feature_create($plan->id);
    $subscription = $this->model_helper->plan_subscription_create($plan->id);

    $usage = $this->model_helper->plan_subscription_usage_create($feature->id, $subscription->id);
    // Method 1: A feature exists in a plan's feature collections.
    $this->assertTrue($feature->usages->contains($usage));

    // Method 2: Count that a plan features collection exists.
    $this->assertEquals(1, $feature->usages->count());

    // Method 3: features are related to posts and is a collection instance.
    $this->assertInstanceOf('Illuminate\Database\Eloquent\Collection', $feature->usages);
  }

  /**
   * @test
   */
  public function reset_date()
  {
    $plan = $this->model_helper->plan_create();
    $feature = $this->model_helper->plan_feature_create($plan->id);
    $now = now();
    $reset_date = $feature->getResetDate($now);
    $this->assertEquals($now->addMonth(1), $reset_date);
  }
}
