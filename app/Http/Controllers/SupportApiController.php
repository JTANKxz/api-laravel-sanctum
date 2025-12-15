<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Movie;
use App\Models\Serie;
use App\Models\SupportTicket;
use App\Models\TVChannel;
use Illuminate\Http\Request;

class SupportApiController extends Controller
{
    public function store(Request $request)
    {
        $user = $request->user();

        $data = $request->validate([
            'category' => ['required', 'in:movie,series,tv,app'],
            'problem' => ['required', 'string', 'max:255'],

            // 🔥 ITEM (SÓ QUANDO NÃO FOR APP)
            'item_name' => ['nullable', 'string', 'max:255'],
            'item_type' => ['nullable', 'in:movie,series,tv'],

            'message' => ['nullable', 'string'],
            'app_version' => ['nullable', 'string', 'max:50'],
        ]);

        // 🚨 SE FOR APP, LIMPA ITEM
        if ($data['category'] === 'app') {
            $data['item_name'] = null;
            $data['item_type'] = null;
        }

        // 🚨 SE NÃO FOR APP, ITEM É OBRIGATÓRIO
        if ($data['category'] !== 'app') {
            if (empty($data['item_name']) || empty($data['item_type'])) {
                return response()->json([
                    'success' => false,
                    'message' => 'Selecione o filme, série ou canal.'
                ], 422);
            }
        }

        $ticket = SupportTicket::create([
            'user_id' => $user->id,
            'category' => $data['category'],
            'problem' => $data['problem'],
            'item_name' => $data['item_name'],
            'item_type' => $data['item_type'],
            'message' => $data['message'] ?? null,
            'app_version' => $data['app_version'] ?? null,
            'status' => 'open',
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Suporte enviado com sucesso.',
            'ticket_id' => $ticket->id,
        ], 201);
    }

    /**
     * 🔍 Busca de itens para o suporte
     */
    public function search(Request $request)
    {
        $data = $request->validate([
            'type' => ['required', 'in:movie,series,tv'],
            'q' => ['required', 'string', 'min:2'],
        ]);

        [$query, $field] = match ($data['type']) {
            'movie' => [Movie::query(), 'title'],
            'series' => [Serie::query(), 'title'],
            'tv' => [TVChannel::query(), 'name'],
        };

        $items = $query
            ->where($field, 'like', '%' . $data['q'] . '%')
            ->limit(20)
            ->get()
            ->map(fn ($item) => [
                'id' => $item->id,
                // 🔥 padroniza para o app
                'name' => $item->{$field},
            ]);

        return response()->json([
            'success' => true,
            'data' => $items,
        ]);
    }
}
