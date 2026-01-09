<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Movie;
use App\Models\MoviePlayLink;

class MovieController extends Controller
{
    public function index()
    {
        $movies = Movie::orderByDesc('id')->paginate(20);
        return view('admin.movies.index', compact('movies'));
    }

    public function edit($id)
    {
        $movie = Movie::find($id);
        return view('admin.movies.show', compact('movie'));
    }

    public function linkManager(Movie $movie)
    {
        $links = $movie->playLinks;
        return view('admin.movies.links', ['movie' => $movie, 'links' => $links]);
    }

    public function destroy($id)
    {
        $movie = Movie::find($id);
        $movie->delete();
        return redirect()->route('admin.movies.index')
            ->with('success', 'Filme deletado com sucesso!');
    }

    public function search(Request $request)
    {
        $query = $request->get('q');

        $movies = Movie::where('title', 'like', "%{$query}%")
            ->orderByDesc('id')
            ->limit(20)
            ->get();

        return response()->json($movies);
    }
}
