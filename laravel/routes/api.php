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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


Route::get('/news/batch','Museum\WelcomeController@fetchNewsMore')->name('api.museum.news.batch');

Route::post('/posts/views/{id}','Museum\PostController@incrementCountViews')->name('api.museum.post.set.views');
Route::post('/user/favorite/{userId}/{postId}','Museum\UserController@addToFavorites')->name('api.museum.user.set.favorite');
Route::delete('/user/delete/favorite/{id}','Museum\UserController@removeFromFavorites')->name('api.museum.user.delete.favorite');
Route::post('/posts/history/create/{userId}/{postId}','Museum\PostController@updateHistory')->name('api.museum.post.create.history');
Route::get('/posts/favorites/{userId}','Museum\UserController@getMoreFavorites')->name('api.museum.post.get.favorites');
Route::get('/posts/view','Museum\PostController@fetchPosts')->name('api.museum.post.get.view');
Route::get('/posts/view/{period}','Museum\PostController@fetchPostsForPeriod')->name('api.museum.post.get.view.period');

Route::get('/batch/posts/admin','Museum\Admin\PostController@fetchMorePosts')->name('api.museum.admin.posts.batch.get');
Route::post('/admin/posts/search','Museum\Admin\PostController@search')->name('api.museum.admin.posts.search');