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
            'name' => "adi",
            'email' => 'adi@gmail.com',
            'nomor_telepon' => '082333444555',
            'password' => bcrypt('password'),
        ]);
        DB::table('users')->insert([
            'name' => "adu",
            'email' => 'adu@gmail.com',
            'nomor_telepon' => '082333444666',
            'password' => bcrypt('password'),
        ]);
        DB::table('users')->insert([
            'name' => "ade",
            'email' => 'ade@gmail.com',
            'nomor_telepon' => '082333444777',
            'password' => bcrypt('password'),
        ]);
        DB::table('users')->insert([
            'name' => "adi gunawan",
            'email' => 'adiGunawan@gmail.com',
            'nomor_telepon' => '082333444988',
            'password' => bcrypt('password'),
        ]);
    }
}
