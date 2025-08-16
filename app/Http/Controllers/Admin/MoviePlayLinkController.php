<?php

namespace App\Http\Controllers\Admin;

use App\Models\Movie;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\MoviePlayLink;

class MoviePlayLinkController extends Controller
{
    public function create(Movie $movie)
    {
        return view('admin.movies.link-create', ['movie' => $movie]);
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'movie_id' => 'required|exists:movies,id',
                'url' => 'required|url',
                'name' => 'required',
                'type' => 'required',
                'order' => 'nullable|integer',
                'quality' => 'nullable',
            ]);

            MoviePlayLink::create($validated);
            return redirect()->route('admin.movies.links', ['movie' => $validated['movie_id']])->with('success', 'Link criado com sucesso!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Erro ao criar o link: ' . $e->getMessage());
        }
    }

    public function edit(MoviePlayLink $link)
    {
        return view('admin.movies.link-edit', ['link' => $link]);
    }

    public function update(Request $request, MoviePlayLink $link)
    {
        try {
            $validated = $request->validate([
                'movie_id' => 'required|exists:movies,id',
                'url' => 'required|url',
                'name' => 'required',
                'type' => 'required',
                'order' => 'nullable|integer',
                'quality' => 'nullable',
            ]);

            $link->update($validated);

            return redirect()->route('admin.movies.links', ['movie' => $validated['movie_id']])->with('success', 'Link criado com sucesso!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Erro ao atualizar o link: ' . $e->getMessage());
        }
    }

    public function destroy(MoviePlayLink $link)
    {
        try {
            $link->delete();
            return redirect()->route('admin.movies.links', ['movie' => $link->movie_id])->with('success', 'Link deletado com sucesso!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Erro ao deletar o link: ' . $e->getMessage());
        }
    }
}
