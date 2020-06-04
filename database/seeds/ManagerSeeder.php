<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class ManagerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('managers')->insert([
            'email' => 'manager@hust.edu.vn',
            'password' => Hash::make('manager@123456'),
            'remember_token' => Str::random(10)
        ]);
    }
}
