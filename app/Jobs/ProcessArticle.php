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

class ProcessArticle implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;


    protected $article;
    protected $feed;

    /**
     * Create a new job instance.
     *
     * @param Article $article
     */
    public function __construct(Feed $feed, Article $article)
    {
        $this->article = $article;
        $this->feed = $feed;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {

    }
}
