<?php

use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => "owner",
            'email' => 'owner@owner.com',
            'user_role' => 'owner',
            'nomor_telephone' => '082333444555',
            'password' => bcrypt('fdsafdsa'),
        ]);
        DB::table('users')->insert([
            'name' => "admin",
            'email' => 'admin@admin.com',
            'user_role' => 'admin',
            'nomor_telephone' => '082333444666',
            'password' => bcrypt('fdsafdsa'),
        ]);
        DB::table('users')->insert([
            'name' => "user1",
            'email' => 'user1@user1.com',
            'user_role' => 'user',
            'nomor_telephone' => '082333444777',
            'password' => bcrypt('fdsafdsa'),
        ]);
        DB::table('users')->insert([
            'name' => "user2",
            'email' => 'user2@user2.com',
            'user_role' => 'user',
            'nomor_telephone' => '082333444988',
            'password' => bcrypt('fdsafdsa'),
        ]);
    }
}
