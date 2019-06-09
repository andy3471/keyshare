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
        factory(App\Dlc::class, 500)->create();
    }
}
