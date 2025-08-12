<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class WatchListController extends Controller
{
    public function getWatchlist()
    {
        $user = Auth::user();
        if (!$user) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        $user->load('watchlistMovies', 'watchlistSeries');

        $watchlist = [
            'movies' => $user->watchlistMovies,
            'series' => $user->watchlistSeries,
        ];
        
        return response()->json($watchlist);
    }
}