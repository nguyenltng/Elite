<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/', 'CategoryController@showListCategory')->name('viewHome');
Route::get('/profile/{id}', 'HomeController@showProfile')->name('viewProfile');
Route::post('/update/{id}', 'UserController@update')->name('updateUser');

Route::get('/user/{id}', 'UserController@showEdit')->name('editUser');

Route::get('logout', array('uses' => 'HomeController@doLogout'))->name('logout');

Route::group(['middleware' => 'CheckLogin'], function () {
    Route::get('/login', 'HomeController@showLogin')->name('viewLogin');
    Route::post('/login', 'HomeController@doLogin')->name('login');
});

Route::group(['middleware' => 'web'], function () {
    Route::post('/register', 'UserController@create')->name('register');
    Route::get('/register', 'HomeController@showRegister')->name('viewRegister');

});

Route::group(['middleware' => 'web'], function(){
    Route::get('/post','PostController@showListPost')->name('viewListPost');
    Route::get('/post/create', 'PostController@showViewCreatePost')->name('view.createPost');
    Route::post('/post/create', 'PostController@createPost')->name('createPost');
    Route::get('/post/edit/{id}', 'PostController@showViewEditPost')->name('view.editPost');
    Route::post('/post/edit/{id}', 'PostController@editPost')->name('editPost');
    Route::get('/post/delete/{id}', 'PostController@deletePost')->name('deletePost');
});

Route::get('/category/{id}','PostController@getListPostByCategoryId')->name('view.listPostByCategoryId');
