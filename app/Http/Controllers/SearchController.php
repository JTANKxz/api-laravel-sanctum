<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Movie;
use App\Models\Serie;

class SearchController extends Controller
{
    public function search($query)
    {
        if (!$query || strlen($query) < 3) {
            return response()->json([
                'message' => 'A consulta deve ter pelo menos 3 caracteres.',
                'results' => [],
            ], 400);
        }

        $movies = Movie::where('title', 'LIKE', "%{$query}%")->get();
        $series = Serie::where('title', 'LIKE', "%{$query}%")->get();

        $results = $movies->concat($series)->sortByDesc('year')->values();

        return response()->json([
            'query' => $query,
            'results' => $results,
        ]);
    }
}
