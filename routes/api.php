<?php

use App\Http\Controllers\SupportApiController;
use App\Http\Controllers\AppConfigController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ChannelsController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\ContentViewController;
use App\Http\Controllers\MovieController;
use App\Http\Controllers\SerieController;
use App\Http\Controllers\CustomSectionController;
use App\Http\Controllers\ExploreSectionController;
use App\Http\Controllers\GenreController;
use App\Http\Controllers\NetworkController;
use App\Http\Controllers\PlansController;
use App\Http\Controllers\PremiumCodeController;
use App\Http\Controllers\RankingController;
use App\Http\Controllers\RequestOrderController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\UserApiController;
use App\Http\Controllers\UserDeviceController;
use App\Http\Controllers\WatchListController;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

//auth sanctum route
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/me', [AuthController::class, 'me']);
    Route::get('/watch-list', [WatchListController::class, 'getWatchlist']); //OK✅
    Route::post('/favorite', [WatchListController::class, 'toggleWatchlist']); //OK✅
    Route::get('/watch-list/check', [WatchListController::class, 'checkWatchlist']); //OK✅
    Route::post('/redeem', [PremiumCodeController::class, 'redeem']); // ✅ NOVO
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::put('/user', [UserApiController::class, 'update']);
    Route::post('/banana', [CheckoutController::class, 'create']);
    Route::post('/support', [SupportApiController::class, 'store']);
    Route::get('/support/search', [SupportApiController::class, 'search']);
});
Route::get('/plans', [PlansController::class, 'index']); //OK✅

//começa aqui
Route::get('/home', [HomeController::class, 'index']); //OK✅
Route::get('/movies', [MovieController::class, 'index']); //OK✅
Route::get('/series', [SerieController::class, 'index']); //OK✅
Route::get('/movie/{id}', [MovieController::class, 'show']); //OK✅
Route::get('/serie/{id}', [SerieController::class, 'show']); //OK✅
Route::get('/custom_section/{id}', [CustomSectionController::class, 'show']); //OK✅
Route::get('/genre/{id}', [GenreController::class, 'show']); //OK✅
Route::get('/genres', [GenreController::class, 'index']); //OK✅
Route::get('/search/{query}', [SearchController::class, 'search']); //OK✅
Route::get('/channels', [ChannelsController::class, 'index']); //OK✅

Route::get('/networks', [NetworkController::class, 'index']); //OK✅
Route::get('/networks/{id}', [NetworkController::class, 'showContents']); //OK✅
Route::get('/explore', [ExploreSectionController::class, 'index']); //OK✅

//firebase
Route::post('/user/device', [UserDeviceController::class, 'store']);

Route::get('/appMessgae', [AppConfigController::class, 'getCustomMessage']);
Route::get('/appUpdate', [AppConfigController::class, 'getAppUptade']);
Route::get('/appName', [AppConfigController::class, 'getAppName']);
Route::get('/appConfig', [AppConfigController::class, 'getConfig']);


Route::post('/content/view', [ContentViewController::class, 'store']);
Route::get('/top-week', [RankingController::class, 'topWeek']);
Route::get('/top-movies', [RankingController::class, 'topMovies']);
Route::get('/top-series', [RankingController::class, 'topSeries']);
