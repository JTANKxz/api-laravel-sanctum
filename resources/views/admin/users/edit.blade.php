@extends('layouts.admin')

@section('title', 'Editar Usuário')

@section('content')

    <div class="bg-medium-gray rounded-xl shadow-lg p-6 animate-fadeIn">
        <h2 class="text-xl font-bold mb-6">Editar Usuário</h2>

        <form action="{{ route('admin.users.update', $user->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                {{-- Nome --}}
                <div>
                    <label class="block text-gray-400 mb-2">Nome</label>
                    <input type="text" name="name" value="{{ old('name', $user->name) }}"
                        class="w-full bg-dark-gray border border-gray-700 rounded-lg py-2 px-4 text-white">
                </div>

                {{-- Email --}}
                <div>
                    <label class="block text-gray-400 mb-2">Email</label>
                    <input type="email" name="email" value="{{ old('email', $user->email) }}"
                        class="w-full bg-dark-gray border border-gray-700 rounded-lg py-2 px-4 text-white">
                </div>

                {{-- Cargo --}}
                <div>
                    <label class="block text-gray-400 mb-2">Cargo</label>
                    <select name="is_admin"
                        class="w-full bg-dark-gray border border-gray-700 rounded-lg py-2 px-4 text-white">
                        <option value="0" {{ $user->is_admin == 0 ? 'selected' : '' }}>User</option>
                        <option value="1" {{ $user->is_admin == 1 ? 'selected' : '' }}>Admin</option>
                    </select>
                </div>

                {{-- Plano de Assinatura --}}
                <div>
                    <label class="block text-gray-400 mb-2">Plano de Assinatura</label>
                    <select name="plan_id"
                        class="w-full bg-dark-gray border border-gray-700 rounded-lg py-2 px-4 text-white">

                        <option value="">Sem Plano</option>

                        @foreach ($plans as $plan)
                            <option value="{{ $plan->id }}"
                                {{ optional($user->subscription)->plan_id == $plan->id ? 'selected' : '' }}>
                                {{ $plan->name }} — {{ $plan->price }} R$
                            </option>
                        @endforeach

                    </select>
                </div>

            </div>

            {{-- Botões --}}
            <div class="mt-6 flex justify-end space-x-3">
                <a href="{{ route('admin.users.index') }}"
                    class="bg-gray-700 hover:bg-gray-600 text-white py-2 px-6 rounded">
                    Cancelar
                </a>

                <button type="submit" class="bg-netflix-red hover:bg-red-800 text-white py-2 px-6 rounded">
                    Salvar
                </button>
            </div>
        </form>
    </div>

@endsection
