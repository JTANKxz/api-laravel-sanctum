@extends('layouts.admin')

@section('title', 'Criar Canal')

@section('content')

<div class="bg-medium-gray rounded-xl shadow-lg p-6 animate-fadeIn">
    <h2 class="text-xl font-bold mb-6">Criar Novo Canal</h2>
    <x-alert />

    <form action="{{ route('admin.tv.store') }}" method="POST">
        @csrf

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

            {{-- Nome --}}
            <div>
                <label class="block text-gray-400 mb-2">Nome</label>
                <input type="text"
                    name="name"
                    value="{{ old('name') }}"
                    placeholder="Nome do Canal"
                    class="w-full bg-dark-gray border border-gray-700 rounded-lg py-2 px-4 text-white focus:outline-none focus:ring-2 focus:ring-netflix-red">
            </div>

            {{-- Slug --}}
            <div>
                <label class="block text-gray-400 mb-2">Slug</label>
                <input type="text"
                    name="slug"
                    value="{{ old('slug') }}"
                    placeholder="slug-do-canal"
                    class="w-full bg-dark-gray border border-gray-700 rounded-lg py-2 px-4 text-white focus:outline-none focus:ring-2 focus:ring-netflix-red">
            </div>

            {{-- Descrição --}}
            <div class="md:col-span-2">
                <label class="block text-gray-400 mb-2">Descrição</label>
                <textarea name="description"
                    placeholder="Descrição do canal"
                    class="w-full bg-dark-gray border border-gray-700 rounded-lg py-2 px-4 text-white focus:outline-none focus:ring-2 focus:ring-netflix-red"
                    rows="3">{{ old('description') }}</textarea>
            </div>

            {{-- Imagem --}}
            <div class="md:col-span-2">
                <label class="block text-gray-400 mb-2">URL da Imagem</label>
                <input type="text"
                    name="image_url"
                    value="{{ old('image_url') }}"
                    placeholder="https://example.com/imagem.jpg"
                    class="w-full bg-dark-gray border border-gray-700 rounded-lg py-2 px-4 text-white focus:outline-none focus:ring-2 focus:ring-netflix-red">
            </div>

        </div>

        {{-- Botões --}}
        <div class="mt-6 flex justify-end space-x-3">
            <a href="{{ route('admin.tv.index') }}" class="btn bg-gray-700 text-white py-2 px-4 rounded">
                Voltar
            </a>

            <button type="submit"
                class="bg-netflix-red hover:bg-red-800 text-white py-2 px-6 rounded">
                Criar
            </button>
        </div>
    </form>
</div>

@endsection
