<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ChannelsController;
use App\Http\Controllers\MovieController;
use App\Http\Controllers\SerieController;
use App\Http\Controllers\CustomSectionController;
use App\Http\Controllers\GenreController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\UserDeviceController;
use App\Http\Controllers\WatchListController;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

//auth sanctum route
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/watch-list', [WatchListController::class, 'getWatchlist']);//OK✅
    Route::post('/favorite', [WatchListController::class, 'toggleWatchlist']);//OK✅
    Route::get('/watch-list/check', [WatchListController::class, 'checkWatchlist']);
    Route::post('/logout', [AuthController::class, 'logout']);
});

//começa aqui
Route::get('/home', [HomeController::class, 'index']);//OK✅
Route::get('/movies', [MovieController::class, 'index']);//OK✅
Route::get('/series', [SerieController::class, 'index']);//OK✅
Route::get('/movie/{id}', [MovieController::class, 'show']);//OK✅
Route::get('/serie/{id}', [SerieController::class, 'show']);//OK✅
Route::get('/custom_section/{id}', [CustomSectionController::class, 'show']);//OK✅
Route::get('/genre/{id}', [GenreController::class, 'show']);//OK✅
Route::get('/search/{query}', [SearchController::class, 'search']);//OK✅
Route::get('/channels', [ChannelsController::class, 'index']);//OK✅
Route::post('/devices', [UserDeviceController::class, 'store']);