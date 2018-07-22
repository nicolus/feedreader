<?php

namespace App\Http\Controllers\Api;

use App\Article;
use App\Http\Resources\ArticleResource;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return ArticleResource
     */
    public function index(Request $request)
    {
        $order = $request->input('order') === 'asc' ? 'asc' : 'desc';

        $articles = Article::with('feed')
            ->orderby('created_at', $order);

        return ArticleResource::collection($articles->paginate());
    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Article  $article
     * @return \Illuminate\Http\Response
     */
    public function show(Article $article)
    {
        return $article;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Article  $article
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Article $article)
    {
        //
    }

}
