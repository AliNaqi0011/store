<?php

namespace Database\Seeders;

use App\Models\Plan;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PlanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $plans = [
            [
                'name' => 'Business Plan',
                'slug' => 'business-plan',
                'stripe_plan' => 'price_1OURlpBM5xKzBdxGTa5kfoag',
                'price' => 20,
                'description' => 'Business Plan'
            ],
            [
                'name' => 'Premium',
                'slug' => 'premium',
                'stripe_plan' => 'price_1OURlpBM5xKzBdxGTa5kfoag',
                'price' => 20,
                'description' => 'Premium'
            ]
        ];

        foreach ($plans as $plan) {
            Plan::create($plan);
        }
    }
}
