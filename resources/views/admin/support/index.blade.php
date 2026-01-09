@extends('layouts.admin')

@section('title', 'Support Tickets')

@section('content')
<div class="mb-8">
    <h1 class="text-2xl font-bold mb-6">Support Tickets</h1>

    <x-alert />

    <div class="bg-medium-gray rounded-xl shadow-lg p-6 animate-fadeIn w-full">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-xl font-bold">Tickets</h2>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full">
                <thead>
                    <tr class="border-b border-dark-gray">
                        <th class="py-3 px-4 text-left">ID</th>
                        <th class="py-3 px-4 text-left">Usuário</th>
                        <th class="py-3 px-4 text-left">Categoria</th>
                        <th class="py-3 px-4 text-left">Problema</th>
                        <th class="py-3 px-4 text-left">Item</th>
                        <th class="py-3 px-4 text-left">Tipo</th>
                        <th class="py-3 px-4 text-left">Status</th>
                        <th class="py-3 px-4 text-left">Ações</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($tickets as $ticket)
                        <tr class="border-b border-dark-gray hover:bg-dark-gray">
                            <td class="py-3 px-4 text-gray-400">
                                {{ $ticket->id }}
                            </td>

                            <td class="py-3 px-4">
                                {{ $ticket->user->name ?? 'Usuário removido' }}
                            </td>

                            <td class="py-3 px-4 text-gray-300">
                                {{ $ticket->category }}
                            </td>

                            <td class="py-3 px-4 text-gray-400">
                                {{ $ticket->problem ?? '-' }}
                            </td>

                            <td class="py-3 px-4 text-gray-400">
                                {{ $ticket->item_name ?? '-' }}
                            </td>

                            <td class="py-3 px-4 text-gray-400">
                                {{ $ticket->item_type ?? '-' }}
                            </td>

                            {{-- STATUS --}}
                            <td class="py-3 px-4">
                                @php
                                    $colors = [
                                        'open' => 'bg-yellow-600',
                                        'progress' => 'bg-blue-600',
                                        'closed' => 'bg-green-600',
                                    ];
                                @endphp

                                <span
                                    class="px-3 py-1 text-xs rounded-full text-white {{ $colors[$ticket->status] ?? 'bg-gray-600' }}">
                                    {{ ucfirst($ticket->status) }}
                                </span>
                            </td>

                            {{-- AÇÕES --}}
                            <td class="py-3 px-4 flex items-center gap-2">

                                {{-- Em andamento --}}
                                @if ($ticket->status !== 'progress')
                                    <form action="{{ route('admin.support.status', $ticket->id) }}" method="POST">
                                        @csrf
                                        @method('PATCH')
                                        <input type="hidden" name="status" value="progress">
                                        <button
                                            class="px-3 py-1 text-xs bg-blue-600 hover:bg-blue-700 text-white rounded">
                                            Em andamento
                                        </button>
                                    </form>
                                @endif

                                {{-- Fechar --}}
                                @if ($ticket->status !== 'closed')
                                    <form action="{{ route('admin.support.status', $ticket->id) }}" method="POST">
                                        @csrf
                                        @method('PATCH')
                                        <input type="hidden" name="status" value="closed">
                                        <button
                                            class="px-3 py-1 text-xs bg-green-600 hover:bg-green-700 text-white rounded">
                                            Fechar
                                        </button>
                                    </form>
                                @endif

                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            {{ $tickets->links() }}
        </div>
    </div>
</div>
@endsection
