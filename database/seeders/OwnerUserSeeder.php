<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\Hash;

class OwnerUserSeeder extends Seeder
{
    public function run(): void
    {
        $role = Role::where('slug', 'owner')->first();

        if ($role) {
            $user = User::firstOrCreate(
                ['email' => 'owner@gmail.com'], 
                [
                    'name' => 'Owner Aplikasi',
                    'password' => Hash::make('password') 
                ]
            );

            $user->roles()->syncWithoutDetaching($role->id);
        }
    }
}