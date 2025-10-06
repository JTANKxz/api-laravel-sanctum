@extends('layouts.admin')

@section('title', 'Seções do Catálogo')

@section('content')
    <div class="mb-8">
        <h1 class="text-2xl font-bold mb-6">App Explore Content</h1>

        <x-alert />

        <div class="bg-medium-gray rounded-xl shadow-lg p-6 animate-fadeIn w-full">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-xl font-bold">App Exolore Sections</h2>

                <a href="{{ route('admin.explore.create') }}"
                    class="btn-hover bg-netflix-red hover:bg-red-800 text-white py-2 px-4 rounded-lg flex items-center">
                    <i class="fas fa-plus mr-2"></i> Nova Seção
                </a>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full">
                    <thead>
                        <tr class="border-b border-dark-gray">
                            <th class="py-3 px-4 text-left">ID</th>
                            <th class="py-3 px-4 text-left">Título</th>
                            <th class="py-3 px-4 text-left">Tipo</th>
                            <th class="py-3 px-4 text-left">Referência</th>
                            <th class="py-3 px-4 text-left">Ordem</th>
                            <th class="py-3 px-4 text-left">Ativa</th>
                            <th class="py-3 px-4 text-left">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($sections as $section)
                            <tr class="border-b border-dark-gray hover:bg-dark-gray">
                                {{-- ID --}}
                                <td class="py-3 px-4 text-gray-400">{{ $section->id }}</td>

                                {{-- Título --}}
                                <td class="py-3 px-4 text-gray-200 font-medium">{{ $section->title }}</td>

                                {{-- Tipo --}}
                                <td class="py-3 px-4 text-gray-300 capitalize">
                                    @switch($section->type)
                                        @case('movies')
                                            🎬 Filmes
                                            @break
                                        @case('series')
                                            📺 Séries
                                            @break
                                        @case('genre')
                                            🏷️ Gênero
                                            @break
                                        @case('network')
                                            🌐 Network
                                            @break
                                        @case('collection')
                                            📦 Coleção
                                            @break
                                        @case('custom')
                                            ⭐ Personalizada
                                            @break
                                        @default
                                            {{ ucfirst($section->type) }}
                                    @endswitch
                                </td>

                                {{-- Referência (nome do item vinculado, se houver) --}}
                                <td class="py-3 px-4 text-gray-400">
                                    {{ $section->reference?->name ?? '-' }}
                                </td>

                                {{-- Ordem --}}
                                <td class="py-3 px-4 text-gray-400">{{ $section->order }}</td>

                                {{-- Ativo --}}
                                <td class="py-3 px-4">
                                    @if ($section->is_active)
                                        <span class="text-green-400 font-semibold">Ativo</span>
                                    @else
                                        <span class="text-red-400 font-semibold">Inativo</span>
                                    @endif
                                </td>

                                {{-- Ações --}}
                                <td class="py-3 px-4 flex items-center space-x-3">
                                    <a href="{{ route('admin.explore.edit', $section->id) }}"
                                        class="text-blue-500 hover:text-blue-400">
                                        <i class="fas fa-edit"></i>
                                    </a>

                                    <form action="{{ route('admin.explore.delete', $section->id) }}" method="POST"
                                        onsubmit="return confirm('Tem certeza que deseja excluir esta seção?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-500 hover:text-red-400">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-6 text-gray-500">Nenhuma seção cadastrada.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
