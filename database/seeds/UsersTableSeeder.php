<?php

use Illuminate\Database\Seeder;

use Illuminate\Support\Facades\Hash;

use App\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'role_id' => 1,
            'name' => "Admin",
            'email' => "admin@email.com",
            'password' => Hash::make('admin123')
        ]);

        User::create([
            'role_id' => 2,
            'name' => "Employee",
            'email' => "employee@email.com",
            'password' => Hash::make('password')
        ]);
        
        User::create([
            'role_id' => 3,
            'name' => "Customer",
            'email' => "customer@email.com",
            'password' => Hash::make('password')
        ]);
    }
}
