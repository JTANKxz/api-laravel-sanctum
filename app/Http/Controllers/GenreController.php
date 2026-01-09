<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Genre;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class GenreController extends Controller
{
    public function index(Request $request)
    {
        $genres = Genre::all();
        return response()->json($genres);
    }

    public function show(Request $request, $id)
    {
        $page = (int) $request->query('page', 1);
        $pageSize = (int) $request->query('pageSize', 20);

        $genre = Genre::findOrFail($id);

        // Filmes do gênero
        $moviesQuery = $genre->movies()
            ->select('*')
            ->addSelect(DB::raw("'movie' as type"))
            ->orderByDesc('year');

        $movies = $moviesQuery
            ->skip(($page - 1) * $pageSize)
            ->take($pageSize)
            ->get();

        // Séries do gênero
        $seriesQuery = $genre->series()
            ->select('*')
            ->addSelect(DB::raw("'serie' as type"))
            ->orderByDesc('year');

        $series = $seriesQuery
            ->skip(($page - 1) * $pageSize)
            ->take($pageSize)
            ->get();

        // Concatena filmes e séries
        $conteudos = $movies->concat($series)
            ->sortByDesc('year') // ordena por ano
            ->values();

        return response()->json([
            'genre' => $genre,
            'conteudos' => $conteudos,
            'page' => $page,
            'pageSize' => $pageSize
        ]);
    }

    public function showBySlug(Request $request, $slug)
    {
        $page = (int) $request->query('page', 1);
        $pageSize = (int) $request->query('pageSize', 20);

        $genre = Genre::where('slug', $slug)->firstOrFail();

        // Filmes do gênero
        $moviesQuery = $genre->movies()
            ->select('*')
            ->addSelect(DB::raw("'movie' as type"))
            ->orderByDesc('year');

        $movies = $moviesQuery
            ->skip(($page - 1) * $pageSize)
            ->take($pageSize)
            ->get();

        // Séries do gênero
        $seriesQuery = $genre->series()
            ->select('*')
            ->addSelect(DB::raw("'serie' as type"))
            ->orderByDesc('year');

        $series = $seriesQuery
            ->skip(($page - 1) * $pageSize)
            ->take($pageSize)
            ->get();

        // Concatena filmes e séries
        $conteudos = $movies->concat($series)
            ->sortByDesc('year')
            ->values();

        return response()->json([
            'genre' => $genre,
            'conteudos' => $conteudos,
            'page' => $page,
            'pageSize' => $pageSize
        ]);
    }
}
