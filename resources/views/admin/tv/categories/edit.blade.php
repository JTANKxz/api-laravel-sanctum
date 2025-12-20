@extends('layouts.admin')

@section('title', 'Editar Categoria de Canal')

@section('content')

<div class="bg-medium-gray rounded-xl shadow-lg p-6 animate-fadeIn">
    <h2 class="text-xl font-bold mb-6">Editar Categoria de Canal</h2>

    <x-alert />

    <form action="{{ route('admin.tv-categories.update', $category->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

            {{-- Nome --}}
            <div>
                <label class="block text-gray-400 mb-2">Nome</label>
                <input type="text"
                    name="name"
                    value="{{ old('name', $category->name) }}"
                    class="w-full bg-dark-gray border border-gray-700 rounded-lg py-2 px-4 text-white focus:outline-none focus:ring-2 focus:ring-netflix-red">
            </div>

            {{-- Slug --}}
            <div>
                <label class="block text-gray-400 mb-2">Slug</label>
                <input type="text"
                    name="slug"
                    value="{{ old('slug', $category->slug) }}"
                    class="w-full bg-dark-gray border border-gray-700 rounded-lg py-2 px-4 text-white focus:outline-none focus:ring-2 focus:ring-netflix-red">
            </div>

            {{-- Canais --}}
            <div class="md:col-span-2">
                <label class="block text-gray-400 mb-2">Canais da Categoria</label>

                <div class="grid grid-cols-2 md:grid-cols-4 gap-3 max-h-64 overflow-y-auto bg-dark-gray p-4 rounded-lg border border-gray-700">
                    @foreach($channels as $channel)
                        <label class="flex items-center space-x-2 text-gray-300">
                            <input type="checkbox"
                                name="channels[]"
                                value="{{ $channel->id }}"
                                {{ $category->channels->contains($channel->id) ? 'checked' : '' }}
                                class="rounded bg-gray-700 border-gray-600 text-netflix-red focus:ring-netflix-red">
                            <span>{{ $channel->name }}</span>
                        </label>
                    @endforeach
                </div>
            </div>

        </div>

        {{-- Botões --}}
        <div class="mt-6 flex justify-end space-x-3">
            <a href="{{ route('admin.tv-categories.index') }}"
               class="bg-gray-700 hover:bg-gray-600 text-white py-2 px-4 rounded">
                Voltar
            </a>

            <button type="submit"
                class="bg-netflix-red hover:bg-red-800 text-white py-2 px-6 rounded">
                Salvar Alterações
            </button>
        </div>
    </form>
</div>

@endsection
