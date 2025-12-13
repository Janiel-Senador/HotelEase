<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class StaffUserSeeder extends Seeder
{
    public function run(): void
    {
        $seed = [
            ['name' => 'Alice Staff', 'email' => 'alice.staff@example.com'],
            ['name' => 'Bob Staff', 'email' => 'bob.staff@example.com'],
        ];
        foreach ($seed as $s) {
            User::updateOrCreate(
                ['email' => $s['email']],
                [
                    'name' => $s['name'],
                    'password' => Hash::make('staff123'),
                    'is_staff' => true,
                    'is_active' => true,
                ]
            );
        }
    }
}

