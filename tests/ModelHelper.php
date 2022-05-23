<?php

namespace Rinvex\Subscriptions\Tests;

use Rinvex\Subscriptions\Models\Plan;
use Rinvex\Subscriptions\Models\PlanFeature;
use Rinvex\Subscriptions\Models\PlanSubscription;

class ModelHelper
{
  public function plan_create(): Plan
  {
    $plan = Plan::create([
      'slug' => 'something',
      'name' => 'something',
      'description' => 'something',
      'is_active' => false,
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

    return $plan;
  }

  public function free_plan_create(): Plan
  {
    $plan = Plan::create([
      'slug' => 'something',
      'name' => 'something',
      'description' => 'something',
      'is_active' => true,
      'price' => 0,
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

    return $plan;
  }


  public function plan_feature_create($plan_id): PlanFeature
  {
    $plan_feature = PlanFeature::create(
      [
        'plan_id' => $plan_id,
        'slug' => 'something',
        'name' => 'somthing',
        'description' => 'something',
        'value' => 'something',
        'resettable_period' => 1,
        'resettable_interval' => 'day',
        'sort_order' => 1,
      ]
    );

    return $plan_feature;
  }

  public function plan_subscription_create($plan_id): PlanSubscription
  {
    $plan_subscription = PlanSubscription::create([
      'subscriber_id' => 1,
      'subscriber_type' => 'App\\User',
      'plan_id' => $plan_id,
      'slug' => 'something',
      'name' => 'something',
      'description' => 'something',
      'trial_ends_at' => now()->addDays(7),
      'starts_at' => now(),
      'ends_at' => now()->addDays(7),
      'cancels_at' => null,
      'canceled_at' => null,
    ]);

    return $plan_subscription;
  }
}
