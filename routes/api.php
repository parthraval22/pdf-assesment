<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\MyFileController;

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

Route::post('/register', [UserController::class, 'register']);

Route::group(['middleware' => 'auth:users'], function () {
    Route::post('/user', [UserController::class, 'user']);
    Route::get('/myFiles', [MyFileController::class, 'myFiles']);
    Route::post('/upload', [MyFileController::class, 'upload']);
    Route::post('/replace', [MyFileController::class, 'replace']);
    Route::post('/delete', [MyFileController::class, 'delete']);
    Route::post('/tag', [MyFileController::class, 'tag']);
});