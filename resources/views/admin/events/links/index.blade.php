@extends('layouts.admin')

@section('title', 'Transmissões do Evento')

@section('content')
<div class="mb-8">
    <h1 class="text-2xl font-bold mb-6">
        Transmissões — {{ $event->title }}
    </h1>

    <x-alert />

    <div class="bg-medium-gray rounded-xl shadow-lg p-6 animate-fadeIn w-full">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-xl font-bold">Links do Evento</h2>

            <a href="{{ route('admin.events.links.create', $event->id) }}"
               class="btn-hover bg-netflix-red hover:bg-red-800 text-white py-2 px-4 rounded-lg flex items-center">
                <i class="fas fa-plus mr-2"></i> Adicionar Link
            </a>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full">
                <thead>
                    <tr class="border-b border-dark-gray">
                        <th class="py-3 px-4 text-left">Ordem</th>
                        <th class="py-3 px-4 text-left">Nome</th>
                        <th class="py-3 px-4 text-left">Tipo</th>
                        <th class="py-3 px-4 text-left">Player</th>
                        <th class="py-3 px-4 text-left">Ações</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($event->links as $link)
                        <tr class="border-b border-dark-gray hover:bg-dark-gray">
                            <td class="py-3 px-4 text-gray-400">
                                {{ $link->order }}
                            </td>

                            <td class="py-3 px-4 text-gray-200">
                                {{ $link->name }}
                            </td>

                            <td class="py-3 px-4 text-gray-300 uppercase">
                                {{ $link->type }}
                            </td>

                            <td class="py-3 px-4">
                                <span class="px-2 py-1 rounded text-xs
                                    {{ $link->player_sub === 'premium' ? 'bg-yellow-600 text-black' : 'bg-green-600 text-white' }}">
                                    {{ strtoupper($link->player_sub) }}
                                </span>
                            </td>

                            <td class="py-3 px-4 flex items-center space-x-3">
                                <a href="{{ route('admin.events.links.edit', [$event->id, $link->id]) }}"
                                   class="text-gray-400 hover:text-gray-300"
                                   title="Editar">
                                    <i class="fas fa-edit"></i>
                                </a>

                                <form action="{{ route('admin.events.links.destroy', [$event->id, $link->id]) }}"
                                      method="POST"
                                      onsubmit="return confirm('Deseja remover este link?');">
                                    @csrf
                                    @method('DELETE')

                                    <button type="submit"
                                            class="text-red-500 hover:text-red-400"
                                            title="Excluir">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="py-6 text-center text-gray-400">
                                Nenhuma transmissão cadastrada.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-6">
            <a href="{{ route('admin.events.index') }}"
               class="bg-gray-700 hover:bg-gray-600 text-white py-2 px-6 rounded">
                Voltar
            </a>
        </div>
    </div>
</div>
@endsection
