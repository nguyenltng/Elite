<?php

use App\Http\Controllers\ImageController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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
//Route::delete('/delete-role/{id}',[UserController::class, 'deleteRole']);


Route::POST('/search', [UserController::class, 'searchUser']);
Route::POST('/save-image', [ImageController::class, 'saveImage']);
Route::POST('/load-image/{id}', [ImageController::class, 'loadImage']);

Route::post('/search', [UserController::class, 'searchUser']);
