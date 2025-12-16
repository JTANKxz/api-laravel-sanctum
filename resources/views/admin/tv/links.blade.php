@extends('layouts.admin')

@section('title', 'Links manager')

@section('content')
<div class="mb-8">
    <h1 class="text-2xl font-bold mb-6">List Links for {{ $channel->name }}</h1>

    <x-alert />

    <div class="bg-medium-gray rounded-xl shadow-lg p-6 animate-fadeIn w-full">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-xl font-bold">Links</h2>
            <a href="{{ route('admin.tv-links.create', $channel->id) }}"
                class="btn-hover bg-netflix-red hover:bg-red-800 text-white py-2 px-4 rounded-lg flex items-center">
                <i class="fas fa-plus mr-2"></i> Adicionar Novo
            </a>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full">
                <thead>
                    <tr class="border-b border-dark-gray">
                        <th class="py-3 px-4 text-left">Order</th>
                        <th class="py-3 px-4 text-left">Name</th>
                        <th class="py-3 px-4 text-left">Url</th>
                        <th class="py-3 px-4 text-left">Type</th>
                        <th class="py-3 px-4 text-left">Subscription</th>
                        <th class="py-3 px-4 text-left">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($links as $link)
                    <tr class="border-b border-dark-gray hover:bg-dark-gray">
                        <td class="py-3 px-4 text-gray-400">{{ $link->order }}</td>
                        <td class="py-3 px-4 text-gray-200">{{ $link->name }}</td>
                        <td class="py-3 px-4 text-gray-400">{{ $link->url }}</td>
                        <td class="py-3 px-4 text-gray-400">{{ $link->type }}</td>
                        <td class="py-3 px-4 text-gray-400">{{ $link->player_sub }}</td>

                        <td class="py-3 px-4 flex items-center space-x-2">
                            <a href="{{ route('admin.tv-links.edit', $link->id) }}" class="text-blue-400 hover:text-blue-300" title="Edit Link">
                                <i class="fas fa-edit"></i>
                            </a>

                            <form action="{{ route('admin.tv-links.destroy', $link->id) }}" method="POST"
                                onsubmit="return confirm('Tem certeza que deseja excluir este link?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-500 hover:text-red-400" title="Delete Link">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
