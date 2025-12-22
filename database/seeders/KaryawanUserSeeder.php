<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\Hash;

class KaryawanUserSeeder extends Seeder
{
    public function run(): void
    {
        $role = Role::where('slug', 'karyawan')->first();

        if ($role) {
            $user = User::firstOrCreate(
                ['email' => 'karyawan@gmail.com'], 
                [
                    'name' => 'Karyawan Satu',
                    'password' => Hash::make('password') 
                ]
            );

            $user->roles()->syncWithoutDetaching($role->id);
        }
    }
}