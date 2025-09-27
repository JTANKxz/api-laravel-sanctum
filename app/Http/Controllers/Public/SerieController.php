<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\AutoEmbedUrls;
use App\Models\Serie;
use Illuminate\Http\Request;

class SerieController extends Controller
{
    public function index()
    {
        $series = Serie::orderByDesc('id')->paginate(24);
        return view('public.series.index', ['series' => $series]);
    }

    public function show($slug)
    {
        $serie = Serie::withCount('seasons')->where('slug', $slug)->firstOrFail();

        // Carrega temporadas e episódios com playLinks
        $seasons = $serie->seasons()
            ->with(['episodes' => function ($q) {
                $q->orderBy('episode_number')->with('playLinks');
            }])
            ->orderBy('season_number')
            ->get();

        $genres = $serie->genres;

        // Pega todos os auto-embeds ativos (sem filtrar ainda por content_type)
        $autoEmbedsBase = AutoEmbedUrls::where('active', true)
            ->orderBy('order')
            ->get();

        // Se quiser debugar: 
        // dd($autoEmbedsBase->pluck('content_type', 'id')->toArray());

        // Filtrar aceitando tanto strings quanto códigos numéricos
        $autoEmbedsBase = $autoEmbedsBase->filter(function ($e) {
            $ct = (string) $e->content_type;
            return in_array($ct, ['series', 'serie', 'both', '2', '3']); // ajuste conforme seu DB
        })->values();

        foreach ($seasons as $season) {
            foreach ($season->episodes as $episode) {

                // transforma links manuais em array padronizado
                $manualLinks = $episode->playLinks->map(function ($l) use ($episode) {
                    return [
                        'id' => $l->id,
                        'episode_id' => $episode->id,
                        'name' => $l->name ?? 'Player',
                        'quality' => $l->quality ?? null,
                        'order' => $l->order ?? 0,
                        'url' => $l->url ?? null,
                        'type' => $l->type ?? null,
                        'player_sub' => $l->player_sub ?? null,
                        'auto' => false,
                        'id_type' => null,
                    ];
                })->toArray();

                // gera auto-embeds substituindo placeholders
                $autoEmbeds = $autoEmbedsBase->map(function ($embed) use ($serie, $season, $episode) {
                    $url = $embed->url;
                    $idType = null;

                    if (str_contains($url, '{imdb_id}')) {
                        $url = str_replace('{imdb_id}', $serie->imdb_id ?? '', $url);
                        $idType = 'imdb';
                    }
                    if (str_contains($url, '{tmdb_id}')) {
                        $url = str_replace('{tmdb_id}', $serie->tmdb_id ?? '', $url);
                        $idType = 'tmdb';
                    }
                    if (str_contains($url, '{season}')) {
                        $url = str_replace('{season}', $season->season_number, $url);
                    }
                    if (str_contains($url, '{episode}')) {
                        $url = str_replace('{episode}', $episode->episode_number, $url);
                    }

                    return [
                        'id' => null,
                        'episode_id' => $episode->id,
                        'name' => $embed->name,
                        'quality' => $embed->quality,
                        'order' => $embed->order,
                        'url' => $url,
                        'type' => $embed->type,
                        'player_sub' => $embed->player_sub,
                        'auto' => true,
                        'id_type' => $idType,
                    ];
                })->toArray();

                // junta manual + auto (se quiser ordenar por order depois, faça usort)
                $episode->all_links = array_values(array_merge($manualLinks, $autoEmbeds));
            }
        }

        $relatedSeries = Serie::whereHas('genres', function ($q) use ($genres) {
            $q->whereIn('genres.id', $genres->pluck('id'));
        })
            ->where('series.id', '!=', $serie->id)
            ->latest()
            ->limit(10)
            ->get();

        return view('public.series.show', compact('serie', 'genres', 'seasons', 'relatedSeries'));
    }

    public function showByTmdb($tmdbId)
    {
        // Busca a série pelo TMDB ID e conta as temporadas
        $serie = Serie::withCount('seasons')->where('tmdb_id', $tmdbId)->firstOrFail();

        // Carrega temporadas e episódios com seus links
        $seasons = $serie->seasons()
            ->with(['episodes' => function ($q) {
                $q->orderBy('episode_number')->with('playLinks');
            }])
            ->orderBy('season_number')
            ->get();

        $genres = $serie->genres;

        // Pega todos os auto-embeds ativos
        $autoEmbedsBase = AutoEmbedUrls::where('active', true)
            ->orderBy('order')
            ->get();

        // Filtra apenas os que são para séries
        $autoEmbedsBase = $autoEmbedsBase->filter(function ($e) {
            $ct = (string) $e->content_type;
            return in_array($ct, ['series', 'serie', 'both', '2', '3']); // ajuste conforme seu DB
        })->values();

        // Para cada temporada e episódio
        foreach ($seasons as $season) {
            foreach ($season->episodes as $episode) {

                // Transformar links manuais em array padronizado
                $manualLinks = $episode->playLinks->map(function ($l) use ($episode) {
                    return [
                        'id' => $l->id,
                        'episode_id' => $episode->id,
                        'name' => $l->name ?? 'Player',
                        'quality' => $l->quality ?? null,
                        'order' => $l->order ?? 0,
                        'url' => $l->url ?? null,
                        'type' => $l->type ?? null,
                        'player_sub' => $l->player_sub ?? null,
                        'auto' => false,
                        'id_type' => null,
                    ];
                })->toArray();

                // Gera auto-embeds substituindo placeholders
                $autoEmbeds = $autoEmbedsBase->map(function ($embed) use ($serie, $season, $episode) {
                    $url = $embed->url;
                    $idType = null;

                    if (str_contains($url, '{imdb_id}')) {
                        $url = str_replace('{imdb_id}', $serie->imdb_id ?? '', $url);
                        $idType = 'imdb';
                    }
                    if (str_contains($url, '{tmdb_id}')) {
                        $url = str_replace('{tmdb_id}', $serie->tmdb_id ?? '', $url);
                        $idType = 'tmdb';
                    }
                    if (str_contains($url, '{season}')) {
                        $url = str_replace('{season}', $season->season_number, $url);
                    }
                    if (str_contains($url, '{episode}')) {
                        $url = str_replace('{episode}', $episode->episode_number, $url);
                    }

                    return [
                        'id' => null,
                        'episode_id' => $episode->id,
                        'name' => $embed->name,
                        'quality' => $embed->quality,
                        'order' => $embed->order,
                        'url' => $url,
                        'type' => $embed->type,
                        'player_sub' => $embed->player_sub,
                        'auto' => true,
                        'id_type' => $idType,
                    ];
                })->toArray();

                // Junta links manuais + auto
                $episode->all_links = array_values(array_merge($manualLinks, $autoEmbeds));
            }
        }

        // Busca séries relacionadas pelos mesmos gêneros
        $relatedSeries = Serie::whereHas('genres', function ($q) use ($genres) {
            $q->whereIn('genres.id', $genres->pluck('id'));
        })
            ->where('series.id', '!=', $serie->id)
            ->latest()
            ->limit(10)
            ->get();

        return view('public.series.show', compact('serie', 'genres', 'seasons', 'relatedSeries'));
    }
}
