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

Route::get('/', 'HomeController@index')->name('home');
Route::get('/post/{slug}', 'HomeController@show')->name('post.show');

Route::group(['prefix' => 'admin', 'namespace' => 'Admin'/*, 'middleware'	=> 'auth'*/], function(){
    Route::get('/', 'DashboardController@index')->name('admin');
    Route::resource('/category', 'CategoriesController');
    Route::resource('/tag', 'TagController')->except(['show']);
    Route::resource('/users', 'UsersController')->except(['show']);
    Route::resource('/posts', 'PostsController')->except(['show']);
});