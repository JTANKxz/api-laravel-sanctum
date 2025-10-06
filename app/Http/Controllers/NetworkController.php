<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Network;
use Illuminate\Http\Request;

class NetworkController extends Controller
{
    /**
     * Listar todas as networks
     */
    public function index()
    {
        $networks = Network::select('id', 'name', 'slug', 'logo_url')->get();

        return response()->json([
            'success' => true,
            'data' => $networks
        ]);
    }

    /**
     * Listar todos os conteúdos de uma network
     */
    public function showContents($id)
    {
        $network = Network::with(['movies', 'series'])->find($id);

        if (!$network) {
            return response()->json([
                'success' => false,
                'message' => 'Network não encontrada'
            ], 404);
        }

        // Unir filmes e séries em um único array (opcional: adicionar type)
        $contents = collect();

        $network->movies->each(function($movie) use ($contents) {
            $contents->push([
                'id' => $movie->id,
                'title' => $movie->title,
                'slug' => $movie->slug,
                'year' => $movie->year,
                'rating' => $movie->rating,
                'poster_url' => $movie->poster_url,
                'type' => 'movie'
            ]);
        });

        $network->series->each(function($serie) use ($contents) {
            $contents->push([
                'id' => $serie->id,
                'title' => $serie->title,
                'slug' => $serie->slug,
                'year' => $serie->year,
                'rating' => $serie->rating,
                'poster_url' => $serie->poster_url,
                'type' => 'serie'
            ]);
        });

        return response()->json([
            'success' => true,
            'data' => $contents
        ]);
    }
}
