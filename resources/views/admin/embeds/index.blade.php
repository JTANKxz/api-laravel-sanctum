@extends('layouts.admin')

@section('title', 'Auto Embeds')

@section('content')
    <div class="mb-8">
        <h1 class="text-2xl font-bold mb-6">Auto Embeds</h1>

        <x-alert />

        <div class="bg-medium-gray rounded-xl shadow-lg p-6 animate-fadeIn w-full">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-xl font-bold">Lista de Embeds</h2>

                <a href="{{ route('admin.embeds.create') }}"
                    class="btn-hover bg-netflix-red hover:bg-red-800 text-white py-2 px-4 rounded-lg flex items-center">
                    <i class="fas fa-plus mr-2"></i> Adicionar Novo
                </a>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full">
                    <thead>
                        <tr class="border-b border-dark-gray">
                            <th class="py-3 px-4 text-left">ID</th>
                            <th class="py-3 px-4 text-left">Nome</th>
                            <th class="py-3 px-4 text-left">Tipo</th>
                            <th class="py-3 px-4 text-left">Conteúdo</th>
                            <th class="py-3 px-4 text-left">Qualidade</th>
                            <th class="py-3 px-4 text-left">Status</th>
                            <th class="py-3 px-4 text-left">Ordem</th>
                            <th class="py-3 px-4 text-left">Ações</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse ($embeds as $embed)
                            <tr class="border-b border-dark-gray hover:bg-dark-gray">
                                <td class="py-3 px-4 text-gray-400">{{ $embed->id }}</td>

                                <td class="py-3 px-4 font-semibold">
                                    {{ $embed->name }}
                                </td>

                                <td class="py-3 px-4 text-gray-400">
                                    {{ strtoupper($embed->type) }}
                                </td>

                                <td class="py-3 px-4 text-gray-400">
                                    {{ ucfirst($embed->content_type) }}
                                </td>

                                <td class="py-3 px-4 text-gray-400">
                                    {{ $embed->quality }}
                                </td>

                                <td class="py-3 px-4">
                                    @if ($embed->active)
                                        <span class="text-green-400 font-semibold">Ativo</span>
                                    @else
                                        <span class="text-red-400 font-semibold">Inativo</span>
                                    @endif
                                </td>

                                <td class="py-3 px-4 text-gray-400">
                                    {{ $embed->order ?? '-' }}
                                </td>

                                <td class="py-3 px-4 flex space-x-3">

                                    {{-- Editar --}}
                                    <a href="{{ route('admin.embeds.edit', $embed->id) }}"
                                        class="text-gray-400 hover:text-gray-300">
                                        <i class="fas fa-edit"></i>
                                    </a>

                                    {{-- Deletar --}}
                                    <form action="{{ route('admin.embeds.destroy', $embed->id) }}"
                                        method="POST"
                                        onsubmit="return confirm('Deseja realmente excluir este embed?');">
                                        @csrf
                                        @method('DELETE')

                                        <button type="submit"
                                            class="text-red-500 hover:text-red-400">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>

                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8"
                                    class="py-6 text-center text-gray-400">
                                    Nenhum embed cadastrado.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
