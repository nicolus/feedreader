<?php

namespace App\Http\Controllers\Api;

use App\Article;
use App\Http\Resources\ArticleResource;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\Resources\Json\ResourceCollection;

class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return ResourceCollection
     */
    public function index(Request $request)
    {
        $order = $request->input('order') === 'asc' ? 'asc' : 'desc';

        $articles = \Auth::user()->articles()->with('feed')
            ->orderby('created_at', $order);

        return ArticleResource::collection($articles->paginate(10));
    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Article  $article
     * @return Article
     */
    public function show(Article $article)
    {
        \Auth::user()
            ->articles()
            ->updateExistingPivot(
                $article->id,
                ['read' => true]
            );

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
        \Auth::user()
            ->articles()
            ->updateExistingPivot(
                $article->id,
                $request->only(['starred', 'read'])
            );
    }

    public function markAllAsRead()
    {
        $unreadArticles = \Auth::user()
            ->articles()
            ->where('read', 0)
            ->pluck('id')
            ->toArray();

        foreach ($unreadArticles as $id) {
            \Auth::user()
                ->articles()
                ->updateExistingPivot(
                    $id,
                    ['read' => true]
                );
        }
    }

}
