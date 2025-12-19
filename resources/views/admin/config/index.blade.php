@extends('layouts.admin')

@section('title', 'Configurações do App')

@section('content')

<div class="bg-medium-gray rounded-xl shadow-lg p-6 animate-fadeIn">
    <h2 class="text-xl font-bold mb-6">Configurações do Aplicativo</h2>

    <x-alert />

    <form action="{{ route('admin.config.update', $config->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

            {{-- Nome do App --}}
            <div>
                <label class="block text-gray-400 mb-2">Nome do App</label>
                <input type="text"
                    name="app_name"
                    value="{{ old('app_name', $config->app_name) }}"
                    class="w-full bg-dark-gray border border-gray-700 rounded-lg py-2 px-4 text-white">
            </div>

            {{-- Versão --}}
            <div>
                <label class="block text-gray-400 mb-2">Versão do App</label>
                <input type="text"
                    name="app_version"
                    value="{{ old('app_version', $config->app_version) }}"
                    class="w-full bg-dark-gray border border-gray-700 rounded-lg py-2 px-4 text-white">
            </div>

            {{-- Logo --}}
            <div>
                <label class="block text-gray-400 mb-2">Logo (URL)</label>
                <input type="text"
                    name="app_logo"
                    value="{{ old('app_logo', $config->app_logo) }}"
                    class="w-full bg-dark-gray border border-gray-700 rounded-lg py-2 px-4 text-white">
            </div>

            {{-- API Key --}}
            <div>
                <label class="block text-gray-400 mb-2">API Key</label>
                <input type="text"
                    name="api_key"
                    value="{{ old('api_key', $config->api_key) }}"
                    class="w-full bg-dark-gray border border-gray-700 rounded-lg py-2 px-4 text-white">
            </div>

            {{-- TMDB Key --}}
            <div>
                <label class="block text-gray-400 mb-2">TMDB Key</label>
                <input type="text"
                    name="tmdb_key"
                    value="{{ old('tmdb_key', $config->tmdb_key) }}"
                    class="w-full bg-dark-gray border border-gray-700 rounded-lg py-2 px-4 text-white">
            </div>

            {{-- Forçar atualização --}}
            <div>
                <label class="block text-gray-400 mb-2">Forçar Atualização</label>
                <select name="force_update"
                    class="w-full bg-dark-gray border border-gray-700 rounded-lg py-2 px-4 text-white">
                    <option value="0" {{ !$config->force_update ? 'selected' : '' }}>Não</option>
                    <option value="1" {{ $config->force_update ? 'selected' : '' }}>Sim</option>
                </select>
            </div>

            {{-- URL de atualização --}}
            <div>
                <label class="block text-gray-400 mb-2">URL de Atualização</label>
                <input type="text"
                    name="update_url"
                    value="{{ old('update_url', $config->update_url) }}"
                    class="w-full bg-dark-gray border border-gray-700 rounded-lg py-2 px-4 text-white">
            </div>

            {{-- Mensagem de atualização --}}
            <div>
                <label class="block text-gray-400 mb-2">Mensagem de Atualização</label>
                <input type="text"
                    name="update_message"
                    value="{{ old('update_message', $config->update_message) }}"
                    class="w-full bg-dark-gray border border-gray-700 rounded-lg py-2 px-4 text-white">
            </div>

            {{-- Mensagem personalizada --}}
            <div>
                <label class="block text-gray-400 mb-2">Ativar Mensagem Personalizada</label>
                <select name="enable_custom_message"
                    class="w-full bg-dark-gray border border-gray-700 rounded-lg py-2 px-4 text-white">
                    <option value="0" {{ !$config->enable_custom_message ? 'selected' : '' }}>Não</option>
                    <option value="1" {{ $config->enable_custom_message ? 'selected' : '' }}>Sim</option>
                </select>
            </div>

            {{-- Texto da mensagem --}}
            <div class="md:col-span-2">
                <label class="block text-gray-400 mb-2">Mensagem Personalizada</label>
                <textarea name="custom_message"
                    rows="3"
                    class="w-full bg-dark-gray border border-gray-700 rounded-lg py-2 px-4 text-white">{{ old('custom_message', $config->custom_message) }}</textarea>
            </div>

            {{-- Splash personalizado --}}
            <div class="md:col-span-2">
                <label class="block text-gray-400 mb-2">Enable Custom splash</label>
                <select name="enable_custom_splash"
                    class="w-full bg-dark-gray border border-gray-700 rounded-lg py-2 px-4 text-white">
                    <option value="0" {{ !$config->enable_custom_splash ? 'selected' : '' }}>Não</option>
                    <option value="1" {{ $config->enable_custom_splash ? 'selected' : '' }}>Sim</option>
                </select>
            </div>

            <div>
                <label class="block text-gray-400 mb-2">Logo (URL)</label>
                <input type="text"
                    name="app_logo"
                    value="{{ old('enable_custom_splash', $config->custom_splash_image) }}"
                    class="w-full bg-dark-gray border border-gray-700 rounded-lg py-2 px-4 text-white">
            </div>

        </div>

        {{-- Botões --}}
        <div class="mt-6 flex justify-end space-x-3">
            <button type="submit"
                class="bg-netflix-red hover:bg-red-800 text-white py-2 px-6 rounded">
                Salvar Configurações
            </button>
        </div>

    </form>
</div>

@endsection
