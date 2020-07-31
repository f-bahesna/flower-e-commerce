<?php

use Illuminate\Database\Seeder;

class additional_product_image extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('additional_product_image')->insert([
            'id_product' => 1,
            'additional_product_image' => 'amarilis1.jpg'
        ]);
        DB::table('additional_product_image')->insert([
            'id_product' => 1,
            'additional_product_image' => 'amarilis2.jpg'
        ]);
        DB::table('additional_product_image')->insert([
            'id_product' => 1,
            'additional_product_image' => 'amarilis3.jpg'
        ]);
    }
}
