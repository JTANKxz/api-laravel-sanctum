<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;


class WatchListController extends Controller
{
    public function toggleWatchlist(Request $request)
    {
        $validated = $request->validate([
            'id' => 'required|integer',
            'type' => 'required|string|in:movie,serie',
        ]);

        $user = Auth::user();
        $id = $validated['id'];
        $type = $validated['type'];

        $wasAdded = false;

        if ($type === 'movie') {
            $syncResult = $user->watchlistMovies()->toggle([$id]);
            $wasAdded = !empty($syncResult['attached']);
        } else {
            $syncResult = $user->watchlistSeries()->toggle([$id]);
            $wasAdded = !empty($syncResult['attached']);
        }

        $message = $wasAdded ? 'Adicionado à sua lista!' : 'Removido da sua lista!';

        // Sempre retorna JSON, independente do tipo de requisição
        return response()->json([
            'message' => $message,
            'added' => $wasAdded,
        ]);
    }


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

    public function checkWatchlist(Request $request)
    {
        $user = Auth::user();
        $id = $request->query('id');
        $type = $request->query('type'); // "movie" ou "serie"

        $exists = false;
        if ($type === 'movie') {
            $exists = $user->watchlistMovies()->where('watchlist.content_id', $id)->exists();
        } else if ($type === 'serie') {
            $exists = $user->watchlistSeries()->where('watchlist.content_id', $id)->exists();
        }

        return response()->json(['exists' => $exists]);
    }
}
