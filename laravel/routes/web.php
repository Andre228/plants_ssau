<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Auth::routes(['verify' => true]);

// ---------------------------------------- Общие маршруты ---------------------------------------- //
Route::get('/','Museum\WelcomeController@index')->name('museum.welcome'); // главная
Route::get('/news/{id}','Museum\NewsController@show')->name('museum.news.show'); // новость

Route::get('/categories','Museum\CategoryController@index')->name('museum.category'); // раздел
Route::get('/contacts','Museum\ContactController@index')->name('museum.contacts'); // контакты

Route::get('/posts/{id}','Museum\PostController@show')->name('museum.posts.show'); // Информация о экспонате
Route::get('/posts-view','Museum\PostController@viewPosts')->name('museum.posts.view'); // Страница со всеми экспонатами


// ---------------------------------------- Маршруты для получения ajax данных ---------------------------------------- //

Route::get('/categories/{id}/{state}','Museum\CategoryController@getPosts')->name('api.museum.category.get.posts');




// ---------------------------------------- Маршруты для авторизованных пользователей ---------------------------------------- //

Route::get('/home', 'HomeController@index')->name('home')->middleware('auth')->middleware('verified'); // профиль
Route::patch('/home/user-profile-save/{id}', 'HomeController@update')->name('user.profile.save')->middleware('auth')->middleware('verified'); // сохранить информацию о профиле

$groupBaseRoutes = [
    'namespace' => 'Museum',
    'middleware' => ['auth', 'web', 'verified']
];

Route::group($groupBaseRoutes, function () {
    Route::get('/news/fetch/more','WelcomeController@fetchNewsMore')->name('web.museum.news.fetch'); // загрузить ещё новости в профиле
    Route::post('/posts/views/{id}','PostController@incrementCountViews')->name('web.museum.post.set.views'); // обновить количество просмотров

    Route::post('/user/favorite/news/{newsId}','UserController@addToReadingNews')->name('museum.user.set.reading'); // добавить в список для чтения
    Route::post('/user/favorite/{userId}/{postId}','UserController@addToFavorites')->name('web.museum.user.set.favorite'); // добавить в избранное
    Route::delete('/user/delete/favorite/{id}','UserController@removeFromFavorites')->name('web.museum.user.delete.favorite'); // Удалить из избранного
    Route::get('/posts/favorites/{userId}','UserController@getMoreFavorites')->name('web.museum.post.get.favorites'); // Загрузить ещё из избранного

    Route::post('/posts/history/create/{userId}/{postId}','PostController@updateHistory')->name('web.museum.post.create.history'); // Обновить историю посещения
    Route::get('/posts/fetch/view','PostController@fetchPosts')->name('web.museum.post.get.view');
    Route::get('/posts/view/{period}','PostController@fetchPostsForPeriod')->name('web.museum.post.get.view.period');



    Route::get('/news/reading/batch','UserController@getMoreNews')->name('museum.news.get.batch'); // Загрузить ещё в список для чтения
    Route::delete('/user/favorite/news/delete/{id}','UserController@removeFromReadingList')->name('museum.user.delete.news'); // удалить из избранного
    Route::post('/user/news/like/{id}','NewsController@likeNews')->name('museum.news.like');

    Route::post('/news/comments/set/{newsId}/{newsInfoId}/{replyId?}','NewsController@addComment')->name('museum.news.comment.set'); // оставить комментарий

    Route::get('/posts/search/{barcode}/{determination}/{russian_name}/{collection_date}/{label_text}/{accuracy}/{adopted_name}/{environmental_status}',
        'PostController@index')->name('museum.posts.search'); // поиск

});


Route::group(['namespace' => 'Museum', 'prefix' => 'museum'], function () {
    Route::resource('posts', 'PostController')->names('museum.posts');
});



// ---------------------------------------- Маршруты для администратора ---------------------------------------- //
$groupDataAdminDashboard = [
    'namespace' => 'Museum',
    'prefix' => 'museum',
    'middleware' => ['auth', 'verified', 'admin']
];
Route::group($groupDataAdminDashboard, function (){

    $methods = ['index'];
    Route::resource('dashboard', 'AdminController')
        ->only($methods)
        ->names('museum.admin_dashboard');

});

//Admin categories controllers
$groupDataAdmin = [
    'namespace' => 'Museum\Admin',
    'prefix' => '/admin/museum',
    'middleware' => ['auth', 'verified', 'admin']
];
Route::group($groupDataAdmin, function () {


    Route::get('/categories/create','CategoryController@create')->name('museum.admin.categories.create');
    Route::post('/categories','CategoryController@store')->name('museum.admin.categories.store');
    Route::get('/categories/{id}/edit','CategoryController@edit')->name('museum.admin.categories.edit');
    Route::patch('/categories/{id}','CategoryController@update')->name('museum.admin.categories.update');
    Route::delete('/categories/{id}','CategoryController@destroy')->name('museum.admin.categories.destroy');
    Route::get('/categories/search','CategoryController@search')->name('museum.admin.categories.search');
    Route::get('/categories/list/{how}','CategoryController@index')->name('museum.admin.categories.index');
    Route::get('/categories/tree','CategoryController@indexTree')->name('museum.admin.categories.tree');


    Route::get('/posts/create','PostController@create')->name('museum.admin.posts.create');
    Route::post('/posts','PostController@store')->name('museum.admin.posts.store');
    Route::get('/posts','PostController@index')->name('museum.admin.posts.index');
    Route::get('/posts/{id}/edit','PostController@edit')->name('museum.admin.posts.edit');
    Route::patch('/posts/{id}','PostController@update')->name('museum.admin.posts.update');
    Route::delete('/posts/{id}','PostController@destroy')->name('museum.admin.posts.destroy');
    Route::post('/posts/{id}/upload-file','PostController@upload')->name('museum.admin.posts.upload');
    Route::post('/posts/{id}/change-file','PostController@change')->name('museum.admin.posts.file.change');
    Route::post('/posts/{id}/delete-file','PostController@deleteImage')->name('museum.admin.posts.file.delete');
    Route::post('/posts/import','PostController@import')->name('museum.admin.posts.import');
    Route::delete('/posts/delete/{count}','PostController@deletePosts')->name('museum.admin.posts.delete.more');

    Route::get('/batch/posts/','PostController@fetchMorePosts')->name('web.museum.admin.posts.batch.get');
    Route::post('/search/posts','PostController@search')->name('web.museum.admin.posts.search');


    Route::patch('/users/save/{id}','UserController@update')->name('museum.admin.users.update');
    Route::get('/users','UserController@index')->name('museum.admin.users.index');
    Route::get('/users/search','UserController@search')->name('museum.admin.users.search');
    Route::get('/users/{id}/edit','UserController@edit')->name('museum.admin.users.edit');


    Route::get('/news','NewsController@index')->name('museum.admin.news.index');
    Route::get('/news/create','NewsController@create')->name('museum.admin.news.create');
    Route::post('/news','NewsController@store')->name('museum.admin.news.store');
    Route::get('/news/{id}/edit','NewsController@edit')->name('museum.admin.news.edit');
    Route::patch('/news/{id}','NewsController@update')->name('museum.admin.news.update');
    Route::delete('/news/delete/{id}','NewsController@destroy')->name('museum.admin.news.destroy');

});
