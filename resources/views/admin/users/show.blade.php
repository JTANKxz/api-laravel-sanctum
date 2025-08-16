@extends('layouts.admin')

@section('title', 'User Details')

@section('content')

<div class="bg-medium-gray rounded-xl shadow-lg p-6 animate-fadeIn">
    <h2 class="text-xl font-bold mb-6">Detalhes do Usuário</h2>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

        {{-- Nome --}}
        <div>
            <label class="block text-gray-400 mb-2">Nome</label>
            <p class="bg-dark-gray border border-gray-700 rounded-lg py-2 px-4 text-white">
                {{ $user->name }}
            </p>
        </div>

        {{-- Email --}}
        <div>
            <label class="block text-gray-400 mb-2">Email</label>
            <p class="bg-dark-gray border border-gray-700 rounded-lg py-2 px-4 text-white">
                {{ $user->email }}
            </p>
        </div>

        {{-- Cargo --}}
        <div>
            <label class="block text-gray-400 mb-2">Cargo</label>
            <p class="bg-dark-gray border border-gray-700 rounded-lg py-2 px-4 text-white">
                {{ $user->is_admin ? 'Admin' : 'User' }}
            </p>
        </div>


        {{-- Criado em --}}
        <div>
            <label class="block text-gray-400 mb-2">Criado em</label>
            <p class="bg-dark-gray border border-gray-700 rounded-lg py-2 px-4 text-white">
                {{ $user->created_at->format('d/m/Y H:i') }}
            </p>
        </div>

        {{-- Atualizado em --}}
        <div>
            <label class="block text-gray-400 mb-2">Última atualização</label>
            <p class="bg-dark-gray border border-gray-700 rounded-lg py-2 px-4 text-white">
                {{ $user->updated_at->format('d/m/Y H:i') }}
            </p>
        </div>

    </div>

    {{-- Botão Voltar --}}
    <div class="mt-6 flex justify-end">
        <a href="{{ route('admin.users.index') }}"
            class="bg-gray-700 hover:bg-gray-600 text-white py-2 px-6 rounded">
            Voltar
        </a>
    </div>
</div>

@endsection