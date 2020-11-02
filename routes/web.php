<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
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

Route::get('/',[CategoryController::class, 'showListCategory'] )->name('viewHome');
Route::get('/profile/{id}',[HomeController::class, 'showProfile'] )->name('viewProfile');
Route::post('/update/{id}',[UserController::class, 'update'] )->name('updateUser');

Route::get('/user/{id}', [UserController::class, 'showEdit'])->name('editUser');

Route::get('logout',  [HomeController::class, 'doLogout'])->name('logout');

Route::group(['middleware' => 'CheckLogin'], function () {
    Route::get('/login',[HomeController::class, 'showLogin'] )->name('viewLogin');
    Route::post('/login',[HomeController::class, 'doLogin'] )->name('login');
});

Route::group(['middleware' => 'web'], function () {
    Route::post('/register', [UserController::class, 'create'])->name('register');
    Route::get('/register', [HomeController::class, 'showRegister'])->name('viewRegister');

});

Route::group(['middleware' => 'web'], function(){
    Route::get('/admin/post',[PostController::class, 'showListPost'])->name('viewListPost');
    Route::get('/admin/post/create',[PostController::class, 'showViewCreatePost'] )->name('view.createPost');
    Route::post('/admin/post/create',[PostController::class, 'createPost'] )->name('createPost');
    Route::get('/admin/post/edit/{id}',[PostController::class, 'showViewEditPost'] )->name('view.editPost');
    Route::post('/admin/post/edit/{id}',[PostController::class, 'editPost'])->name('editPost');
    Route::get('/admin/post/delete/{id}',[PostController::class, 'deletePost'] )->name('deletePost');
});

Route::get('/category/{id}',[PostController::class, 'getListPostByCategoryId'])->name('view.listPostByCategoryId');

Route::get('/mutators', function() {
    $user = App\Model\User::find(\Illuminate\Support\Facades\Auth::id());
    $user->setNameAttribute('NguyASena nANaskdka sd aks');

    return $user->name;
});

Route::get('/admin',[HomeController::class, 'showAdmin'])->name('admin');
Route::get('/admin/user',[HomeController::class, 'showUserForAdminPage'])->name('admin.user');
Route::get('/admin/role',[HomeController::class, 'showRoleForAdminPage'])->name('admin.role');


Route::get('/admin/delete-role/{id}',[RoleController::class, 'deleteRole'])->name('main.deleteRole');
Route::post('/role',[RoleController::class, 'addRole'])->name('addRole');
Route::post('/role-to-user',[RoleController::class, 'addRoleToUser'])->name('addRoleToUser');
