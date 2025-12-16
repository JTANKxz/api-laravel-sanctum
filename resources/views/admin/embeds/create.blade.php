@extends('layouts.admin')

@section('title', 'Criar Auto Embed')

@section('content')

<div class="bg-medium-gray rounded-xl shadow-lg p-6 animate-fadeIn">
    <h2 class="text-xl font-bold mb-6">Criar Auto Embed</h2>

    <x-alert />

    <form action="{{ route('admin.embeds.store') }}" method="POST">
        @csrf

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

            {{-- Nome --}}
            <div>
                <label class="block text-gray-400 mb-2">Nome</label>
                <input type="text"
                    name="name"
                    placeholder="ALTERNATIVO"
                    value="{{ old('name') }}"
                    class="w-full bg-dark-gray border border-gray-700 rounded-lg py-2 px-4 text-white">
            </div>

            {{-- Qualidade --}}
            <div>
                <label class="block text-gray-400 mb-2">Qualidade</label>
                <input type="text"
                    name="quality"
                    placeholder="HD / Auto"
                    value="{{ old('quality') }}"
                    class="w-full bg-dark-gray border border-gray-700 rounded-lg py-2 px-4 text-white">
            </div>

            {{-- URL --}}
            <div class="md:col-span-2">
                <label class="block text-gray-400 mb-2">URL do Embed</label>
                <input type="text"
                    name="url"
                    placeholder="https://site.com/embed/{tmdb_id}/{season}/{ep}"
                    value="{{ old('url') }}"
                    class="w-full bg-dark-gray border border-gray-700 rounded-lg py-2 px-4 text-white">
            </div>

            {{-- Tipo de ID --}}
            <div>
                <label class="block text-gray-400 mb-2">Tipo de ID</label>
                <select name="id_type"
                    class="w-full bg-dark-gray border border-gray-700 rounded-lg py-2 px-4 text-white">
                    <option value="tmdb">TMDB</option>
                </select>
            </div>

            {{-- Tipo --}}
            <div>
                <label class="block text-gray-400 mb-2">Tipo</label>
                <select name="type"
                    class="w-full bg-dark-gray border border-gray-700 rounded-lg py-2 px-4 text-white">
                    <option value="embed">Embed</option>
                </select>
            </div>

            {{-- Player --}}
            <div>
                <label class="block text-gray-400 mb-2">Player</label>
                <select name="player_sub"
                    class="w-full bg-dark-gray border border-gray-700 rounded-lg py-2 px-4 text-white">
                    <option value="free">Free</option>
                    <option value="premium">Premium</option>
                </select>
            </div>

            {{-- Tipo de Conteúdo --}}
            <div>
                <label class="block text-gray-400 mb-2">Tipo de Conteúdo</label>
                <select name="content_type"
                    class="w-full bg-dark-gray border border-gray-700 rounded-lg py-2 px-4 text-white">
                    <option value="movie">Filme</option>
                    <option value="serie">Série</option>
                </select>
            </div>

            {{-- Ordem --}}
            <div>
                <label class="block text-gray-400 mb-2">Ordem</label>
                <input type="number"
                    name="order"
                    placeholder="0"
                    value="{{ old('order', 0) }}"
                    class="w-full bg-dark-gray border border-gray-700 rounded-lg py-2 px-4 text-white">
            </div>

            {{-- Status --}}
            <div>
                <label class="block text-gray-400 mb-2">Status</label>
                <select name="active"
                    class="w-full bg-dark-gray border border-gray-700 rounded-lg py-2 px-4 text-white">
                    <option value="1">Ativo</option>
                    <option value="0">Inativo</option>
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
                Salvar
            </button>
        </div>

    </form>
</div>

@endsection
