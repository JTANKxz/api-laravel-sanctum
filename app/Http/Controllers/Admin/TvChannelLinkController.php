<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TVChannel;
use App\Models\TVChannelLink;
use Illuminate\Http\Request;

class TvChannelLinkController extends Controller
{
    // Mostrar formulário de criação de link para um canal
    public function create(TVChannel $channel)
    {
        return view('admin.tv.link-create', compact('channel'));
    }

    // Salvar novo link
    public function store(Request $request, TVChannel $channel)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'url' => 'required|url',
            'type' => 'required|string|max:50',
            'player_sub' => 'nullable|string|max:255',
            'order' => 'nullable|integer',
        ]);

        $validated['tv_channel_id'] = $channel->id;

        TVChannelLink::create($validated);

        return redirect()->route('admin.tv.links', $channel)
            ->with('success', 'Link criado com sucesso!');
    }

    // Mostrar formulário de edição de link
    public function edit(TVChannelLink $link)
    {
        $channel = $link->channel;
        return view('admin.tv.link-edit', compact('link', 'channel'));
    }

    // Atualizar link existente
    public function update(Request $request, TVChannelLink $link)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'url' => 'required|url',
            'type' => 'required|string|max:50',
            'player_sub' => 'nullable|string|max:255',
            'order' => 'nullable|integer',
        ]);

        $link->update($validated);

        return redirect()->route('admin.tv.links', $link->tv_channel_id)
            ->with('success', 'Link atualizado com sucesso!');
    }

    // Deletar link
    public function destroy(TVChannelLink $link)
    {
        $channelId = $link->tv_channel_id;

        try {
            $link->delete();
            return redirect()->route('admin.tv.links', $channelId)
                ->with('success', 'Link deletado com sucesso!');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Erro ao deletar o link: ' . $e->getMessage());
        }
    }
}
