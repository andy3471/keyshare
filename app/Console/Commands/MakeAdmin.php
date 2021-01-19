<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\User;

class MakeAdmin extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'admin:make {user=admin}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $user = User::where('email',$this->argument('user')) -> first();

        if($user) {
            $user->admin = 1;
            $user->approved = 1;
            $user->save();
            $this->info("{$user->name} is now an admin");
        }
        else {
            $this->warn("User not found");
        }

        return 0;
    }
}
