<?php

namespace Database\Seeders;

use App\Models\Dlc;
use Illuminate\Database\Seeder;

class DlcTableSeeder extends Seeder
{
    public function run(): void
    {
        if (config('app.dlc_enabled')) {
            Dlc::factory(50)->create();
        }
    }
}
