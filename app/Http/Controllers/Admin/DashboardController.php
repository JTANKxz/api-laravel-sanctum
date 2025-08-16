<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Movie;
use App\Models\Serie;
use App\Models\Slider;

class DashboardController extends Controller
{

    public function index()
    {
        $userCount = User::count();
        $movieCount = Movie::count();
        $serieCount = Serie::count();

        // Últimos 5 de cada
        $users = User::orderByDesc('id')->take(5)->get();

        $movies = Movie::orderByDesc('id')->take(5)->get()->map(function ($movie) {
            $movie->type = 'Filme';
            return $movie;
        });

        $series = Serie::orderByDesc('id')->take(5)->get()->map(function ($serie) {
            $serie->type = 'Série';
            return $serie;
        });

        $sliders = Slider::orderByDesc('id')->take(5)->get();

        // Lista unificada, caso queira exibir juntos
        $media = $movies->merge($series)->sortByDesc('created_at');

        return view('admin.dashboard', compact(
            'userCount',
            'movieCount',
            'serieCount',
            'users',
            'sliders',
            'movies',
            'series',
            'media' // essa é opcional, só se precisar mostrar juntos
        ));
    }

    public function searchMovies(Request $request)
    {
        $query = $request->input('q');

        $results = Movie::where('title', 'like', "%{$query}%")
            ->select('id', 'title', 'year', 'poster_url')
            ->limit(15)
            ->get();

        return response()->json($results);
    }

    public function searchSeries(Request $request)
    {
        $query = $request->input('q');

        $results = Serie::where('title', 'like', "%{$query}%")
            ->select('id', 'title', 'year', 'poster_url')
            ->limit(15)
            ->get();

        return response()->json($results);
    }

    public function deleteSlider(Slider $slider)
    {
        try {
            $slider->delete();
            return redirect()->route('admin.dashboard')->with('success', 'Slider deletado com sucesso!');
        } catch (\Exception $e) {
            return redirect()->route('admin.dashboard')->with('error', 'Failed to delete slider.');
        }
    }
}
