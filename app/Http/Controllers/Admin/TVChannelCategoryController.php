<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TVChannel;
use App\Models\TVChannelCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class TVChannelCategoryController extends Controller
{
    public function index()
    {
        $categories = TVChannelCategory::withCount('channels')
            ->orderBy('name')
            ->get();

        return view('admin.tv.categories.index', compact('categories'));
    }

    public function create()
    {
        $channels = TVChannel::orderBy('name')->get();

        return view('admin.tv.categories.create', compact('channels'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'      => 'required|string|max:100',
            'slug'      => 'nullable|string|max:100|unique:tv_channel_categories,slug',
            'channels'  => 'nullable|array',
            'channels.*' => 'exists:tv_channels,id'
        ]);

        $category = TVChannelCategory::create([
            'name' => $validated['name'],
            'slug' => $validated['slug'] ?? Str::slug($validated['name']),
        ]);

        if (!empty($validated['channels'])) {
            $category->channels()->sync($validated['channels']);
        }

        return redirect()
            ->route('admin.tv-categories.index')
            ->with('success', 'Categoria criada com sucesso!');
    }

    public function edit($id)
    {
        $category = TVChannelCategory::with('channels')->findOrFail($id);
        $channels = TVChannel::orderBy('name')->get();

        return view('admin.tv.categories.edit', compact('category', 'channels'));
    }

    public function update(Request $request, $id)
    {
        $category = TVChannelCategory::findOrFail($id);

        $validated = $request->validate([
            'name'       => 'required|string|max:100',
            'slug'       => 'nullable|string|max:100|unique:tv_channel_categories,slug,' . $category->id,
            'channels'   => 'nullable|array',
            'channels.*' => 'exists:tv_channels,id',
        ]);

        $category->update([
            'name' => $validated['name'],
            'slug' => $validated['slug'] ?? Str::slug($validated['name']),
        ]);

        // sincroniza os canais (remove e adiciona automaticamente)
        $category->channels()->sync($validated['channels'] ?? []);

        return redirect()
            ->route('admin.tv-categories.index')
            ->with('success', 'Categoria atualizada com sucesso!');
    }

    public function destroy($id)
    {
        $category = TVChannelCategory::findOrFail($id);
        $category->delete();
        return redirect()
            ->route('admin.tv-categories.index')
            ->with('success', 'Categoria deletada com sucesso!');
    }
}
