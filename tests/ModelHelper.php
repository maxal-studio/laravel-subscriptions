<?php

namespace Rinvex\Subscriptions\Tests;

use Rinvex\Subscriptions\Models\Plan;
use Rinvex\Subscriptions\Models\PlanFeature;
use Rinvex\Subscriptions\Models\PlanSubscription;
use Rinvex\Subscriptions\Models\PlanSubscriptionUsage;

class ModelHelper
{

  /**
   * @return Plan
   */
  public function plan_create(...$attributes): Plan
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
      'invoice_period' => $attributes[0] ?? 1,
      'invoice_interval' => $attributes[1] ?? 'month',
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

  /**
   * @return Plan
   */
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



  /**
   * @param $plan_id
   * @return PlanFeature
   */
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
        'resettable_interval' => 'month',
        'sort_order' => 1,
      ]
    );

    return $plan_feature;
  }

  /**
   * @param $plan_id
   * @return PlanSubscription
   */
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


  /**
   * @param $plan_id
   * @return PlanSubscription
   */
  public function plan_subscription_ended_create($plan_id): PlanSubscription
  {
    $plan_subscription = PlanSubscription::create([
      'subscriber_id' => 1,
      'subscriber_type' => 'App\\User',
      'plan_id' => $plan_id,
      'slug' => 'something',
      'name' => 'something',
      'description' => 'something',
      'trial_ends_at' => now()->addDays(7),
      'starts_at' => now()->subDays(14),
      'ends_at' => now()->subDays(7),
      'cancels_at' => null,
      'canceled_at' => null,
    ]);

    return $plan_subscription;
  }

  /**
   * @param $plan_id
   * @return PlanSubscription
   */
  public function plan_subscription_inactive_create($plan_id): PlanSubscription
  {
    $plan_subscription = PlanSubscription::create([
      'subscriber_id' => 1,
      'subscriber_type' => 'App\\User',
      'plan_id' => $plan_id,
      'slug' => 'something',
      'name' => 'something',
      'description' => 'something',
      'trial_ends_at' => now()->subDays(7),
      'starts_at' => now(),
      'ends_at' => now()->subDays(7),
      'cancels_at' => null,
      'canceled_at' => null,
    ]);

    return $plan_subscription;
  }
  /**
   * @param $feature_id
   * @param $subscription_id
   * @return PlanSubscriptionUsage
   */
  public function plan_subscription_usage_create($feature_id, $subscription_id): PlanSubscriptionUsage
  {
    $plan_subscription = PlanSubscriptionUsage::create([
      'subscription_id'   => $subscription_id,
      'feature_id'        => $feature_id,
      'used'              => 1,
      'valid_until'       => now()->addMonth(1),
    ]);

    return $plan_subscription;
  }

  /**
   * @param $feature_id
   * @param $subscription_id
   * @return PlanSubscriptionUsage
   */
  public function plan_subscription_usage_expired_create($feature_id, $subscription_id): PlanSubscriptionUsage
  {
    $plan_subscription = PlanSubscriptionUsage::create([
      'subscription_id'   => $subscription_id,
      'feature_id'        => $feature_id,
      'used'              => 1,
      'valid_until'       => now()->subMonth(1),
    ]);

    return $plan_subscription;
  }
}
