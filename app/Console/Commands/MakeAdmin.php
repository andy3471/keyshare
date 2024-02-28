<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;

class MakeAdmin extends Command
{
    protected $signature = 'admin:make {user=admin}';

    protected $description = 'Command description';

    public function handle(): void
    {
        $user = User::where('email', $this->argument('user'))->first();

        if (! $user) {
            $this->warn('User not found');

            return;
        }

        $user->update([
            'admin' => 1,
            'approved' => 1,
        ]);

        $this->info("{$user->name} is now an admin");
    }
}
