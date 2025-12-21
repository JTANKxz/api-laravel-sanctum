@extends('layouts.admin')

@section('title', 'Adicionar Transmissão')

@section('content')
<div class="bg-medium-gray rounded-xl shadow-lg p-6 animate-fadeIn">
    <h2 class="text-xl font-bold mb-6">
        Nova Transmissão — {{ $event->title }}
    </h2>

    <x-alert />

    <form action="{{ route('admin.events.links.store', $event->id) }}" method="POST">
        @csrf

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

            <div>
                <label class="block text-gray-400 mb-2">Nome</label>
                <input type="text"
                       name="name"
                       placeholder="Opção 1"
                       class="w-full bg-dark-gray border border-gray-700 rounded-lg py-2 px-4 text-white">
            </div>

            <div>
                <label class="block text-gray-400 mb-2">Tipo</label>
                <select name="type"
                        class="w-full bg-dark-gray border border-gray-700 rounded-lg py-2 px-4 text-white">
                    <option value="m3u8">M3U8</option>
                    <option value="mp4">MP4</option>
                    <option value="embed">Embed</option>
                    <option value="custom">Custom</option>
                </select>
            </div>

            <div class="md:col-span-2">
                <label class="block text-gray-400 mb-2">URL</label>
                <input type="text"
                       name="url"
                       placeholder="https://..."
                       required
                       class="w-full bg-dark-gray border border-gray-700 rounded-lg py-2 px-4 text-white">
            </div>

            <div>
                <label class="block text-gray-400 mb-2">Player</label>
                <select name="player_sub"
                        class="w-full bg-dark-gray border border-gray-700 rounded-lg py-2 px-4 text-white">
                    <option value="free">Free</option>
                    <option value="premium">Premium</option>
                </select>
            </div>

            <div>
                <label class="block text-gray-400 mb-2">Ordem</label>
                <input type="number"
                       name="order"
                       value="0"
                       class="w-full bg-dark-gray border border-gray-700 rounded-lg py-2 px-4 text-white">
            </div>

        </div>

        <div class="mt-6 flex justify-end space-x-3">
            <a href="{{ route('admin.events.links', $event->id) }}"
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
