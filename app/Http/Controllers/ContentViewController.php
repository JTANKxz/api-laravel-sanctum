<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ContentView;
use Carbon\Carbon;

class ContentViewController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'content_id'   => 'required|integer',
            'content_type' => 'required|in:movie,series',
            'device_id'    => 'required|string',
            'title'        => 'required|string',
            'poster_url'   => 'nullable|string'
        ]);

        try {
            ContentView::create([
                'content_id'   => $request->content_id,
                'content_type' => $request->content_type,
                'device_id'    => $request->device_id,
                'title'        => $request->title,
                'poster_url'   => $request->poster_url,
                'viewed_date'  => Carbon::today(),
            ]);
        } catch (\Throwable $e) {
            // Se for duplicado (único por device_id + content + dia), apenas ignora
        }

        return response()->json([
            'success' => true,
            'message' => 'Visualização registrada com sucesso',
            'data' => [
                'content_id' => $request->content_id,
                'content_type' => $request->content_type,
                'title' => $request->title,
                'poster_url' => $request->poster_url
            ]
        ]);
    }
}
