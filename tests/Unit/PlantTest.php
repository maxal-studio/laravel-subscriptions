<?php

namespace Rinvex\Subscriptions\Tests\Unit;

use Rinvex\Subscriptions\Models\Plan;
use Rinvex\Subscriptions\Tests\TestCase;

class PlantTest extends TestCase
{
  /**
   * @test
   */
  public function plan_creation()
  {
    $plan = $this->model_helper->plan_create();
    $this->assertNotNull($plan);
    $this->assertEquals(1, Plan::count());
  }

  /** @test */
  public function a_plan_has_plan_features()
  {
    $plan    = $this->model_helper->plan_create();
    $feature = $this->model_helper->plan_feature_create($plan->id);

    // Method 1: A feature exists in a plan's feature collections.
    $this->assertTrue($plan->features->contains($feature));

    // Method 2: Count that a plan features collection exists.
    $this->assertEquals(1, $plan->features->count());

    // Method 3: features are related to posts and is a collection instance.
    $this->assertInstanceOf('Illuminate\Database\Eloquent\Collection', $plan->features);
  }

  /** @test */
  public function a_plan_has_plan_subscriptions()
  {
    $plan    = $this->model_helper->plan_create();
    $subscription = $this->model_helper->plan_subscription_create($plan->id);

    // Method 1: A subscription exists in a plan's subscription collections.
    $this->assertTrue($plan->subscriptions->contains($subscription));

    // Method 2: Count that a plan subscriptions collection exists.
    $this->assertEquals(1, $plan->subscriptions->count());

    // Method 3: subscriptions are related to posts and is a collection instance.
    $this->assertInstanceOf('Illuminate\Database\Eloquent\Collection', $plan->subscriptions);
  }

  /**
   * @test
   */
  public function plan_is_free()
  {
    $plan = $this->model_helper->free_plan_create();
    //Free Plan
    $this->assertTrue($plan->isFree());
  }

  /**
   * @test
   */
  public function plan_has_trial()
  {
    $plan = $this->model_helper->plan_create();
    //Plan has trial
    $this->assertTrue($plan->hasTrial());
  }

  /**
   * @test
   */
  public function activate_plan()
  {
    $plan = $this->model_helper->plan_create();

    $plan->activate();
    //Plan has trial
    $this->assertTrue($plan->is_active);
  }

  /**
   * @test
   */
  public function deactivate_plan()
  {
    $plan = $this->model_helper->free_plan_create();

    $plan->deactivate();
    //Plan has trial
    $this->assertFalse($plan->is_active);
  }
}
