<?php

use App\Http\Controllers\Dashboard\CategoryController;
use App\Http\Controllers\Dashboard\PostController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

// Route::get('/', function () {
//     return Inertia::render('Welcome', [
//         'canLogin' => Route::has('login'),
//         'canRegister' => Route::has('register'),
//         'laravelVersion' => Application::VERSION,
//         'phpVersion' => PHP_VERSION,
//     ]);
// });

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');

    Route::resource('/category', CategoryController::class);
});

// Route::inertia('/index-inertia','Dashboard/Post/Index');
// Route::get('/',[PostController::class, 'index']);

Route::group(['middleware' => [
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
]],function (){
    Route::resource('/category', CategoryController::class);
    Route::resource('/post', PostController::class);
    Route::post('/post/upload/{post}', [PostController::class,'upload'])->name('post.upload');
    Route::delete('/post/image/delete/{post}', [PostController::class,'deleteImage'])->name('post.image-delete');
});