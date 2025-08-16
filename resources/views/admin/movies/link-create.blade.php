@extends('layouts.admin')

@section('title', 'Criar link')

@section('content')

<div class="bg-medium-gray rounded-xl shadow-lg p-6 animate-fadeIn">
    <h2 class="text-xl font-bold mb-6">Stream url for movie: {{ $movie->title }}</h2>
    <x-alert />

    <form action="{{ route('admin.links.store', $movie->id) }}" method="POST">
        @csrf
        @method('POST')

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <input type="hidden" name="movie_id" value="{{ $movie->id }}">

            {{-- Nome --}}
            <div>
                <label class="block text-gray-400 mb-2">Nome</label>
                <input type="text"
                    name="name"
                    placeholder="SERVIDOR 1"
                    class="w-full bg-dark-gray border border-gray-700 rounded-lg py-2 px-4 text-white focus:outline-none focus:ring-2 focus:ring-netflix-red">
            </div>
            <div>
                <label class="block text-gray-400 mb-2">Url</label>
                <input type="text"
                    name="url"
                    placeholder="https://wqatchmovie.com/movie.mp4"
                    class="w-full bg-dark-gray border border-gray-700 rounded-lg py-2 px-4 text-white focus:outline-none focus:ring-2 focus:ring-netflix-red">
            </div>
            <div>
                <label class="block text-gray-400 mb-2">Quality</label>
                <input type="text"
                    name="quality"
                    placeholder="HD"
                    class="w-full bg-dark-gray border border-gray-700 rounded-lg py-2 px-4 text-white focus:outline-none focus:ring-2 focus:ring-netflix-red">
            </div>
            <div>
                <label class="block text-gray-400 mb-2">Order</label>
                <input type="number"
                    name="order"
                    placeholder="1"
                    class="w-full bg-dark-gray border border-gray-700 rounded-lg py-2 px-4 text-white focus:outline-none focus:ring-2 focus:ring-netflix-red">
            </div>
            <div>
                <label class="block text-gray-400 mb-2">Type</label>
                <select name="player_sub"
                    class="w-full bg-dark-gray border border-gray-700 rounded-lg py-2 px-4 text-white focus:outline-none focus:ring-2 focus:ring-netflix-red">
                    <option value="free">Free</option>
                    <option value="premium">Premium</option>
                </select>
            </div>

            {{-- Type --}}
            <div>
                <label class="block text-gray-400 mb-2">Type</label>
                <select name="type"
                    class="w-full bg-dark-gray border border-gray-700 rounded-lg py-2 px-4 text-white focus:outline-none focus:ring-2 focus:ring-netflix-red">
                    <option value="embed">Embed</option>
                    <option value="m3u8">M3U8</option>
                    <option value="mp4" selected>MP4</option>
                    <option value="mkv">MKV</option>
                </select>
            </div>

        </div>

        {{-- Botões --}}
        <div class="mt-6 flex justify-end space-x-3">
            <a href="{{ url()->previous() }}" class="btn bg-netflix-red text-white py-2 px-4 rounded">
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