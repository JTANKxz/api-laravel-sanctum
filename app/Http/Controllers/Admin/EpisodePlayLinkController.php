<?php

namespace App\Http\Controllers\Admin;

use App\Models\Episode;
use App\Models\Serie;
use App\Models\Season;
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

    public function bulkLinks(Serie $serie)
    {
        // pega a primeira temporada, ou todas
        $season = $serie->seasons()->first();

        $episodes = $season->episodes()->with('playLinks')->get();
        return view('admin.links.episodes', compact('serie', 'season', 'episodes'));
    }


    public function bulkStore(Request $request, Serie $serie)
    {
        $data = $request->all();

        foreach ($data['episodes'] as $epId => $links) {
            foreach ($links as $link) {
                if (!empty($link['id'])) {
                    $playLink = \App\Models\EpisodePlayLink::find($link['id']);
                    if ($playLink) {
                        $playLink->update($link);
                    }
                } else {
                    if (!empty($link['url'])) {
                        $link['episode_id'] = $epId;
                        \App\Models\EpisodePlayLink::create($link);
                    }
                }
            }
        }

        return redirect()->route('admin.links.bulkLinks', [$serie->id])
            ->with('success', 'Links salvos com sucesso!');
    }



    public function destroy(EpisodePlayLink $link)
    {
        $link->delete();
        return redirect()->route('admin.episodes.links', ['episode' => $link->episode->id])
            ->with('success', 'Link deletado com sucesso!');
    }
}
