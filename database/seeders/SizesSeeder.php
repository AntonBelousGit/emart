<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SizesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('sizes')->insert([
           [
               'title' => 'Small',
               'slug' => 'S',
           ],
           [
               'title' => 'Medium',
               'slug' => 'M',
           ],
           [
               'title' => 'Large',
               'slug' => 'L',
           ],
           [
               'title' => 'Extra Large',
               'slug' => 'XL',
           ],
           [
               'title' => 'Extra Extra Large',
               'slug' => 'XXL',
           ],
           [
               'title' => 'Extra Extra Large + vitamin C',
               'slug' => 'XXXL',
           ],
        ]);
    }
}
