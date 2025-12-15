@extends('layouts.admin')

@section('title', 'Editar link')

@section('content')

<div class="bg-medium-gray rounded-xl shadow-lg p-6 animate-fadeIn">
    <h2 class="text-xl font-bold mb-6">Editing Link for {{ $channel->name }}</h2>
    <x-alert />

    <form action="{{ route('admin.tv-links.update', $link->id) }}" method="POST">
        @csrf
        @method('PUT')

        <input type="hidden" name="tv_channel_id" value="{{ $channel->id }}">

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

            {{-- Nome --}}
            <div>
                <label class="block text-gray-400 mb-2">Nome</label>
                <input type="text"
                    name="name"
                    value="{{ old('name', $link->name) }}"
                    placeholder="SERVIDOR 1"
                    class="w-full bg-dark-gray border border-gray-700 rounded-lg py-2 px-4 text-white focus:outline-none focus:ring-2 focus:ring-netflix-red">
            </div>

            {{-- Url --}}
            <div>
                <label class="block text-gray-400 mb-2">Url</label>
                <input type="text"
                    name="url"
                    value="{{ old('url', $link->url) }}"
                    placeholder="https://watchtv.com/channel.mp4"
                    class="w-full bg-dark-gray border border-gray-700 rounded-lg py-2 px-4 text-white focus:outline-none focus:ring-2 focus:ring-netflix-red">
            </div>

            {{-- Quality --}}
            <div>
                <label class="block text-gray-400 mb-2">Quality</label>
                <input type="text"
                    name="quality"
                    value="{{ old('quality', $link->quality) }}"
                    placeholder="HD"
                    class="w-full bg-dark-gray border border-gray-700 rounded-lg py-2 px-4 text-white focus:outline-none focus:ring-2 focus:ring-netflix-red">
            </div>

            {{-- Order --}}
            <div>
                <label class="block text-gray-400 mb-2">Order</label>
                <input type="number"
                    name="order"
                    value="{{ old('order', $link->order) }}"
                    placeholder="1"
                    class="w-full bg-dark-gray border border-gray-700 rounded-lg py-2 px-4 text-white focus:outline-none focus:ring-2 focus:ring-netflix-red">
            </div>

            {{-- Player Sub --}}
            <div>
                <label class="block text-gray-400 mb-2">Player Sub</label>
                <select name="player_sub"
                    class="w-full bg-dark-gray border border-gray-700 rounded-lg py-2 px-4 text-white focus:outline-none focus:ring-2 focus:ring-netflix-red">
                    <option value="free" @selected($link->player_sub === 'free')>Free</option>
                    <option value="premium" @selected($link->player_sub === 'premium')>Premium</option>
                </select>
            </div>

            {{-- Type --}}
            <div>
                <label class="block text-gray-400 mb-2">Type</label>
                <select name="type"
                    class="w-full bg-dark-gray border border-gray-700 rounded-lg py-2 px-4 text-white focus:outline-none focus:ring-2 focus:ring-netflix-red">
                    @foreach (['mp4', 'mkv', 'm3u8', 'embed', 'custom'] as $option)
                        <option value="{{ $option }}" @selected($link->type === $option)>{{ strtoupper($option) }}</option>
                    @endforeach
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
