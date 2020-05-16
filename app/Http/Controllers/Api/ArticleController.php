<?php

namespace App\Http\Controllers\Api;

use App\Article;
use App\Http\Resources\ArticleResource;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Http\Response;

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
        $starred = (bool)($request->input('filter') == 'starred');

        \DB::connection()->enableQueryLog();
        $articles = \Auth::user()
            ->articles()
            ->join('feed_user', function ($join) {
                $join->on('articles.feed_id', '=', 'feed_user.feed_id')
                    ->where('feed_user.user_id', \Auth::id());
            })
            ->when($starred, function($query){
                $query->where('starred', true);
            })
            ->with('feed')
            ->orderby('created_at', $order);

        return ArticleResource::collection($articles->simplePaginate(20));
    }


    /**
     * Display the specified resource.
     *
     * @param Article $article
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
     * @param Request $request
     * @param Article $article
     * @return Response
     */
    public function update(Request $request, Article $article)
    {
        \Auth::user()
            ->articles()
            ->updateExistingPivot(
                $article->id,
                $request->only(['starred', 'read'])
            );
        return response(null, 200);
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
