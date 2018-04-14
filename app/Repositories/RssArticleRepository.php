<?php

namespace App\Repositories;

use App\Article;
use App\Feed;
use Illuminate\Support\Collection;
use PicoFeed\Config\Config;
use PicoFeed\Parser\Item;
use PicoFeed\Reader\Reader;
use PicoFeed\Scraper\Scraper;
use Carbon\Carbon;


class RssArticleRepository implements ArticleRepositoryInterface
{
    protected $feed;

    public function __construct(Feed $feed)
    {
        $this->feed = $feed;
    }

    public function getAll()
    {
        $all_articles = new Collection();
        $reader = new Reader();
        $resource = $reader->download($this->feed->url);

        if ($resource->isModified()) {

            // Return the right parser instance according to the feed format
            $parser = $reader->getParser(
                $resource->getUrl(),
                $resource->getContent(),
                $resource->getEncoding()
            );

            // Return a Feed object
            $reader = $parser->execute();

            foreach ($reader->items as $item) {
                $all_articles->push(
                    $this->getArticleFromItem($item)
                );
            }
        }

        return $all_articles;
    }

    protected function getArticleFromItem(Item $item)
    {
        $article = new Article();

        $date = Carbon::instance($item->getDate());

        $article->title = $item->getTitle();
        $article->created_at = $date;
        $article->updated_at = $date;
        $article->content = $item->getContent();
        $article->url = $item->getUrl();
        $article->guid = $item->getId();

        return $article;
    }

    static function fetchFullContent($article)
    {
        $config = new Config();
        $grabber = new Scraper($config);
        $grabber->setUrl($article->url);
        $grabber->execute();
        return $grabber->getFilteredContent();
    }
}