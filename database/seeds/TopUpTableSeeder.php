<?php

use Illuminate\Database\Seeder;
use App\TopUp;

class TopUpTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\TopUp::class, 50)->create();
    }
}
