<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\SupportTicket;
use Illuminate\Http\Request;

class SupportApiController extends Controller
{
    public function store(Request $request)
    {
        $user = $request->user();

        $data = $request->validate([
            'category' => ['required', 'in:movie,series,tv,app'],
            'problem' => ['required', 'string', 'max:255'],

            // 🔥 ITEM OPCIONAL
            'item_id' => ['nullable', 'integer'],
            'item_type' => ['nullable', 'in:movie,series,tv'],

            'message' => ['nullable', 'string'],
            'app_version' => ['nullable', 'string', 'max:50'],
        ]);

        // 🚨 REGRA IMPORTANTE
        if ($data['category'] === 'app') {
            $data['item_id'] = null;
            $data['item_type'] = null;
        }

        // 🚨 SE NÃO FOR APP, ITEM É OBRIGATÓRIO
        if ($data['category'] !== 'app' && empty($data['item_id'])) {
            return response()->json([
                'success' => false,
                'message' => 'Selecione o filme, série ou canal.'
            ], 422);
        }

        $ticket = SupportTicket::create([
            'user_id' => $user->id,
            'category' => $data['category'],
            'problem' => $data['problem'],
            'item_id' => $data['item_id'] ?? null,
            'item_type' => $data['item_type'] ?? null,
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
}
