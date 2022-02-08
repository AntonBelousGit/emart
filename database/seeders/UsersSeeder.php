<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

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
            //Customer
            [
                'full_name' => 'Anton Customer',
                'username' => 'Customer',
                'email'=> 'customer@gmail.com',
                'password'=>Hash::make('123'),
                'status' =>'active',
            ],
        ]);
        DB::table('admins')->insert([
            //Customer
            [
                'full_name' => 'Anton Admin',
                'email'=> 'admin@gmail.com',
                'password'=>Hash::make('123'),
                'status' =>'active',
            ],
        ]);
        DB::table('sellers')->insert([
            [
                'full_name'=>'Arslan Asghar Seller',
                'username'=>'Seller',
                'email'=>'seller@gmail.com',
                'address'=>'Islamabad, Pakistan',
                'phone'=>'+923123456789',
                'photo'=>'',
                'password'=>Hash::make('123'),
                'is_verified' => 0,
                'status'=>'active',

            ],
        ]);
    }
}
