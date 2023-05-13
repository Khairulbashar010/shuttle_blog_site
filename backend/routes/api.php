<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\TagController;
use App\Http\Controllers\CategoryController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::group(['prefix' => 'posts'], function () {
    // Posts Routes
    Route::get('/', [PostController::class, 'index']);
    Route::post('/', [PostController::class, 'store']);
    Route::get('{slug}', [PostController::class, 'show']);
    Route::post('{id}', [PostController::class, 'update']);
    Route::delete('{id}', [PostController::class, 'destroy']);
});

Route::group(['prefix' => 'comments'], function () {
    // Comments Routes
    Route::get('posts/{id}', [CommentController::class, 'index']);
    Route::post('posts/{id}', [CommentController::class, 'store']);
    Route::get('{id}', [CommentController::class, 'show']);
    Route::delete('{id}', [CommentController::class, 'destroy']);
});

Route::group(['prefix' => 'tags'], function () {
    // Tags Routes
    Route::get('/', [TagController::class, 'index']);
    Route::post('/', [TagController::class, 'store']);
    Route::get('{name}', [TagController::class, 'show']);
    Route::patch('{id}', [TagController::class, 'update']);
    Route::delete('{id}', [TagController::class, 'destroy']);
});

Route::group(['prefix' => 'categories'], function () {
    // Category Routes
    Route::get('/', [CategoryController::class, 'index']);
    Route::post('/', [CategoryController::class, 'store']);
    Route::get('{id}', [CategoryController::class, 'show']);
    Route::patch('{id}', [CategoryController::class, 'update']);
    Route::delete('{id}', [CategoryController::class, 'destroy']);
});
