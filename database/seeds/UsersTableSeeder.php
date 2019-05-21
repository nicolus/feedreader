<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            [
                'name' => 'Test User',
                'email' => 'test@test.com',
                'password' => bcrypt('secret'),
            ], [
                'name' => 'Test User 2',
                'email' => 'test2@test.com',
                'password' => bcrypt('secret'),
            ]
        ]);
    }
}
