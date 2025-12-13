@extends('layouts.admin')

@section('title', 'Editar Código Premium')

@section('content')

<div class="bg-medium-gray rounded-xl shadow-lg p-6 animate-fadeIn">
    <h2 class="text-xl font-bold mb-6">Editar Código</h2>
    <x-alert />

    <form action="{{ route('admin.coupans.update', $coupan->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

            {{-- Código --}}
            <div>
                <label class="block text-gray-400 mb-2">Código</label>
                <input type="text"
                    name="code"
                    value="{{ $coupan->code }}"
                    class="w-full bg-dark-gray border border-gray-700 rounded-lg py-2 px-4 text-white">
            </div>

            {{-- Plano --}}
            <div>
                <label class="block text-gray-400 mb-2">Plano Associado</label>
                <select name="plan_id"
                    class="w-full bg-dark-gray border border-gray-700 rounded-lg py-2 px-4 text-white">

                    @foreach ($plans as $plan)
                        <option value="{{ $plan->id }}"
                            @if ($coupan->plan_id == $plan->id) selected @endif>
                            {{ $plan->name }}
                        </option>
                    @endforeach

                </select>
            </div>

            {{-- Máximo de usos --}}
            <div>
                <label class="block text-gray-400 mb-2">Máximo de usos</label>
                <input type="number"
                    name="max_uses"
                    value="{{ $coupan->max_uses }}"
                    class="w-full bg-dark-gray border border-gray-700 rounded-lg py-2 px-4 text-white">
            </div>

            {{-- Status --}}
            <div>
                <label class="block text-gray-400 mb-2">Status</label>
                <select name="status"
                    class="w-full bg-dark-gray border border-gray-700 rounded-lg py-2 px-4 text-white">

                    <option value="active" @selected($coupan->status === 'active')>Ativo</option>
                    <option value="inactive" @selected($coupan->status === 'inactive')>Inativo</option>

                </select>
            </div>

            {{-- Data de expiração --}}
            <div>
                <label class="block text-gray-400 mb-2">Expira em</label>
                <input type="datetime-local"
                    name="expires_at"
                    value="{{ $coupan->expires_at ? $coupan->expires_at->format('Y-m-d\TH:i') : '' }}"
                    class="w-full bg-dark-gray border border-gray-700 rounded-lg py-2 px-4 text-white">
            </div>

        </div>

        {{-- Botões --}}
        <div class="mt-6 flex justify-end space-x-3">
            <a href="{{ route('admin.coupans.index') }}"
               class="bg-gray-700 hover:bg-gray-600 text-white py-2 px-6 rounded">
                Cancelar
            </a>

            <button type="submit"
                class="bg-netflix-red hover:bg-red-800 text-white py-2 px-6 rounded">
                Atualizar
            </button>
        </div>
    </form>
</div>

@endsection
