@extends('layouts.admin')

@section('title', 'Editar Auto Embed')

@section('content')

<div class="bg-medium-gray rounded-xl shadow-lg p-6 animate-fadeIn">
    <h2 class="text-xl font-bold mb-6">Editar Auto Embed</h2>

    <x-alert />

    <form action="{{ route('admin.embeds.update', $embed->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

            {{-- Nome --}}
            <div>
                <label class="block text-gray-400 mb-2">Nome</label>
                <input type="text"
                    name="name"
                    value="{{ old('name', $embed->name) }}"
                    class="w-full bg-dark-gray border border-gray-700 rounded-lg py-2 px-4 text-white">
            </div>

            {{-- Qualidade --}}
            <div>
                <label class="block text-gray-400 mb-2">Qualidade</label>
                <input type="text"
                    name="quality"
                    value="{{ old('quality', $embed->quality) }}"
                    class="w-full bg-dark-gray border border-gray-700 rounded-lg py-2 px-4 text-white">
            </div>

            {{-- URL --}}
            <div class="md:col-span-2">
                <label class="block text-gray-400 mb-2">URL do Embed</label>
                <input type="text"
                    name="url"
                    value="{{ old('url', $embed->url) }}"
                    class="w-full bg-dark-gray border border-gray-700 rounded-lg py-2 px-4 text-white">
            </div>

            {{-- Tipo de ID --}}
            <div>
                <label class="block text-gray-400 mb-2">Tipo de ID</label>
                <select name="id_type"
                    class="w-full bg-dark-gray border border-gray-700 rounded-lg py-2 px-4 text-white">
                    <option value="tmdb" @selected($embed->id_type === 'tmdb')>TMDB</option>
                    <option value="imdb" @selected($embed->id_type === 'imdb')>IMDB</option>
                </select>
            </div>

            {{-- Tipo --}}
            <div>
                <label class="block text-gray-400 mb-2">Tipo</label>
                <select name="type"
                    class="w-full bg-dark-gray border border-gray-700 rounded-lg py-2 px-4 text-white">
                    <option value="embed" @selected($embed->type === 'embed')>Embed</option>
                    <option value="m3u8" @selected($embed->type === 'm3u8')>m3u8</option>
                    <option value="custom" @selected($embed->type === 'custom')>Custom</option>
                    <option value="mp4" @selected($embed->type === 'mp4')>Mp4</option>
                </select>
            </div>

            {{-- Player --}}
            <div>
                <label class="block text-gray-400 mb-2">Player</label>
                <select name="player_sub"
                    class="w-full bg-dark-gray border border-gray-700 rounded-lg py-2 px-4 text-white">
                    <option value="free" @selected($embed->player_sub === 'free')>Free</option>
                    <option value="premium" @selected($embed->player_sub === 'premium')>Premium</option>
                </select>
            </div>

            {{-- Tipo de Conteúdo --}}
            <div>
                <label class="block text-gray-400 mb-2">Tipo de Conteúdo</label>
                <select name="content_type"
                    class="w-full bg-dark-gray border border-gray-700 rounded-lg py-2 px-4 text-white">
                    <option value="movie" @selected($embed->content_type === 'movie')>Filme</option>
                    <option value="serie" @selected($embed->content_type === 'serie')>Série</option>
                    <option value="both" @selected($embed->content_type === 'both')>Filme e Série</option>
                </select>
            </div>

            {{-- Ordem --}}
            <div>
                <label class="block text-gray-400 mb-2">Ordem</label>
                <input type="number"
                    name="order"
                    value="{{ old('order', $embed->order) }}"
                    class="w-full bg-dark-gray border border-gray-700 rounded-lg py-2 px-4 text-white">
            </div>

            {{-- Status --}}
            <div>
                <label class="block text-gray-400 mb-2">Status</label>
                <select name="active"
                    class="w-full bg-dark-gray border border-gray-700 rounded-lg py-2 px-4 text-white">
                    <option value="1" @selected($embed->active)>Ativo</option>
                    <option value="0" @selected(!$embed->active)>Inativo</option>
                </select>
            </div>

        </div>

        {{-- Botões --}}
        <div class="mt-6 flex justify-end space-x-3">
            <a href="{{ route('admin.embeds.index') }}"
                class="bg-gray-700 hover:bg-gray-600 text-white py-2 px-6 rounded">
                Voltar
            </a>

            <button type="submit"
                class="bg-netflix-red hover:bg-red-800 text-white py-2 px-6 rounded">
                Atualizar
            </button>
        </div>

    </form>
</div>

@endsection
