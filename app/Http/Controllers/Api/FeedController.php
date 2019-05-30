<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\FeedResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;
use PicoFeed\Reader\Reader;

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
        $feeds = \Auth::user()->feeds()->get();

        return FeedResource::collection($feeds);
    }

    public function discover(Request $request)
    {
        $query = $request->get('q');

        $reader = new Reader;
        $resource = $reader->download($query);

        $feeds = $reader->find(
            $resource->getUrl(),
            $resource->getContent()
        );

        print_r($feeds);
    }

}
