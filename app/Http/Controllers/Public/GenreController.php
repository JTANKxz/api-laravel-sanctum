<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Genre;
use Illuminate\Support\Facades\DB;
use Illuminate\Pagination\Paginator;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Http\Request;

class GenreController extends Controller
{
    public function show($slug)
    {
        $genre = Genre::where('slug', $slug)->firstOrFail();

        $movies = $genre->movies()->select('*')->addSelect(DB::raw("'movie' as type"))->get();
        $series = $genre->series()->select('*')->addSelect(DB::raw("'serie' as type"))->get();

        $conteudos = $movies->concat($series)->sortByDesc('year')->values();

        $perPage = 24;
        Paginator::currentPageResolver(fn() => request()->input('page', 1));
        $currentPage = request()->input('page', 1);

        $currentItems = $conteudos->slice(($currentPage - 1) * $perPage, $perPage)->values();

        $paginated = new LengthAwarePaginator(
            $currentItems,
            $conteudos->count(),
            $perPage,
            $currentPage,
            ['path' => request()->url(), 'query' => ['page' => $currentPage]]
        );

        return view('public.genres.show', compact('genre', 'paginated'));
    }
}