<?php

use App\Feed;
use App\User;
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
            'name' => 'Test User',
            'email' => 'test@test.com',
            'password' => bcrypt('secret'),
        ]);

        $user = User::first();

        $user->feeds()->saveMany([
            new Feed(['name' => 'lorem-rss', 'url' => 'http://lorem-rss.herokuapp.com/feed?unit=minute', 'type' => 1])
        ]);
    }
}
