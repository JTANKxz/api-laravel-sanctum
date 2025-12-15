<?php

namespace App\Http\Controllers\Public;

use App\Models\CustomHomeSection;
use App\Models\Genre;
use App\Models\Movie;
use App\Models\Serie;
use App\Models\Slider;
use Illuminate\Http\Request;

class HomeController
{

    public function index()
    {
        $sliders = Slider::all();
        $genres = Genre::all();
        $movies = Movie::query()->orderBy('id', 'desc')->limit(15)->get();
        $series = Serie::query()->orderBy('id', 'desc')->limit(15)->get();
        $sections = CustomHomeSection::with('items')->orderBy('order')->get();
        $genreSections = Genre::with([
            'movies' => fn($q) => $q->latest()->limit(10),
            'series' => fn($q) => $q->latest()->limit(10)
        ])->take(5)->get();


        return view('public/index', compact('sliders', 'genres', 'movies', 'series', 'sections', 'genreSections'));
    }

    public function appDownload()
    {
        return view('public/app-download');
    }
}
