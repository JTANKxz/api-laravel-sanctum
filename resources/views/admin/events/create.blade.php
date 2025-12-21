@extends('layouts.admin')

@section('title', 'Criar Evento')

@section('content')

<div class="bg-medium-gray rounded-xl shadow-lg p-6 animate-fadeIn">
    <h2 class="text-xl font-bold mb-6">Criar Evento</h2>

    <x-alert />

    <form action="{{ route('admin.events.store') }}" method="POST">
        @csrf

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

            {{-- Título --}}
            <div>
                <label class="block text-gray-400 mb-2">Título do Evento</label>
                <input type="text"
                       name="title"
                       placeholder="Flamengo x Palmeiras"
                       value="{{ old('title') }}"
                       required
                       class="w-full bg-dark-gray border border-gray-700 rounded-lg py-2 px-4 text-white">
            </div>

            {{-- Subtítulo --}}
            <div>
                <label class="block text-gray-400 mb-2">Subtítulo</label>
                <input type="text"
                       name="subtitle"
                       placeholder="Brasileirão • Rodada 12"
                       value="{{ old('subtitle') }}"
                       class="w-full bg-dark-gray border border-gray-700 rounded-lg py-2 px-4 text-white">
            </div>

            {{-- Esporte --}}
            <div>
                <label class="block text-gray-400 mb-2">Esporte</label>
                <select name="sport"
                        class="w-full bg-dark-gray border border-gray-700 rounded-lg py-2 px-4 text-white">
                    <option value="football">Futebol</option>
                    <option value="basketball">Basquete</option>
                    <option value="ufc">UFC / MMA</option>
                    <option value="tennis">Tênis</option>
                    <option value="other">Outro</option>
                </select>
            </div>

            {{-- Status --}}
            <div>
                <label class="block text-gray-400 mb-2">Status</label>
                <select name="status"
                        class="w-full bg-dark-gray border border-gray-700 rounded-lg py-2 px-4 text-white">
                    <option value="scheduled">Agendado</option>
                    <option value="live">Ao Vivo</option>
                    <option value="finished">Encerrado</option>
                </select>
            </div>

            {{-- Time da Casa --}}
            <div>
                <label class="block text-gray-400 mb-2">Time da Casa</label>
                <input type="text"
                       name="home_team"
                       placeholder="Flamengo"
                       value="{{ old('home_team') }}"
                       class="w-full bg-dark-gray border border-gray-700 rounded-lg py-2 px-4 text-white">
            </div>

            {{-- Time Visitante --}}
            <div>
                <label class="block text-gray-400 mb-2">Time Visitante</label>
                <input type="text"
                       name="away_team"
                       placeholder="Palmeiras"
                       value="{{ old('away_team') }}"
                       class="w-full bg-dark-gray border border-gray-700 rounded-lg py-2 px-4 text-white">
            </div>

            {{-- Início --}}
            <div>
                <label class="block text-gray-400 mb-2">Data / Hora de Início</label>
                <input type="datetime-local"
                       name="start_time"
                       value="{{ old('start_time') }}"
                       required
                       class="w-full bg-dark-gray border border-gray-700 rounded-lg py-2 px-4 text-white">
            </div>

            {{-- Fim --}}
            <div>
                <label class="block text-gray-400 mb-2">Data / Hora de Término</label>
                <input type="datetime-local"
                       name="end_time"
                       value="{{ old('end_time') }}"
                       class="w-full bg-dark-gray border border-gray-700 rounded-lg py-2 px-4 text-white">
            </div>

            {{-- Thumbnail --}}
            <div class="md:col-span-2">
                <label class="block text-gray-400 mb-2">Thumbnail (URL)</label>
                <input type="text"
                       name="thumbnail_url"
                       placeholder="https://site.com/thumbs/event.jpg"
                       value="{{ old('thumbnail_url') }}"
                       class="w-full bg-dark-gray border border-gray-700 rounded-lg py-2 px-4 text-white">
            </div>

            {{-- Destaque --}}
            <div>
                <label class="block text-gray-400 mb-2">Evento em Destaque?</label>
                <select name="is_featured"
                        class="w-full bg-dark-gray border border-gray-700 rounded-lg py-2 px-4 text-white">
                    <option value="0">Não</option>
                    <option value="1">Sim</option>
                </select>
            </div>

        </div>

        {{-- Botões --}}
        <div class="mt-6 flex justify-end space-x-3">
            <a href="{{ route('admin.events.index') }}"
               class="bg-gray-700 hover:bg-gray-600 text-white py-2 px-6 rounded">
                Voltar
            </a>

            <button type="submit"
                    class="bg-netflix-red hover:bg-red-800 text-white py-2 px-6 rounded">
                Salvar Evento
            </button>
        </div>

    </form>
</div>

@endsection
