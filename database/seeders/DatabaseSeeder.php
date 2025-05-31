<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // define the roles
        $guestRole = Role::create(['name' => 'مهمان']);
        $studentRole = Role::create(['name' => 'دانشجو']);
        $teacherRole = Role::create(['name' => 'استاد']);
        $adminRole  = Role::create(['name' => 'ادمین سایت']);

        // add admin site user
        $admin = User::create([
            'name' => 'Site Admin',
            'email' => 'admin@example.com',
            'password' => Hash::make('password123'),
        ]);

        // add admin role to user
        $admin->assignRole($adminRole);
        $admin->removeRole($guestRole);
    }   
}
