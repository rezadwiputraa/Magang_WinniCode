<?php

use App\Http\Controllers\AuthorController;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\NewsController;
use Illuminate\Support\Facades\Route;
use Livewire\Livewire;

/* NOTE: Do Not Remove
/ Livewire asset handling if using sub folder in domain
*/
Livewire::setUpdateRoute(function ($handle) {
    return Route::post(config('app.asset_prefix') . '/livewire/update', $handle);
});

Livewire::setScriptRoute(function ($handle) {
    return Route::get(config('app.asset_prefix') . '/livewire/livewire.js', $handle);
});
/*
/ END
*/
// === LANDING ROUTE ===
Route::get('/', [LandingController::class, 'index'])->name('landing');

// Route untuk halaman hasil pencarian utama
Route::get('/search', [LandingController::class, 'search'])->name('news.search');

// === NEWS ROUTE ===
Route::get('/{slug}', [NewsController::class, 'category'])->name('news.category');
Route::get('/news/{slug}', [NewsController::class, 'show'])->name('news.show');
Route::get('/author/{username}', [AuthorController::class, 'show'])->name('author.show');




// === COMMENT ROUTE ===
Route::post('/news/{news}/comment', [NewsController::class, 'comment'])->name('news.comment');
Route::post('/comment/{comment}/reply', [NewsController::class, 'reply'])->name('news.reply');

Route::post('/comments/{comment}/reply', [NewsController::class, 'reply'])->name('comments.reply');

// === ROUTE LOAD MORE ===
Route::get('/news/{news}/load-comments', [NewsController::class, 'loadMoreComments'])->name('news.load_comments');
