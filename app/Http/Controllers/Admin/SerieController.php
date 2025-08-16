<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Episode;
use App\Models\Season;
use App\Models\Serie;
use Illuminate\Http\Request;

class SerieController extends Controller
{
    public function index()
    {
        $series = Serie::orderByDesc('id')->paginate(20);
        return view('admin.series.index', compact('series'));
    }

    public function manageSeasons(Serie $serie)
    {
        $seasons = $serie->seasons()->orderBy('season_number')->get();
        return view('admin.series.seasons', compact('serie', 'seasons'));
    }

    public function manageEpisodes(Serie $serie, Season $season)
    {
        $episodes = $season->episodes()->orderBy('episode_number')->get();
        return view('admin.series.episodes', compact('serie', 'season', 'episodes'));
    }

    public function deleteSeason(Serie $serie, Season $season)
    {
        $season->delete();

        return redirect()->route('admin.series.seasons', $serie)
            ->with('success', 'Temporada deletada com sucesso!');
    }

    public function deleteEpisode(Serie $serie, Season $season, Episode $episode)
    {
        $episode->delete();

        return redirect()->route('admin.series.episodes', [
            'serie'  => $serie->id,
            'season' => $season->id
        ])->with('success', 'Episódio deletado com sucesso!');
    }

    public function destroy($id)
    {
        $serie = Serie::find($id);
        $serie->delete();
        return redirect()->route('admin.series.index')
            ->with('success', 'Série deletada com sucesso!');
    }
}
