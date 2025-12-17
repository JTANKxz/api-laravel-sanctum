@extends('layouts.admin')

@section('title', 'Enviar Notificação')

@section('content')

<div class="bg-medium-gray rounded-xl shadow-lg p-6 animate-fadeIn">
    <h2 class="text-xl font-bold mb-6">Enviar Notificação</h2>

    <x-alert />

    <form action="{{ route('admin.notifications.send') }}" method="POST">
        @csrf

        <div class="grid grid-cols-1 gap-6">

            {{-- Título --}}
            <div>
                <label class="block text-gray-400 mb-2">Título</label>
                <input type="text"
                    name="title"
                    value="{{ old('title') }}"
                    placeholder="Ex: Atualização disponível"
                    class="w-full bg-dark-gray border border-gray-700 rounded-lg py-2 px-4 text-white"
                    required>
            </div>

            {{-- Mensagem --}}
            <div>
                <label class="block text-gray-400 mb-2">Mensagem</label>
                <textarea
                    name="body"
                    rows="4"
                    placeholder="Digite a mensagem da notificação"
                    class="w-full bg-dark-gray border border-gray-700 rounded-lg py-2 px-4 text-white"
                    >{{ old('body') }}</textarea>
            </div>

            {{-- Imagem --}}
            <div>
                <label class="block text-gray-400 mb-2">URL da Imagem (opcional)</label>
                <input type="url"
                    name="image"
                    value="{{ old('image') }}"
                    placeholder="https://exemplo.com/imagem.png"
                    class="w-full bg-dark-gray border border-gray-700 rounded-lg py-2 px-4 text-white">
            </div>

        </div>

        {{-- Botões --}}
        <div class="mt-6 flex justify-end space-x-3">
            <button type="submit"
                class="bg-netflix-red hover:bg-red-800 text-white py-2 px-6 rounded">
                Enviar Notificação
            </button>
        </div>

    </form>
</div>

@endsection
