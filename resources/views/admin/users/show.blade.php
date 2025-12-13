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

            {{-- Criado --}}
            <div>
                <label class="block text-gray-400 mb-2">Criado em</label>
                <p class="bg-dark-gray border border-gray-700 rounded-lg py-2 px-4 text-white">
                    {{ $user->created_at->format('d/m/Y H:i') }}
                </p>
            </div>

            {{-- Atualizado --}}
            <div>
                <label class="block text-gray-400 mb-2">Última atualização</label>
                <p class="bg-dark-gray border border-gray-700 rounded-lg py-2 px-4 text-white">
                    {{ $user->updated_at->format('d/m/Y H:i') }}
                </p>
            </div>


            {{-- Assinatura --}}
            <div class="md:col-span-2 mt-6">
                <h3 class="text-lg font-semibold text-white mb-4">Informações da Assinatura</h3>

                @if ($user->subscription && $user->subscription->plan)

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

                        {{-- Plano --}}
                        <div>
                            <label class="block text-gray-400 mb-2">Plano</label>
                            <p class="bg-dark-gray border border-gray-700 rounded-lg py-2 px-4 text-white">
                                {{ $user->subscription->plan->name }}
                            </p>
                        </div>

                        {{-- Preço --}}
                        <div>
                            <label class="block text-gray-400 mb-2">Preço</label>
                            <p class="bg-dark-gray border border-gray-700 rounded-lg py-2 px-4 text-white">
                                R$ {{ number_format($user->subscription->plan->price, 2, ',', '.') }}
                            </p>
                        </div>

                        {{-- Status --}}
                        <div>
                            <label class="block text-gray-400 mb-2">Status</label>

                            @php
                                $sub = $user->subscription;
                                $expired = $sub->expires_at && $sub->expires_at->isPast();
                            @endphp

                            <p class="bg-dark-gray border border-gray-700 rounded-lg py-2 px-4 text-white">
                                @if ($expired)
                                    <span class="text-red-500 font-semibold">Expirado</span>
                                @elseif ($sub->status === 'active')
                                    <span class="text-green-500 font-semibold">Ativo</span>
                                @else
                                    <span class="text-gray-400 font-semibold">{{ ucfirst($sub->status) }}</span>
                                @endif
                            </p>
                        </div>

                        {{-- Criado --}}
                        <div>
                            <label class="block text-gray-400 mb-2">Início da assinatura</label>
                            <p class="bg-dark-gray border border-gray-700 rounded-lg py-2 px-4 text-white">
                                {{ $sub->created_at->format('d/m/Y H:i') }}
                            </p>
                        </div>

                        {{-- Expiração --}}
                        <div>
                            <label class="block text-gray-400 mb-2">Expira em</label>
                            <p class="bg-dark-gray border border-gray-700 rounded-lg py-2 px-4 text-white">
                                {{ $sub->expires_at ? $sub->expires_at->format('d/m/Y H:i') : '—' }}
                            </p>
                        </div>

                    </div>
                @else
                    <p class="text-gray-400">Este usuário não possui assinatura.</p>
                @endif
            </div>

        </div>

        {{-- Botão Voltar --}}
        <div class="mt-6 flex justify-end">
            <a href="{{ route('admin.users.index') }}" class="bg-gray-700 hover:bg-gray-600 text-white py-2 px-6 rounded">
                Voltar
            </a>
        </div>
    </div>

@endsection
