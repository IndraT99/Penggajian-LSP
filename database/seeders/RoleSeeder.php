<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;
use Illuminate\Support\Facades\Schema; 
use Illuminate\Support\Facades\DB;     

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();
        DB::table('role_user')->truncate();
        Role::truncate();
        Schema::enableForeignKeyConstraints();
        Role::create(['name' => 'Admin', 'slug' => 'admin']);
        Role::create(['name' => 'Owner', 'slug' => 'owner']);
        Role::create(['name' => 'Staff HRD', 'slug' => 'staff_hrd']);
        Role::create(['name' => 'Staff Keuangan', 'slug' => 'staff_keuangan']);
        Role::create(['name' => 'Karyawan', 'slug' => 'karyawan']);
    }
}
