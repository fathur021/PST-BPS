<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Role::create(['name' => 'admin']);
        Role::create(['name' => 'pst']);
        Role::create(['name' => 'front-office']);
        Role::create(['name' => 'petugas-pengaduan']);
        Role::create(['name' => 'admin-slideshow']);
    }
}
