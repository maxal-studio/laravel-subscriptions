<?php

namespace MaxAl\Subscriptions\Tests\Feature;

use MaxAl\Subscriptions\Tests\TestCase;

class PlanFeatureUsageTest extends TestCase
{
  /**
   * @test
   */
  public function record_usage()
  {
    $plan = $this->model_helper->plan_create();
    $subscription = $this->model_helper->plan_subscription_create($plan->id);
    $feature = $this->model_helper->plan_feature_create($plan->id);
    $subscription->recordFeatureUsage('something');
    $usage =  $subscription->getFeatureUsage('something');
    $this->assertEquals(1, $usage);
  }

  /**
   * @test
   */
  public function reduce_usage()
  {
    $plan = $this->model_helper->plan_create();
    $subscription = $this->model_helper->plan_subscription_create($plan->id);
    $feature = $this->model_helper->plan_feature_create($plan->id);

    $subscription->recordFeatureUsage('something');
    $usage =  $subscription->getFeatureUsage('something');
    $this->assertEquals(1, $usage);

    $subscription->recordFeatureUsage('something');
    $usage =  $subscription->getFeatureUsage('something');
    $this->assertEquals(2, $usage);

    $subscription->reduceFeatureUsage('something');
    $usage =  $subscription->getFeatureUsage('something');
    $this->assertEquals(1, $usage);
  }

  /**
   * @test
   */
  public function get_feature_remainings()
  {
    $plan = $this->model_helper->plan_create();
    $subscription = $this->model_helper->plan_subscription_create($plan->id);
    $feature = $this->model_helper->plan_feature_create($plan->id);

    $subscription->recordFeatureUsage('something');
    $reamainings =  $subscription->getFeatureRemainings('something');
    $this->assertEquals(9, $reamainings);
  }
}
