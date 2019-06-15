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

class FetchArticleImage implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;


    protected $article;

    /**
     * Create a new job instance.
     *
     * @param Article $article
     */
    public function __construct(Article $article)
    {
        $this->article = $article;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $imgFile = $this->article->guid . '.jpg';
        $imgUrl = $this->article->findImage();

        if (empty($imgUrl)) {
            return null;
        }

        \Image::make($imgUrl)
            ->fit(112, 112)
            ->save(public_path("img/$imgFile"), 80);


        $this->article->image = $imgFile;

        $this->article->save();

    }
}


