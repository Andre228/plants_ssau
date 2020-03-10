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




Route::group(['namespace' => 'Museum', 'prefix' => 'museum'], function (){
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

//Admin controllers
$groupDataAdmin = [
    'namespace' => 'Museum\Admin',
    'prefix' => 'admin/museum'
];
Route::group($groupDataAdmin, function (){

    Route::get('/categories/{how}','CategoryController@index')->name('museum.admin.categories.index');


    $methods = ['edit', 'store', 'update', 'create', 'destroy', 'show'];
    Route::resource('categories', 'CategoryController')
        ->only($methods)
        ->names('museum.admin.categories');



   // Route::get('categories/showall', 'CategoryController@showAll')->name('museum.admin.categories.showall');

});

//Route::get('/categories_admin', 'Museum\Admin\CategoryController@getAllCategories');
