<?php namespace App\Console\Commands;

use App\Article;
use App\Feed;
use App\Jobs\FetchArticleFullContent;
use App\Jobs\FetchArticleImage;
use App\Jobs\ProcessArticle;
use App\Jobs\ProcessFeed;
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

        \Log::info('Starting feeds:update');
        $feeds = Feed::rss()->get();

        foreach ($feeds as $feed) {
            ProcessFeed::dispatch($feed);
        }
        \Log::info('feeds:update ran successfully');
        return true;
    }

}
