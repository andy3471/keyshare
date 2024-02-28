<?php

namespace Database\Seeders;

use App\Models\Subscription;
use Illuminate\Database\Seeder;

class SubscriptionTableSeeder extends Seeder
{
    public function run(): void
    {
        Subscription::factory(20)->create();
    }
}
