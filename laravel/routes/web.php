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


Auth::routes();

Route::get('/','Museum\WelcomeController@index')->name('museum.welcome'); // главная
Route::get('/categories','Museum\CategoryController@index')->name('museum.category'); // раздел
Route::get('/posts/search/{barcode}/{determination}/{russian_name}/{collection_date}/{label_text}/{accuracy}/{adopted_name}/{environmental_status}',
    'Museum\PostController@index')->name('museum.posts.search'); // поиск
Route::get('/posts/{id}','Museum\PostController@show')->name('museum.posts.show'); // Информация о экспонате
Route::get('/posts-view','Museum\PostController@viewPosts')->name('museum.posts.view'); // Страница со всеми экспонатами

Route::get('/home', 'HomeController@index')->name('home'); // профиль
Route::patch('/home/user-profile-save/{id}', 'HomeController@update')->name('user.profile.save');




Route::group(['namespace' => 'Museum', 'prefix' => 'museum'], function () {
    Route::resource('posts', 'PostController')->names('museum.posts');
});



//Admin dashboard controller
$groupDataAdminDashboard = [
    'namespace' => 'Museum',
    'prefix' => 'museum',
    'middleware' => 'auth'
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
    'prefix' => '/admin/museum'
];
Route::group($groupDataAdmin, function () {


    Route::get('/categories/create','CategoryController@create')->name('museum.admin.categories.create');
    Route::post('/categories','CategoryController@store')->name('museum.admin.categories.store');
    Route::get('/categories/{id}/edit','CategoryController@edit')->name('museum.admin.categories.edit');
    Route::patch('/categories/{id}','CategoryController@update')->name('museum.admin.categories.update');
    Route::delete('/categories/{id}','CategoryController@destroy')->name('museum.admin.categories.destroy');
    Route::get('/categories/search','CategoryController@search')->name('museum.admin.categories.search');
    Route::get('/categories/{how}','CategoryController@index')->name('museum.admin.categories.index');


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


    Route::get('/users','UserController@index')->name('museum.admin.users.index');
    Route::get('/users/{id}/edit','UserController@edit')->name('museum.admin.users.edit');
   // Route::get('/getusers/per-page','UserController@getUsersOnPage')->name('museum.admin.users.on-page');


    Route::get('/news','NewsController@index')->name('museum.admin.news.index');
    Route::get('/news/create','NewsController@create')->name('museum.admin.news.create');
    Route::post('/news','NewsController@store')->name('museum.admin.news.store');
    Route::get('/news/{id}/edit','NewsController@edit')->name('museum.admin.news.edit');
    Route::patch('/news/{id}','NewsController@update')->name('museum.admin.news.update');

});

//Route::get('/categories_admin', 'Museum\Admin\CategoryController@getAllCategories');
