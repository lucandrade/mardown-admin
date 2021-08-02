<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;

class CreateUserCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:user:create {username} {password}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Creates an user';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle(): int
    {
        $username = $this->argument('username');
        $existingUser = User::where('username', $username)->first();

        if ($existingUser) {
            $this->error("User '{$username}' already exists");
            return 1;
        }

        $user = new User();
        $user->username = $username;
        $user->password = bcrypt($this->argument('password'));
        $user->save();

        return 0;
    }
}
