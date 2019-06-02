<?php

namespace App\Http\Controllers\Api;

use App\Feed;
use App\Http\Controllers\Controller;
use App\Http\Resources\FeedResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class FeedController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return ResourceCollection
     */
    public function index(Request $request)
    {

        if ($request->input('mine')) {
            $feeds = \Auth::user()->feeds()->get();
        } else {
            $feeds = Feed::search($request->input('q'));
        }

        return FeedResource::collection($feeds);
    }


    public function store(Request $request)
    {
        try {
            $feed = Feed::where('url', $request->input('url'))->firstOrFail();
        } catch (\Exception $e) {
            $feed = new Feed($request->all());
            $feed->save();
        }

        $feed->users()->attach(\Auth::id());
    }

    public function destroy(Feed $feed)
    {
        $feed->users()->detach(\Auth::id());
    }

}
