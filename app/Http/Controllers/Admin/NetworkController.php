<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Network;
use App\Models\Movie;
use App\Models\Serie;
use Illuminate\Http\Request;

class NetworkController extends Controller
{
    public function index()
    {
        $networks = Network::all();
        return view('admin.networks.index', compact('networks'));
    }

    public function create()
    {
        return view('admin.networks.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'logo_url' => 'nullable|url|max:255',
            'items.*.content_id' => 'required|integer',
            'items.*.content_type' => 'required|string|in:movie,serie',
        ]);

        // Cria a Network
        $network = Network::create([
            'name' => $data['name'],
            'slug' => \Str::slug($data['name']),
            'logo_url' => $data['logo_url'] ?? null,
        ]);

        // Associa os conteúdos selecionados
        if (!empty($data['items'])) {
            foreach ($data['items'] as $item) {
                if ($item['content_type'] === 'movie') {
                    $movie = Movie::find($item['content_id']);
                    if ($movie) $network->movies()->attach($movie);
                } elseif ($item['content_type'] === 'serie') {
                    $serie = Serie::find($item['content_id']);
                    if ($serie) $network->series()->attach($serie);
                }
            }
        }

        return redirect()->route('admin.networks.index')
                         ->with('success', 'Network criada com sucesso!');
    }
}
