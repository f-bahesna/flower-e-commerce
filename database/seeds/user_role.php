<?php

use Illuminate\Database\Seeder;

class user_role extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('user_role')->insert([
            'user_id' => 1,
            'type' => 'owner',
        ]);
        DB::table('user_role')->insert([
            'user_id' => 2,
            'type' => 'admin',
        ]);
        DB::table('user_role')->insert([
            'user_id' => 3,
            'type' => 'user',
        ]);
        DB::table('user_role')->insert([
            'user_id' => 4,
            'type' => 'user',
        ]);
    }
}
