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
    $feature = $this->model_helper->plan_feature_create($plan->id);
    $this->assertModelExists($plan->getFeatureBySlug('something'));
  }
}
