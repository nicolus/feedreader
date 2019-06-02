<?php

namespace App\Jobs;

use App\Article;
use App\Feed;
use App\Repositories\ArticleRepositoryInterface;
use App\Repositories\RssArticleRepository;
use App\Repositories\TwitterArticleRepository;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ProcessFeed implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /** @var Feed */
    private $feed;

    /** @var ArticleRepositoryInterface */
    private $repo;

    /**
     * Create a new job instance.
     *
     * @param Feed $feed
     */
    public function __construct(Feed $feed)
    {
        $this->feed = $feed;

        switch ($this->feed->type){
            case Feed::TYPE_RSS:
                $this->repo = new RssArticleRepository($this->feed);
                break;
            case Feed::TYPE_TWITTER:
                $this->repo = new TwitterArticleRepository($this->feed);
                break;
        }
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $articles = $this->repo->getAll();

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
