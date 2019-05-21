<?php

namespace App\Repositories;

use App\Article;
use App\Feed;
use Illuminate\Support\Collection;
use TwitterClient\TwitterClient;


class TwitterArticleRepository implements ArticleRepositoryInterface
{
    protected $feed;

    public function __construct(Feed $feed)
    {
        $this->feed = $feed;
    }

    public function getAll(): Collection
    {
        $all_articles = new Collection();

        $twitter = new TwitterClient([
            'consumer_key' => env('TWITTER_CONSUMER_KEY'),
            'consumer_secret' => env('TWITTER_CONSUMER_SECRET'),
            'token' => env('TWITTER_TOKEN'),
            'token_secret' => env('TWITTER_TOKEN_SECRET')
        ]);

        $items = $twitter->getTweetsByUser($this->feed->name);

        foreach ($items as $item) {
            $all_articles->push(
                $this->getArticleFromItem($item)
            );
        }

        return $all_articles;
    }

    protected function getArticleFromItem($item){
        $article = new Article();

        if (!empty($item['retweeted_status'])) {
            $article->title = sprintf(
                "@%s RTweet @%s : %s",
                $this->feed->name,
                $item['retweeted_status']['user']['screen_name'],
                $item['retweeted_status']['text']
            );
        } else {
            $article->title = sprintf(
                "@%s : %s",
                $this->feed->name,
                $item['text']
            );
        }

        $article->created_at = strtotime($item['created_at']);
        $article->updated_at = strtotime($item['created_at']);
        $article->url = "https://twitter.com/".$this->feed->name."/status/".$item['id_str'];
        $article->guid = hash('sha256',$item['id_str'].$item['text']);

        return $article;

    }
}