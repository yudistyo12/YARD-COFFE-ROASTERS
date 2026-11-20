<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        $email = env('ADMIN_EMAIL', 'admin@yudistyocoffee.id');
        $password = env('ADMIN_PASSWORD', 'Yudistyo123!');

        User::updateOrCreate(
            ['email' => $email],
            [
                'name' => 'Administrator Yard & Coffee',
                'password' => Hash::make($password),
                'is_admin' => true,
            ],
        );
    }
}
