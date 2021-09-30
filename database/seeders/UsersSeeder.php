<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
          //Administrator
           [
               'full_name' => 'Anton Belous',
               'username' => 'Admin',
               'email'=> 'admin@gmail.com',
               'password'=>\Hash::make('111'),
               'role' => 'admin',
               'status' =>'active',
           ],
            //Vendor
            [
                'full_name' => 'Anton Vendor',
                'username' => 'Vendor',
                'email'=> 'vendor@gmail.com',
                'password'=>\Hash::make('111'),
                'role' => 'vendor',
                'status' =>'active',
            ],
            //Customer
            [
                'full_name' => 'Anton Customer',
                'username' => 'Customer',
                'email'=> 'customer@gmail.com',
                'password'=>\Hash::make('111'),
                'role' => 'customer',
                'status' =>'active',
            ],
        ]);
    }
}
