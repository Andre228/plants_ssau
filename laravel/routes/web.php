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

Route::get('/','Museum\WelcomeController@index')->name('welcome');

Route::get('/home', 'HomeController@index')->name('home');
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
    Route::get('/categories/{how}','CategoryController@index')->name('museum.admin.categories.index');


    Route::get('/posts/create','PostController@create')->name('museum.admin.posts.create');
    Route::post('/posts','PostController@store')->name('museum.admin.posts.store');
    Route::get('/posts','PostController@index')->name('museum.admin.posts.index');
    Route::get('/posts/{id}/edit','PostController@edit')->name('museum.admin.posts.edit');
    Route::patch('/posts/{id}','PostController@update')->name('museum.admin.posts.update');
    Route::delete('/posts/{id}','PostController@destroy')->name('museum.admin.posts.destroy');

});

//Route::get('/categories_admin', 'Museum\Admin\CategoryController@getAllCategories');
