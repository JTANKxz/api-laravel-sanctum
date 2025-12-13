@extends('layouts.admin')

@section('title', 'Criar Código Premium')

@section('content')

<div class="bg-medium-gray rounded-xl shadow-lg p-6 animate-fadeIn">
    <h2 class="text-xl font-bold mb-6">Criar Código Premium</h2>
    <x-alert />

    <form action="{{ route('admin.coupans.store') }}" method="POST">
        @csrf

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

            {{-- Código --}}
            <div>
                <label class="block text-gray-400 mb-2">Código</label>
                <input type="text" 
                    name="code" 
                    placeholder="ABC123XYZ"
                    class="w-full bg-dark-gray border border-gray-700 rounded-lg py-2 px-4 text-white">
            </div>

            {{-- Plano --}}
            <div>
                <label class="block text-gray-400 mb-2">Plano</label>
                <select name="plan_id"
                    class="w-full bg-dark-gray border border-gray-700 rounded-lg py-2 px-4 text-white">

                    <option value="">Selecione um plano</option>

                    @foreach ($plans as $plan)
                        <option value="{{ $plan->id }}">
                            {{ $plan->name }} — R${{ $plan->price }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Máximo de usos --}}
            <div>
                <label class="block text-gray-400 mb-2">Máximo de usos</label>
                <input type="number" 
                    name="max_uses" 
                    placeholder="10"
                    class="w-full bg-dark-gray border border-gray-700 rounded-lg py-2 px-4 text-white">
            </div>

            {{-- Status --}}
            <div>
                <label class="block text-gray-400 mb-2">Status</label>
                <select name="status"
                    class="w-full bg-dark-gray border border-gray-700 rounded-lg py-2 px-4 text-white">
                    <option value="active">Ativo</option>
                    <option value="inactive">Inativo</option>
                </select>
            </div>

            {{-- Data de Expiração --}}
            <div>
                <label class="block text-gray-400 mb-2">Expira em</label>
                <input type="date" 
                    name="expires_at"
                    class="w-full bg-dark-gray border border-gray-700 rounded-lg py-2 px-4 text-white">
            </div>

        </div>

        {{-- Botões --}}
        <div class="mt-6 flex justify-end space-x-3">
            <a href="{{ route('admin.coupans.index') }}" 
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
