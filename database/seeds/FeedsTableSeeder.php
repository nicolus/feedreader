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

        $feeds = /** @lang JSON */
            <<<JSON
[
        {
            "name": "Le Monde",
			"url": "http://lemonde.fr/",
			"feedlink": "http://rss.lemonde.fr/c/205/f/3050/index.rss"
		}, {
            "name": "20minutes",
			"url": "http://20minutes.fr/",
			"feedlink": "http://flux.20minutes.fr/c/32497/f/479493/index.rss"
		}, {
            "name": "Le Nouvel Observateur",
			"url": "http://nouvelobs.com/",
			"feedlink": "http://tempsreel.nouvelobs.com/rss.xml"
		}, {
            "name": "Le Point",
			"url": "http://lepoint.fr/",
			"feedlink": "http://www.lepoint.fr/rss.xml"
		}, {
            "name": "Eurosport.fr",
			"url": "http://eurosport.fr/",
			"feedlink": "http://www.eurosport.fr/formule-1/rss_tea2973.xml"
		}, {
            "name": "purepeople",
			"url": "http://purepeople.com/",
			"feedlink": "http://www.purepeople.com/rss/stanley-tucci_p2758.xml"
		}, {
            "name": "Boursorama",
			"url": "http://boursorama.com/",
			"feedlink": "http://lifestyle.boursorama.com/rss"
		}, {
             "name": "Europe1",
			"url": "http://europe1.fr/",
			"feedlink": "http://www.europe1.fr/var/export/rss/europe1/actus.xml"
		}
] 
JSON;


        $feeds = json_decode($feeds);
        foreach ($feeds as $feed) {
            Feed::insert(['name' => $feed->name, 'url' => $feed->feedlink, 'type' => Feed::TYPE_RSS]);
        }


        $user->find(1)->feeds()->saveMany([
            new Feed(['name' => 'lesnumeriques', 'url' => 'http://feeds.feedburner.com/lesnumeriques/news', 'type' => Feed::TYPE_RSS]),
            new Feed(['name' => 'Neowin', 'url' => 'https://feeds.feedburner.com/neowin-main', 'type' => Feed::TYPE_RSS])
        ]);

        $user->find(2)->feeds()->saveMany([
            new Feed(['name' => 'The Guardian (World)', 'url' => 'https://www.theguardian.com/world/rss', 'type' => 1])
        ]);

        $user->find(2)->feeds()->attach(1);
    }
}
