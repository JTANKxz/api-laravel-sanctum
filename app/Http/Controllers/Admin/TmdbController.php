<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use App\Models\AppConfig;
use App\Models\Episode;
use App\Models\Movie;
use App\Models\Genre;
use App\Models\Season;
use App\Models\Serie;

class TmdbController extends Controller
{
    private $tmdbKey;

    public function __construct()
    {
        $this->tmdbKey = AppConfig::value('tmdb_key');
    }

    public function index()
    {
        return view('admin.tmdb.index');
    }

    public function search(Request $request)
    {
        $request->validate([
            'title' => 'required|string',
            'type' => 'required|in:movie,tv',
        ]);

        $url = "https://api.themoviedb.org/3/search/{$request->type}?api_key={$this->tmdbKey}&language=pt-BR&query=" . urlencode($request->title);
        $response = Http::get($url);

        return response()->json($response->json());
    }

    public function import(Request $request)
    {
        $request->validate(['tmdb_id' => 'required|integer']);

        $tmdbId = $request->tmdb_id;
        $movieData = $this->fetchMovieData($tmdbId);
        $imagesData = $this->fetchMovieImages($tmdbId);

        $movie = $this->createOrUpdateMovie($tmdbId, $movieData, $imagesData);
        $this->syncGenres($movie, $movieData['genres'] ?? []);

        return response()->json([
            'message' => 'Filme importado com sucesso!',
            'movie_id' => $movie->id,
        ]);
    }

    public function importSerie(Request $request)
    {
        $tmdbId = $request->tmdb_id;
        $serieData = $this->fetchSerieData($tmdbId);
        $imagesData = $this->fetchSerieImages($tmdbId);

        $serie = $this->createOrUpdateSerie($tmdbId, $serieData, $imagesData);
        $this->syncGenres($serie, $serieData['genres'] ?? []);

        return response()->json([
            'message' => 'Série importada com sucesso!',
            'serie_id' => $serie->id,
            'seasons' => $this->extractSeasonsData($serieData['seasons'])
        ]);
    }

    public function importSeasons(Request $request)
    {
        $tmdbId = $request->tmdb_id;
        $serie = Serie::where('tmdb_id', $tmdbId)->firstOrFail();
        $serieData = $this->fetchSerieData($tmdbId);

        $importedSeasons = [];
        foreach ($serieData['seasons'] as $seasonData) {
            if ($seasonData['season_number'] > 0) {
                $season = $this->createOrUpdateSeason($serie->id, $seasonData);
                $importedSeasons[] = [
                    'season_number' => $season->season_number,
                    'name' => $season->name
                ];
            }
        }

        return response()->json([
            'message' => 'Temporadas importadas com sucesso!',
            'serie_id' => $serie->id,
            'seasons' => $importedSeasons
        ]);
    }

    public function getSeasons(Request $request)
    {
        $tmdbId = $request->tmdb_id;
        $serie = Serie::where('tmdb_id', $tmdbId)->firstOrFail();
        $serieData = $this->fetchSerieData($tmdbId);

        return response()->json([
            'seasons' => $this->extractSeasonsData($serieData['seasons'])
        ]);
    }

    public function importEpisodes(Request $request)
    {
        $request->validate([
            'serie_tmdb_id' => 'required|integer',
            'season_number' => 'required|integer'
        ]);

        $tmdbSerieId = $request->serie_tmdb_id;
        $seasonNumber = $request->season_number;

        $serie = Serie::where('tmdb_id', $tmdbSerieId)->firstOrFail();
        $seasonData = $this->fetchSeasonData($tmdbSerieId, $seasonNumber);

        $season = $this->createOrUpdateSeason($serie->id, $seasonData);
        $importedEpisodes = $this->importSeasonEpisodes($season, $seasonData['episodes']);

        return response()->json([
            'message' => 'Episódios importados com sucesso!',
            'episodes_count' => count($importedEpisodes),
            'season_number' => $season->season_number
        ]);
    }

    public function importAllEpisodes(Request $request)
    {
        $serieId = $request->serie_id;
        $serie = Serie::findOrFail($serieId);
        $serieData = $this->fetchSerieData($serie->tmdb_id);

        $results = [];
        foreach ($serieData['seasons'] as $seasonData) {
            if ($seasonData['season_number'] > 0) {
                $season = $this->createOrUpdateSeason($serie->id, $seasonData);
                $episodesData = $this->fetchSeasonData($serie->tmdb_id, $seasonData['season_number']);
                $importedEpisodes = $this->importSeasonEpisodes($season, $episodesData['episodes']);

                $results[] = [
                    'season' => $season->season_number,
                    'episodes' => count($importedEpisodes)
                ];
            }
        }

        return response()->json([
            'message' => 'Todos os episódios importados com sucesso!',
            'results' => $results
        ]);
    }

    // Métodos auxiliares privados

    private function fetchMovieData($tmdbId)
    {
        $response = Http::get("https://api.themoviedb.org/3/movie/{$tmdbId}", [
            'api_key' => $this->tmdbKey,
            'language' => 'pt-BR'
        ]);

        if (!$response->successful()) {
            abort(422, 'Erro ao buscar dados do filme.');
        }

        return $response->json();
    }

    private function fetchMovieImages($tmdbId)
    {
        $response = Http::get("https://api.themoviedb.org/3/movie/{$tmdbId}/images", [
            'api_key' => $this->tmdbKey
        ]);

        return $response->successful() ? $response->json() : [];
    }

    private function fetchSerieData($tmdbId)
    {
        $response = Http::get("https://api.themoviedb.org/3/tv/{$tmdbId}", [
            'api_key' => $this->tmdbKey,
            'language' => 'pt-BR'
        ]);

        if (!$response->successful()) {
            abort(422, 'Erro ao buscar dados da série.');
        }

        return $response->json();
    }

    private function fetchSerieImages($tmdbId)
    {
        $response = Http::get("https://api.themoviedb.org/3/tv/{$tmdbId}/images", [
            'api_key' => $this->tmdbKey
        ]);

        return $response->successful() ? $response->json() : [];
    }

    private function fetchSeasonData($tmdbSerieId, $seasonNumber)
    {
        $response = Http::get("https://api.themoviedb.org/3/tv/{$tmdbSerieId}/season/{$seasonNumber}", [
            'api_key' => $this->tmdbKey,
            'language' => 'pt-BR'
        ]);

        if (!$response->successful()) {
            abort(422, 'Erro ao buscar dados da temporada.');
        }

        return $response->json();
    }

    private function createOrUpdateMovie($tmdbId, $data, $imagesData)
    {
        $poster = $this->findBestImage($imagesData['posters'] ?? [], $data['poster_path']);
        $backdrop = $data['backdrop_path'] ?? null;

        return Movie::updateOrCreate(
            ['tmdb_id' => $data['id']],
            [
                'title' => $data['title'],
                'slug' => Str::slug($data['title']),
                'year' => substr($data['release_date'] ?? '', 0, 4),
                'overview' => $data['overview'],
                'poster_url' => $poster ? 'https://image.tmdb.org/t/p/w500' . $poster : null,
                'backdrop_url' => $backdrop ? 'https://image.tmdb.org/t/p/w1280' . $backdrop : null,
                'runtime' => $data['runtime'] ?? null,
                'rating' => $data['vote_average'] ?? null,
                'imdb_id' => $data['imdb_id'] ?? null,
            ]
        );
    }

    private function createOrUpdateSerie($tmdbId, $data, $imagesData)
    {
        $poster = $this->findBestImage($imagesData['posters'] ?? [], $data['poster_path']);
        $backdrop = $data['backdrop_path'] ?? null;

        return Serie::updateOrCreate(
            ['tmdb_id' => $data['id']],
            [
                'title' => $data['name'],
                'slug' => Str::slug($data['name']),
                'year' => substr($data['first_air_date'] ?? '', 0, 4),
                'overview' => $data['overview'],
                'poster_url' => $poster ? 'https://image.tmdb.org/t/p/w500' . $poster : null,
                'backdrop_url' => $backdrop ? 'https://image.tmdb.org/t/p/w1280' . $backdrop : null,
                'rating' => $data['vote_average'],
            ]
        );
    }

    private function createOrUpdateSeason($serieId, $seasonData)
    {
        return Season::updateOrCreate(
            [
                'serie_id' => $serieId,
                'season_number' => $seasonData['season_number']
            ],
            [
                'name' => $seasonData['name'],
                'poster_url' => $seasonData['poster_path']
                    ? 'https://image.tmdb.org/t/p/w500' . $seasonData['poster_path']
                    : null
            ]
        );
    }

    private function importSeasonEpisodes($season, $episodesData)
    {
        $imported = [];

        foreach ($episodesData as $episodeData) {
            $imported[] = Episode::updateOrCreate(
                ['tmdb_id' => $episodeData['id']],
                [
                    'season_id' => $season->id,
                    'episode_number' => $episodeData['episode_number'],
                    'name' => $episodeData['name'],
                    'overview' => $episodeData['overview'],
                    'still_url' => $episodeData['still_path']
                        ? 'https://image.tmdb.org/t/p/w500' . $episodeData['still_path']
                        : null,
                    'air_date' => $episodeData['air_date'] ?? null,
                    'runtime' => $episodeData['runtime'] ?? null
                ]
            );
        }

        return $imported;
    }

    private function syncGenres($model, $genresData)
    {
        $genreIds = [];

        foreach ($genresData as $genreData) {
            $genre = Genre::firstOrCreate(
                ['tmdb_id' => $genreData['id']],
                ['name' => $genreData['name']]
            );
            $genreIds[] = $genre->id;
        }

        $model->genres()->sync($genreIds);
    }

    private function findBestImage($images, $default = null)
    {
        $poster = collect($images)->first(fn($img) => $img['iso_639_1'] === 'pt-BR')
            ?? collect($images)->first(fn($img) => $img['iso_639_1'] === 'pt')
            ?? collect($images)->first(fn($img) => $img['iso_639_1'] === null)
            ?? collect($images)->first();

        return $poster['file_path'] ?? $default;
    }

    private function extractSeasonsData($seasons)
    {
        return collect($seasons)
            ->filter(fn($s) => $s['season_number'] > 0)
            ->map(fn($s) => [
                'season_number' => $s['season_number'],
                'name' => $s['name'],
                'episode_count' => $s['episode_count'],
                'poster_path' => $s['poster_path']
            ])
            ->values()
            ->toArray();
    }
}
