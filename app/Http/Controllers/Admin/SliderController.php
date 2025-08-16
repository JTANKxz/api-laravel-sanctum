<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Movie;
use App\Models\Serie;
use App\Models\Slider;
use Illuminate\Http\Request;

class SliderController extends Controller
{
    public function index()
    {
        $sliders = Slider::all();
        return view('admin.sliders.index', compact('sliders'));
    }

    public function create()
    {
        return view('admin.sliders.create');
    }

    public function search(Request $request)
    {
        $type = $request->input('type');
        $query = $request->input('query');

        if ($type === 'movie') {
            // Busca na tabela movies, trazendo slug, rating, etc
            $results = Movie::where('title', 'like', "%{$query}%")
                ->select('id', 'slug', 'title', 'year', 'runtime', 'backdrop_url', 'rating')
                ->get();
        } elseif ($type === 'serie') {
            $results = Serie::withCount('seasons')
                ->where('title', 'like', "%{$query}%")
                ->select('id', 'slug', 'title', 'year', 'backdrop_url', 'rating')
                ->get()
                ->map(function ($serie) {
                    $serie->season_count = $serie->seasons_count;
                    return $serie;
                });
        } else {
            $results = collect();
        }

        return response()->json($results);
    }

    public function store(Request $request)
    {
        $slider = Slider::create($request->all());
        return redirect()->route('admin.sliders.index')->with('success', 'Slider criado com sucesso!');
    }

    public function destroy(Slider $slider)
    {
        try {
            $slider->delete();
            return redirect()->route('admin.sliders.index')->with('success', 'Slider deletado com sucesso!');
        } catch (\Exception $e) {
            return redirect()->route('admin.sliders.index')->with('error', 'Failed to delete slider.');
        }
    }
}
