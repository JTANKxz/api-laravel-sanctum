<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\AppConfig;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class OrderController extends Controller
{

    private $tmdbKey;

    public function __construct()
    {
        $this->tmdbKey = AppConfig::value('tmdb_key');
    }

    /**
     * Pesquisa filmes ou séries no TMDB
     * GET /api/orders/search
     */
    public function search(Request $request)
    {
        $request->validate([
            'query' => 'required|string|min:2',
            'type'  => 'required|in:movie,tv',
        ]);

        $query = $request->query('query');
        $type  = $request->query('type'); // movie | tv

        $tmdbBaseUrl = 'https://api.themoviedb.org/3';

        $response = Http::get("{$tmdbBaseUrl}/search/{$type}", [
            'api_key' => $this->tmdbKey,
            'language' => 'pt-BR',
            'query' => $query,
            'page' => 1,
        ]);

        if ($response->failed()) {
            return response()->json([
                'message' => 'Erro ao buscar dados no TMDB'
            ], 500);
        }

        $results = collect($response->json('results'))->map(function ($item) use ($type) {
            return [
                'tmdb_id' => $item['id'],
                'type' => $type,
                'title' => $type === 'movie'
                    ? ($item['title'] ?? null)
                    : ($item['name'] ?? null),
                'poster_url' => isset($item['poster_path'])
                    ? 'https://image.tmdb.org/t/p/w500' . $item['poster_path']
                    : null,
                'year' => $type === 'movie'
                    ? substr($item['release_date'] ?? '', 0, 4)
                    : substr($item['first_air_date'] ?? '', 0, 4),
                'overview' => $item['overview'] ?? null,
            ];
        });

        return response()->json([
            'query' => $query,
            'type' => $type,
            'results' => $results,
        ]);
    }

    /**
     * Criar pedido de filme ou série
     * POST /api/orders
     */
    public function store(Request $request)
    {
        $request->validate([
            'type' => 'required|in:movie,tv',
            'tmdb_id' => 'required|integer',
            'title' => 'required|string',
            'poster_url' => 'nullable|string',
            'year' => 'nullable|string',
        ]);

        $user = Auth::user();

        /* ============================
     * Limite DIÁRIO por plano
     * ============================ */

        $maxOrders = $user->isPremium() ? 5 : 2;

        $today = \Carbon\Carbon::today();

        $activeOrdersCount = Order::where('user_id', $user->id)
            ->whereDate('created_at', $today)
            ->count();

        if ($activeOrdersCount >= $maxOrders) {
            return response()->json([
                'code' => $user->isPremium()
                    ? 'ORDER_LIMIT_PREMIUM'
                    : 'ORDER_LIMIT_FREE',
                'message' => $user->isPremium()
                    ? 'Você atingiu o limite de pedidos diário do seu plano.'
                    : 'Usuários gratuitos podem fazer até 2 pedidos por dia.',
                'limit' => $maxOrders
            ], 403);
        }

        /* ============================
     * Evita pedido duplicado
     * ============================ */

        $alreadyExists = Order::where('user_id', $user->id)
            ->where('tmdb_id', $request->tmdb_id)
            ->where('type', $request->type)
            ->whereIn('status', ['pending', 'approved', 'available'])
            ->exists();

        if ($alreadyExists) {
            return response()->json([
                'code' => 'ORDER_ALREADY_EXISTS',
                'message' => 'Você já fez um pedido para este título.'
            ], 409);
        }

        /* ============================
     * Criação do pedido
     * ============================ */

        $order = Order::create([
            'user_id' => $user->id,
            'type' => $request->type,
            'tmdb_id' => $request->tmdb_id,
            'title' => $request->title,
            'poster_url' => $request->poster_url,
            'year' => $request->year,
            'status' => 'pending',
            'total' => 0,
            'details' => null,
        ]);

        return response()->json([
            'message' => 'Pedido enviado com sucesso!',
            'order' => $order,
            'remaining' => $maxOrders - ($activeOrdersCount + 1),
        ], 201);
    }
}
