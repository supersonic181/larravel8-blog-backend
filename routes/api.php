<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\TagController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['middleware' => 'auth:sanctum'], function () {

    // Auth Controller
    Route::post("/auth/logout", [AuthController::class, 'logout']);
    Route::get("/auth/profile", [AuthController::class, 'profile']);
    
    // Category Route
    Route::get("/category/view-all", [CategoryController::class, 'getCategory']);
    Route::post("/category/create", [CategoryController::class, 'createCategory']);
    Route::put("/category/{category}", [CategoryController::class, 'updateCategory']);
    Route::delete("/category/{category}", [CategoryController::class, 'deleteCategory']);

    // Tag Route
    Route::get("/tag/view-all", [TagController::class, 'getTag']);
    Route::post("/tag/create", [TagController::class, 'createTag']);
    Route::put("/tag/{tag}", [TagController::class, 'updateTag']);
    Route::delete("/tag/{tag}", [TagController::class, 'deleteTag']);

    // Post Route
    Route::get("/post/view-all",  [PostController::class, 'getAllPost']);
    Route::get("/post/{post}",  [PostController::class, 'getPostById']);
    Route::post("/post/create",  [PostController::class, 'createPost']);
    Route::post("/post/video/video-post",  [PostController::class, 'createVideoPost']);
    Route::delete("/post/{post}",  [PostController::class, 'deletePostById']);
    Route::post("/post/{post}",  [PostController::class, 'updatePost']);
});

// Auth Route
Route::post("/auth/register", [AuthController::class, 'register']);
Route::post("/auth/login", [AuthController::class, 'login']);



