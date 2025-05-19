<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Key;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Artisan;

class KeysTableSeeder extends Seeder
{
    public function run(): void
    {
        Key::factory(500)->create();
        Artisan::call('karma:calculate');
    }
}
