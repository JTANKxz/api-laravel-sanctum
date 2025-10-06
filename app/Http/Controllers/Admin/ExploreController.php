<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Network;
use App\Models\Movie;
use App\Models\SectionExplore;
use App\Models\Serie;
use Illuminate\Http\Request;

class ExploreController extends Controller
{
    public function index()
    {
        $sections = SectionExplore::orderBy('id')->get();
        return view('admin.explore.index', compact('sections'));
    }

    public function create()
    {
        return view('admin.explore.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            // Adicione os novos tipos aqui:
            'type' => 'required|in:movies,series,genre,network,collection,custom,collections_list,networks_list,genres_list', 
            'reference_id' => 'nullable|integer',
            'order' => 'nullable|integer',
            'is_active' => 'boolean'
        ]);
        
        

        SectionExplore::create($validated);

        return redirect()->route('admin.explore.index')->with('success', 'Seção criada com sucesso!');
    }

    public function edit(SectionExplore $section)
    {
        return view('admin.explore.edit', compact('section'));
    }

    public function update(Request $request, SectionExplore $section)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            // Adicione os novos tipos aqui:
            'type' => 'required|in:movies,series,genre,network,collection,custom,collections_list,networks_list,genres_list', 
            'reference_id' => 'nullable|integer',
            'order' => 'nullable|integer',
            'is_active' => 'boolean'
        ]);
        
        

        $section->update($validated);

        return redirect()->route('admin.explore.index')->with('success', 'Seção atualizada!');
    }

    public function destroy(SectionExplore $section)
    {
        $section->delete();
        return redirect()->back()->with('success', 'Seção removida!');
    }

}