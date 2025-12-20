@extends('layouts.admin')

@section('title', 'Categorias de Canais')

@section('content')
    <div class="mb-8">
        <h1 class="text-2xl font-bold mb-6">Categorias de Canais</h1>

        <x-alert />

        <div class="bg-medium-gray rounded-xl shadow-lg p-6 animate-fadeIn w-full">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-xl font-bold">Categorias</h2>

                <a href="{{ route('admin.tv-categories.create') }}"
                    class="btn-hover bg-netflix-red hover:bg-red-800 text-white py-2 px-4 rounded-lg flex items-center">
                    <i class="fas fa-plus mr-2"></i> Nova Categoria
                </a>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full">
                    <thead>
                        <tr class="border-b border-dark-gray">
                            <th class="py-3 px-4 text-left">ID</th>
                            <th class="py-3 px-4 text-left">Nome</th>
                            <th class="py-3 px-4 text-left">Slug</th>
                            <th class="py-3 px-4 text-left">Canais</th>
                            <th class="py-3 px-4 text-left">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($categories as $category)
                            <tr class="border-b border-dark-gray hover:bg-dark-gray">
                                <td class="py-3 px-4 text-gray-400">
                                    {{ $category->id }}
                                </td>

                                <td class="py-3 px-4 text-gray-200 font-medium">
                                    {{ $category->name }}
                                </td>

                                <td class="py-3 px-4 text-gray-400">
                                    {{ $category->slug }}
                                </td>

                                <td class="py-3 px-4 text-gray-300">
                                    {{ $category->channels_count }}
                                </td>

                                <td class="py-3 px-4 flex items-center space-x-3">
                                    <a href="{{ route('admin.tv-categories.edit', $category->id) }}"
                                        class="text-gray-400 hover:text-gray-300" title="Editar">
                                        <i class="fas fa-edit"></i>
                                    </a>

                                    <form action="{{ route('admin.tv-categories.destroy', $category->id) }}" method="POST"
                                        onsubmit="return confirm('Deseja excluir esta categoria?');">
                                        @csrf
                                        @method('DELETE')

                                        <button type="submit" class="text-red-500 hover:text-red-400" title="Excluir">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="py-6 text-center text-gray-400">
                                    Nenhuma categoria cadastrada.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
