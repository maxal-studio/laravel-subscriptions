<?php

namespace MaxAl\Subscriptions\Tests\Feature;

use MaxAl\Subscriptions\Models\PlanFeature;
use MaxAl\Subscriptions\Tests\TestCase;

class PlantFeatureTest extends TestCase
{
  /**
   * @test
   */
  public function get_feature_by_slug()
  {
    $plan = $this->model_helper->plan_create();
    $this->model_helper->plan_feature_create($plan->id);
    $this->assertInstanceOf(PlanFeature::class, $plan->getFeatureBySlug('something'));
  }
}
