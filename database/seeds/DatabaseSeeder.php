<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(UserTableSeeder::class);
        $this->call(product_dummy::class);
        $this->call(additional_product_image::class);
        $this->call(user_role::class);
    }
}
