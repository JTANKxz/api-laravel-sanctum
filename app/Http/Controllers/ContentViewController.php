<?php

namespace App\Http\Controllers;

use App\Models\ContentView;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ContentViewController extends Controller
{
    /**
     * Registra uma visualização de conteúdo
     * 1 view por device / conteúdo / dia
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'content_id'   => 'required|integer',
            'content_type' => 'required|in:movie,series',
            'device_id'    => 'required|string|max:100',
        ]);

        try {
            ContentView::create([
                'content_id'   => $validated['content_id'],
                'content_type' => $validated['content_type'],
                'device_id'    => $validated['device_id'],
                'viewed_date'  => Carbon::today(),
            ]);
        } catch (\Throwable $e) {
            /**
             * Aqui NÃO fazemos nada de propósito.
             * Se cair aqui, significa que:
             * - O usuário já contou view hoje
             * - O índice UNIQUE bloqueou
             */
        }

        return response()->json([
            'success' => true
        ]);
    }
}
