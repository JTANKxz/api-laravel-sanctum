<?php

namespace App\Http\Controllers;

use App\Models\AppConfig;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class RequestOrderController extends Controller
{
    private $apiKey;

    public function __construct()
    {
        $this->apiKey = AppConfig::value('tmdb_key');
    }

    // Retorna lista de pedidos do usuário logado
    public function index(Request $request)
    {
        $user = $request->user();
        $orders = $user->orders()->get();

        return response()->json($orders);
    }

    // Pesquisa em tempo real no TMDb
    public function search(Request $request)
    {
        $query = $request->query('query');
        if (!$query) {
            return response()->json([]);
        }

        $tmdbUrl = "https://api.themoviedb.org/3/search/multi";

        $response = Http::get($tmdbUrl, [
            'api_key' => $this->apiKey,
            'language' => 'pt-BR',
            'query' => $query,
            'include_adult' => false
        ]);

        return response()->json($response->json()['results'] ?? []);
    }

    // Cria um novo pedido
    public function store(Request $request)
    {
        $request->validate([
            'tmdb_id' => 'required|integer',
            'type' => 'required|in:movie,serie',
            'title' => 'required|string|max:255',
            'poster_url' => 'nullable|string|max:255',
            'year' => 'nullable|integer'
        ]);

        $user = $request->user();

        $order = Order::create([
            'user_id' => $user->id,
            'tmdb_id' => $request->tmdb_id,
            'type' => $request->type,
            'title' => $request->title,
            'poster_url' => $request->poster_url,
            'year' => $request->year,
            'status' => 'pending', // status inicial
            'total' => 0,
            'details' => null
        ]);

        return response()->json([
            'message' => 'Pedido criado com sucesso',
            'order' => $order
        ], 201);
    }
}
