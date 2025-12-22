<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\Hash;

class StaffHrdUserSeeder extends Seeder
{
    public function run(): void
    {
        $role = Role::where('slug', 'staff_hrd')->first();

        if ($role) {
            $user = User::firstOrCreate(
                ['email' => 'hrd@gmail.com'], 
                [
                    'name' => 'Staff HRD',
                    'password' => Hash::make('password') 
                ]
            );

            $user->roles()->syncWithoutDetaching($role->id);
        }
    }
}