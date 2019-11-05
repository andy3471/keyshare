<?php

use Illuminate\Database\Seeder;
use App\Subscription;

class SubscriptionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Subscription::class, 20)->create();
    }
}


