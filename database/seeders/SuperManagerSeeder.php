<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\Hash;
class SuperManagerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $role = Role::where('name', 'Super Manager')->first();

        User::create([
            'name' => 'Super Manager',
            'email' => 'super@asdaa.com',
            'password' => Hash::make('password123'), // Replace with your desired password
            'role_id' => $role->id, // Assuming you have a role_id foreign key in your users table
        ]);
    }
}
