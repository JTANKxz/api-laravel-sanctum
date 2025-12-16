<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AutoEmbedUrl;
use Illuminate\Http\Request;

class AutoEmbedUrlController extends Controller
{
    public function index()
    {
        $embeds = AutoEmbedUrl::orderBy('order')->get();

        return view('admin.embeds.index', compact('embeds'));
    }

    public function create()
    {
        return view('admin.embeds.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'         => 'required|string',
            'url'          => 'required|string',
            'id_type'      => 'required|string',
            'type'         => 'required|string',
            'player_sub'   => 'required|string',
            'quality'      => 'required|string',
            'active'       => 'required|boolean',
            'order'        => 'nullable|integer',
            'content_type' => 'required|string',
        ]);

        AutoEmbedUrl::create($data);

        return redirect()
            ->route('admin.embeds.index')
            ->with('success', 'Embed criado com sucesso!');
    }

    public function edit(AutoEmbedUrl $autoEmbed)
    {
        return view('admin.embeds.edit', [
            'embed' => $autoEmbed, // 🔑 nome que a view espera
        ]);
    }

    public function update(Request $request, AutoEmbedUrl $autoEmbed)
    {
        $data = $request->validate([
            'name'         => 'required|string',
            'url'          => 'required|string',
            'id_type'      => 'required|string',
            'type'         => 'required|string',
            'player_sub'   => 'required|string',
            'quality'      => 'required|string',
            'active'       => 'required|boolean',
            'order'        => 'nullable|integer',
            'content_type' => 'required|string',
        ]);

        $autoEmbed->update($data);

        return redirect()
            ->route('admin.embeds.index')
            ->with('success', 'Embed atualizado com sucesso!');
    }

    public function destroy(AutoEmbedUrl $autoEmbed)
    {
        $autoEmbed->delete();

        return back()->with('success', 'Embed removido!');
    }
}
