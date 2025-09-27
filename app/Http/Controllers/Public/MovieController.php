<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Movie;
use App\Models\MoviePlayLink;
use App\Models\AutoEmbedUrls;
use Illuminate\Http\Request;

class MovieController extends Controller
{
    public function index()
    {
        $movies = Movie::orderByDesc('id')->paginate(24);
        return view('public.movies.index', compact('movies'));
    }

    // ===== Show por SLUG =====
    public function show($slug)
    {
        $movie  = Movie::where('slug', $slug)->firstOrFail();
        $genres = $movie->genres;

        // Links salvos manualmente
        $links  = MoviePlayLink::where('movie_id', $movie->id)->get();

        // -------- AutoEmbed --------
        $autoEmbeds = AutoEmbedUrls::where('active', true)
            ->whereIn('content_type', ['movie', 'both'])
            ->orderBy('order')
            ->get()
            ->map(function ($embed) use ($movie) {
                $url    = $embed->url;
                $idType = null;

                if (str_contains($url, '{imdb_id}')) {
                    $url    = str_replace('{imdb_id}', $movie->imdb_id, $url);
                    $idType = 'imdb';
                } elseif (str_contains($url, '{tmdb_id}')) {
                    $url    = str_replace('{tmdb_id}', $movie->tmdb_id, $url);
                    $idType = 'tmdb';
                }

                return [
                    'id'         => null,
                    'movie_id'   => $movie->id,
                    'name'       => $embed->name,
                    'quality'    => $embed->quality,
                    'order'      => $embed->order,
                    'url'        => $url,
                    'type'       => $embed->type,
                    'player_sub' => $embed->player_sub,
                    'auto'       => true,
                    'id_type'    => $idType,
                ];
            });

        // Junta links do banco + auto-embeds
        $allLinks = array_merge($links->toArray(), $autoEmbeds->toArray());

        // Filmes relacionados
        $relatedMovies = Movie::whereHas('genres', function ($query) use ($genres) {
            $query->whereIn('genres.id', $genres->pluck('id'));
        })
            ->where('movies.id', '!=', $movie->id)
            ->latest()
            ->limit(10)
            ->get();

        return view('public.movies.show', [
            'movie'         => $movie,
            'genres'        => $genres,
            'links'         => $allLinks,
            'relatedMovies' => $relatedMovies,
        ]);
    }

    // ===== Show por TMDB_ID =====
    public function showByTmdb($tmdbId)
    {
        $movie  = Movie::where('tmdb_id', $tmdbId)->firstOrFail();
        $genres = $movie->genres;

        // Links salvos manualmente
        $links  = MoviePlayLink::where('movie_id', $movie->id)->get();

        // -------- AutoEmbed --------
        $autoEmbeds = AutoEmbedUrls::where('active', true)
            ->whereIn('content_type', ['movie', 'both'])
            ->orderBy('order')
            ->get()
            ->map(function ($embed) use ($movie) {
                $url    = $embed->url;
                $idType = null;

                if (str_contains($url, '{imdb_id}')) {
                    $url    = str_replace('{imdb_id}', $movie->imdb_id, $url);
                    $idType = 'imdb';
                } elseif (str_contains($url, '{tmdb_id}')) {
                    $url    = str_replace('{tmdb_id}', $movie->tmdb_id, $url);
                    $idType = 'tmdb';
                }

                return [
                    'id'         => null,
                    'movie_id'   => $movie->id,
                    'name'       => $embed->name,
                    'quality'    => $embed->quality,
                    'order'      => $embed->order,
                    'url'        => $url,
                    'type'       => $embed->type,
                    'player_sub' => $embed->player_sub,
                    'auto'       => true,
                    'id_type'    => $idType,
                ];
            });

        // Junta links do banco + auto-embeds
        $allLinks = array_merge($links->toArray(), $autoEmbeds->toArray());

        // Filmes relacionados
        $relatedMovies = Movie::whereHas('genres', function ($query) use ($genres) {
            $query->whereIn('genres.id', $genres->pluck('id'));
        })
            ->where('movies.id', '!=', $movie->id)
            ->latest()
            ->limit(10)
            ->get();

        return view('public.movies.show', [
            'movie'         => $movie,
            'genres'        => $genres,
            'links'         => $allLinks,
            'relatedMovies' => $relatedMovies,
        ]);
    }
}
