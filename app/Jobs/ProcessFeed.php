<?php

namespace App\Jobs;

use App\Article;
use App\Feed;
use App\Repositories\RssArticleRepository;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class ProcessFeed implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /** @var Feed  */
    private $feed;

    /**
     * Create a new job instance.
     *
     * @param Feed $feed
     */
    public function __construct(Feed $feed)
    {
        $this->feed = $feed;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $repo = new RssArticleRepository($this->feed);
        $articles = $repo->getAll();

        foreach ($articles as $article) {

            if (!Article::where('guid', $article->guid)->exists()) {
                $this->feed->articles()->save($article);
                $this->feed->users->each->attachArticle($article);

                FetchArticleFullContent::dispatch($article)->chain([
                    new FetchArticleImage($article)
                ]);
            }
        }

    }

}
