<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TVChannel;
use App\Models\TVChannelLink;

class TvChannelController extends Controller
{
    // Listar todos os canais
    public function index()
    {
        $channels = TVChannel::with('links')->get();
        return view('admin.tv.index', compact('channels'));
    }

    // Mostrar formulário de criação
    public function create()
    {
        return view('admin.tv.create');
    }

    // Salvar novo canal
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:tv_channels,slug',
            'description' => 'nullable|string',
            'image_url' => 'nullable|url',
        ]);

        $channel = TVChannel::create($validated);

        return redirect()->route('admin.tv.index')
            ->with('success', 'Canal criado com sucesso!');
    }

    // Mostrar formulário de edição
    public function edit(TVChannel $channel)
    {
        return view('admin.tv.edit', compact('channel'));
    }

    // Atualizar canal existente
    public function update(Request $request, TVChannel $channel)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:tv_channels,slug,' . $channel->id,
            'description' => 'nullable|string',
            'image_url' => 'nullable|url',
        ]);

        $channel->update($validated);

        return redirect()->route('admin.tv.index')
            ->with('success', 'Canal atualizado com sucesso!');
    }

    // Deletar canal
    public function destroy(TVChannel $channel)
    {
        try {
            $channel->delete();
            return redirect()->route('admin.tv.index')
                ->with('success', 'Canal deletado com sucesso!');
        } catch (\Exception $e) {
            return redirect()->route('admin.tv.index')
                ->with('error', 'Falha ao deletar o canal.');
        }
    }
}
