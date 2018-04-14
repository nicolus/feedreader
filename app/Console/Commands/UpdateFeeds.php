<?php namespace App\Console\Commands;

use App\Article;
use App\Feed;
use App\Jobs\ProcessArticle;
use App\Repositories\RssArticleRepository;
use Exception;
use Illuminate\Console\Command;

class UpdateFeeds extends Command
{

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'feeds:update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update all RSS Feeds';


    /**
     * Execute the console command.
     * @return mixed
     * @throws Exception
     */
    public function handle()
    {
        $feeds = Feed::rss()->get();

        foreach ($feeds as $feed) {
            $this->info("fetching feed for $feed->name");
            $repo = new RssArticleRepository($feed);
            $articles = $repo->getAll();

            foreach ($articles as $article) {
                if (!Article::where('guid', $article->guid)->exists()) {
                    $feed->articles()->save($article);

                    $feed->users->each->attachArticle($article);

                    ProcessArticle::dispatch($article);
                }
            }
        }
        return true;
    }

}
