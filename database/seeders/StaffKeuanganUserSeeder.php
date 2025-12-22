<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\Hash;

class StaffKeuanganUserSeeder extends Seeder
{
    public function run(): void
    {
        $role = Role::where('slug', 'staff_keuangan')->first();

        if ($role) {
            $user = User::firstOrCreate(
                ['email' => 'keuangan@gmail.com'], 
                [
                    'name' => 'Staff Keuangan',
                    'password' => Hash::make('password') 
                ]
            );

            $user->roles()->syncWithoutDetaching($role->id);
        }
    }
}