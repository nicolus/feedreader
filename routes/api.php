<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


Route::middleware(['auth:api'])->group(function () {
    Route::resource('articles', 'Api\ArticleController');
    Route::resource('feeds', 'Api\FeedController', ['only' => ['index', 'store', 'destroy']]);
    Route::post('articles/markallasread', 'Api\ArticleController@markAllAsRead');
});
