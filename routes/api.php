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
use App\Http\Controllers\WatchListController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout']);

//auth sanctum route
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/watch-list', [WatchListController::class, 'getWatchlist']);//OK✅
    Route::post('/favorite', [WatchListController::class, 'toggleWatchlist']);//OK✅
});

Route::get('/favorites/check', function (Request $request) {
    $request->validate([
        'id' => 'required|integer',
        'type' => 'required|string|in:movie,serie',
    ]);

    $user = Auth::user();

    $exists = $user->favorites()
        ->where('type', $request->type)
        ->where('item_id', $request->id)
        ->exists();

    return response()->json(['is_favorite' => $exists]);
})->middleware('auth:sanctum');

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

Route::post('/save-token', function (Request $request) {
    $request->validate([
        'fcm_token' => 'required|string'
    ]);

    // Salva em uma tabela de tokens
    DB::table('device_tokens')->updateOrInsert(
        ['fcm_token' => $request->fcm_token],
        ['updated_at' => now()]
    );

    return response()->json(['status' => 'Token salvo com sucesso']);
});