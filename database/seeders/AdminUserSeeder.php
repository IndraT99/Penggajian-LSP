<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        $adminRole = Role::where('slug', 'admin')->first();

        if ($adminRole) {
            $adminUser = User::firstOrCreate(
                ['email' => 'admin@gmail.com'], 
                [
                    'name' => 'Admin Aplikasi',
                    'password' => Hash::make('password') 
                ]
            );

            $adminUser->roles()->syncWithoutDetaching($adminRole->id);
        }
    }
}