<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        // Create a user
        $adminUser = User::updateOrCreate([
            'name' => 'pst',
            'email' => 'pst@test.com',
            'password' => Hash::make('pst')
        ]);

        $adminUser->assignRole('admin');
    }
}
