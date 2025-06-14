<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use Illuminate\Support\Facades\DB;

class RolesTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('roles')->insert([
            ['name' => 'Super Manager'],
            ['name' => 'Admin'],
            ['name' => 'Region Manager'],
            ['name' => 'Guest'],
        ]);
    }
}

