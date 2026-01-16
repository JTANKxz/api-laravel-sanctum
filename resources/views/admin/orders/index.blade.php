@extends('layouts.admin')

@section('title', 'Pedidos')

@section('content')
    <div class="mb-8">
        <h1 class="text-2xl font-bold mb-6">Listar Pedidos</h1>

        <x-alert />

        <div class="bg-medium-gray rounded-xl shadow-lg p-6 animate-fadeIn w-full">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-xl font-bold">Pedidos</h2>
            </div>

            <div class="overflow-x-auto">

                <table class="min-w-full">
                    <thead>
                        <tr class="border-b border-dark-gray">
                            <th class="py-3 px-4 text-left">ID</th>
                            <th class="py-3 px-4 text-left">Poster</th>
                            <th class="py-3 px-4 text-left">User ID</th>
                            <th class="py-3 px-4 text-left">User Plan</th>
                            <th class="py-3 px-4 text-left">Title</th>
                            <th class="py-3 px-4 text-left">Year</th>
                            <th class="py-3 px-4 text-left">Type</th>
                            <th class="py-3 px-4 text-left">Status</th>
                            <th class="py-3 px-4 text-left">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($orders as $order)
                            <tr class="border-b border-dark-gray hover:bg-dark-gray">
                                <td class="py-3 px-4 text-gray-400">{{ $order->id }}</td>

                                {{-- Poster separado --}}
                                <td class="py-3 px-4">
                                    <img src="{{ $order->poster_url ? $order->poster_url : 'https://ui-avatars.com/api/?name=' . urlencode($movie->title) . '&background=random' }}"
                                        alt="{{ $order->title }}" class="rounded w-12 h-16 object-cover">
                                </td>

                                <td class="py-3 px-4 text-gray-400">{{ $order->user->id }}</td>

                                <td class="py-3 px-4">
                                    @if ($order->user && $order->user->isPremium())
                                        <span class="px-2 py-1 text-xs font-semibold rounded bg-green-600 text-white">
                                            Premium
                                        </span>
                                    @else
                                        <span class="px-2 py-1 text-xs font-semibold rounded bg-gray-600 text-gray-200">
                                            Free
                                        </span>
                                    @endif
                                </td>

                                {{-- Título --}}
                                <td class="py-3 px-4 text-gray-200">{{ $order->title }}</td>

                                {{-- Ano --}}
                                <td class="py-3 px-4 text-gray-400">{{ $order->year }}</td>

                                <td class="py-3 px-4 text-gray-400">{{ $order->type }}</td>

                                <td class="py-3 px-4">
                                    @switch($order->status)
                                        @case('pending')
                                            <span class="px-2 py-1 text-xs rounded bg-gray-600 text-white">
                                                Pendente
                                            </span>
                                        @break

                                        @case('imported')
                                            <span class="px-2 py-1 text-xs rounded bg-green-600 text-white">
                                                Importado
                                            </span>
                                        @break

                                        @case('cancelled')
                                            <span class="px-2 py-1 text-xs rounded bg-yellow-600 text-white">
                                                Cancelado
                                            </span>
                                        @break

                                        @case('failed')
                                            <span class="px-2 py-1 text-xs rounded bg-red-600 text-white">
                                                Erro
                                            </span>
                                        @break
                                    @endswitch
                                </td>

                                {{-- Ações --}}
                                <td class="py-3 px-4 flex items-center space-x-2">

                                    {{-- IMPORTAR --}}
                                    @if ($order->isPending())
                                        <form action="{{ route('admin.orders.import', $order) }}" method="POST">
                                            @csrf
                                            <button
                                                class="px-3 py-1 text-xs bg-blue-600 hover:bg-blue-700 rounded text-white">
                                                Importar
                                            </button>
                                        </form>
                                    @endif

                                    {{-- CANCELAR --}}
                                    @if ($order->isPending())
                                        <form action="{{ route('admin.orders.cancel', $order) }}" method="POST">
                                            @csrf
                                            @method('PATCH')
                                            <button
                                                class="px-3 py-1 text-xs bg-yellow-600 hover:bg-yellow-700 rounded text-white">
                                                Cancelar
                                            </button>
                                        </form>
                                    @endif

                                    {{-- APAGAR --}}
                                    <form action="{{ route('admin.orders.destroy', $order) }}" method="POST"
                                        onsubmit="return confirm('Deseja apagar este pedido?')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="px-3 py-1 text-xs bg-red-600 hover:bg-red-700 rounded text-white">
                                            Apagar
                                        </button>
                                    </form>

                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            {{-- Links de paginaçãokk --}}
            <div class="mt-4">
                {{ $orders->links() }}
            </div>
        </div>
    </div>

@endsection
