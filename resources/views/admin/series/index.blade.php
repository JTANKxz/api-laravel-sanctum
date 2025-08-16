@extends('layouts.admin')

@section('title', 'Series')

@section('content')
<div class="mb-8">
    <h1 class="text-2xl font-bold mb-6">List Series</h1>

    <x-alert />

    <div class="bg-medium-gray rounded-xl shadow-lg p-6 animate-fadeIn w-full">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-xl font-bold">Series</h2>
            <a href="#"
                class="btn-hover bg-netflix-red hover:bg-red-800 text-white py-2 px-4 rounded-lg flex items-center">
                <i class="fas fa-plus mr-2"></i> Adicionar Novo
            </a>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full">
                <thead>
                    <tr class="border-b border-dark-gray">
                        <th class="py-3 px-4 text-left">ID</th>
                        <th class="py-3 px-4 text-left">Poster</th>
                        <th class="py-3 px-4 text-left">Title</th>
                        <th class="py-3 px-4 text-left">Year</th>
                        <th class="py-3 px-4 text-left">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($series as $serie)
                    <tr class="border-b border-dark-gray hover:bg-dark-gray">
                        <td class="py-3 px-4 text-gray-400">{{ $serie->id }}</td>

                        {{-- Poster separado --}}
                        <td class="py-3 px-4">
                            <img src="{{ $serie->poster_url ? $serie->poster_url : 'https://ui-avatars.com/api/?name=' . urlencode($serie->title) . '&background=random' }}"
                                alt="{{ $serie->title }}" class="rounded w-12 h-16 object-cover">

                        </td>

                        {{-- Título --}}
                        <td class="py-3 px-4 text-gray-200">{{ $serie->title }}</td>

                        {{-- Ano --}}
                        <td class="py-3 px-4 text-gray-400">{{ $serie->year }}</td>

                        {{-- Ações --}}
                        <td class="py-3 px-4 flex items-center space-x-2">
                            <a href="{{ route('admin.series.seasons', $serie->id) }}" class="text-blue-400 hover:text-blue-300">
                                <i class="fas fa-list"></i>
                            </a>

                            <a href="{{ route('admin.series.edit', $serie->id) }}" class="text-gray-400 hover:text-gray-300">
                                <i class="fas fa-edit"></i>
                            </a>

                            <form action="{{ route('admin.series.delete', $serie->id) }}" method="POST"
                                onsubmit="return confirm('Tem certeza que deseja excluir este filme?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-500 hover:text-red-400">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{-- Links de paginação --}}
        <div class="mt-4">
            {{ $series->links() }}
        </div>
    </div>
</div>
@endsection