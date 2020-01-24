<?php

use Illuminate\Database\Seeder;
use App\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\User::class)->make([
            'email' => 'admin@admin.com',
            'admin' => '1'
        ]);

        factory(App\User::class, 20)->create();
    }
}
