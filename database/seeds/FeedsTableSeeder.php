<?php

use App\Feed;
use App\User;
use Illuminate\Database\Seeder;

class FeedsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::first();

        $user->find(1)->feeds()->saveMany([
            new Feed(['name' => 'lesnumeriques', 'url' => 'http://feeds.feedburner.com/lesnumeriques/news', 'type' => 1]),
            new Feed(['name' => 'Neowin', 'url' => 'https://feeds.feedburner.com/neowin-main', 'type' => 1])
        ]);

        $user->find(2)->feeds()->saveMany([
            new Feed(['name' => 'The Guardian (World)', 'url' => 'https://www.theguardian.com/world/rss', 'type' => 1])
        ]);

        $user->find(2)->feeds()->attach(1);
    }
}
