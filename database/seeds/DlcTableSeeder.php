<?php

use Illuminate\Database\Seeder;

class DlcTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (config('app.dlc_enabled')) {
            factory(\App\Models\Dlc::class, 500)->create();
        }
    }
}
