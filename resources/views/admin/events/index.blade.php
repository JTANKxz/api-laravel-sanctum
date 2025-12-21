@extends('layouts.admin')

@section('title', 'Eventos')

@section('content')
<div class="mb-8">
    <h1 class="text-2xl font-bold mb-6">Listagem de Eventos</h1>

    <x-alert />

    <div class="bg-medium-gray rounded-xl shadow-lg p-6 animate-fadeIn w-full">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-xl font-bold">Eventos</h2>

            <a href="{{ route('admin.events.create') }}"
               class="btn-hover bg-netflix-red hover:bg-red-800 text-white py-2 px-4 rounded-lg flex items-center">
                <i class="fas fa-plus mr-2"></i> Adicionar Evento
            </a>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full">
                <thead>
                    <tr class="border-b border-dark-gray">
                        <th class="py-3 px-4 text-left">ID</th>
                        <th class="py-3 px-4 text-left">Evento</th>
                        <th class="py-3 px-4 text-left">Esporte</th>
                        <th class="py-3 px-4 text-left">Status</th>
                        <th class="py-3 px-4 text-left">Início</th>
                        <th class="py-3 px-4 text-left">Imagem</th>
                        <th class="py-3 px-4 text-left">Ações</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($events as $event)
                        <tr class="border-b border-dark-gray hover:bg-dark-gray">
                            <td class="py-3 px-4 text-gray-400">
                                {{ $event->id }}
                            </td>

                            <td class="py-3 px-4 text-gray-200">
                                <div class="font-semibold">{{ $event->title }}</div>
                                @if($event->subtitle)
                                    <div class="text-sm text-gray-400">
                                        {{ $event->subtitle }}
                                    </div>
                                @endif
                            </td>

                            <td class="py-3 px-4 text-gray-300">
                                {{ ucfirst($event->sport) }}
                            </td>

                            <td class="py-3 px-4">
                                @if($event->status === 'live')
                                    <span class="px-2 py-1 text-xs rounded bg-red-600 text-white">
                                        AO VIVO
                                    </span>
                                @elseif($event->status === 'scheduled')
                                    <span class="px-2 py-1 text-xs rounded bg-yellow-500 text-black">
                                        AGENDADO
                                    </span>
                                @else
                                    <span class="px-2 py-1 text-xs rounded bg-gray-600 text-white">
                                        ENCERRADO
                                    </span>
                                @endif
                            </td>

                            <td class="py-3 px-4 text-gray-300">
                                {{ \Carbon\Carbon::parse($event->start_time)->format('d/m/Y H:i') }}
                            </td>

                            <td class="py-3 px-4">
                                <img
                                    src="{{ $event->thumbnail_url ?: 'https://ui-avatars.com/api/?name=' . urlencode($event->title) . '&background=random' }}"
                                    alt="{{ $event->title }}"
                                    class="rounded w-20 h-12 object-cover"
                                >
                            </td>

                            <td class="py-3 px-4 flex items-center space-x-3">
                                {{-- Links do evento --}}
                                <a href="{{ route('admin.events.links', $event->id) }}"
                                   class="text-gray-400 hover:text-gray-300"
                                   title="Gerenciar transmissões">
                                    <i class="fas fa-link"></i>
                                </a>

                                {{-- Editar --}}
                                <a href="{{ route('admin.events.edit', $event->id) }}"
                                   class="text-gray-400 hover:text-gray-300"
                                   title="Editar evento">
                                    <i class="fas fa-edit"></i>
                                </a>

                                {{-- Excluir --}}
                                <form action="{{ route('admin.events.destroy', $event->id) }}"
                                      method="POST"
                                      onsubmit="return confirm('Tem certeza que deseja excluir este evento?');">
                                    @csrf
                                    @method('DELETE')

                                    <button type="submit"
                                            class="text-red-500 hover:text-red-400"
                                            title="Excluir evento">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="py-6 text-center text-gray-400">
                                Nenhum evento cadastrado.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
