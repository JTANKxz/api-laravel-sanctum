<?php

namespace App\Http\Controllers\Admin;

use App\Models\Episode;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\EpisodePlayLink;

class EpisodePlayLinkController extends Controller
{

    public function index(Episode $episode)
    {
        $links = $episode->playLinks;
        return view('admin.series.links', compact('episode', 'links'));
    }

    public function create(Episode $episode)
    {
        return view('admin.series.link-create', compact('episode'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'episode_id' => 'required|exists:episodes,id',
            'url' => 'required|url',
            'name' => 'required',
            'type' => 'required',
            'quality' => 'required',
            'order' => 'required',
            'player_sub' => 'required',
        ]);

        EpisodePlayLink::create($validated);
        return redirect()->route('admin.episodes.links', ['episode' => $validated['episode_id']])
            ->with('success', 'Link criado com sucesso!');
    }

    public function edit(EpisodePlayLink $link)
    {
        return view('admin.series.link-edit', compact('link'));
    }

    public function update(Request $request, EpisodePlayLink $link)
    {
        $validated = $request->validate([
            'episode_id' => 'required|exists:episodes,id',
            'url' => 'required|url',
            'name' => 'required',
            'type' => 'required',
            'quality' => 'required',
            'order' => 'required',
            'player_sub' => 'required',
        ]);

        $link->update($validated);
        return redirect()->route('admin.episodes.links', ['episode' => $link->episode->id])
            ->with('success', 'Link atualizado com sucesso!');
    }

    public function destroy(EpisodePlayLink $link)
    {
        $link->delete();
        return redirect()->route('admin.episodes.links', ['episode' => $link->episode->id])
            ->with('success', 'Link deletado com sucesso!');
    }
}