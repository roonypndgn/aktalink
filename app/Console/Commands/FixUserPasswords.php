<?php
// app/Console/Commands/FixUserPasswords.php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

class FixUserPasswords extends Command
{
    protected $signature = 'users:fix-passwords';
    protected $description = 'Fix all user passwords to use Bcrypt';

    public function handle()
    {
        $users = User::all();
        $fixed = 0;

        foreach ($users as $user) {
            // Cek apakah password sudah Bcrypt
            if (!preg_match('/^\$2y\$/', $user->password)) {
                $this->info("Fixing: {$user->username}");
                $user->password = Hash::make('password123');
                $user->save();
                $fixed++;
            }
        }

        $this->info("Fixed {$fixed} user(s). Default password: password123");
    }
}