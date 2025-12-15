@extends('layouts.admin')

@section('title', 'TV Channels')

@section('content')
<div class="mb-8">
    <h1 class="text-2xl font-bold mb-6">List TV Channels</h1>

    <x-alert />

    <div class="bg-medium-gray rounded-xl shadow-lg p-6 animate-fadeIn w-full">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-xl font-bold">TV Channels</h2>
            <a href="{{ route('admin.tv.create') }}"
                class="btn-hover bg-netflix-red hover:bg-red-800 text-white py-2 px-4 rounded-lg flex items-center">
                <i class="fas fa-plus mr-2"></i> Adicionar Novo
            </a>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full">
                <thead>
                    <tr class="border-b border-dark-gray">
                        <th class="py-3 px-4 text-left">ID</th>
                        <th class="py-3 px-4 text-left">Name</th>
                        <th class="py-3 px-4 text-left">Image</th>
                        <th class="py-3 px-4 text-left">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($channels as $channel)
                    <tr class="border-b border-dark-gray hover:bg-dark-gray">
                        <td class="py-3 px-4 text-gray-400">{{ $channel->id }}</td>
                        <td class="py-3 px-4 text-gray-200">{{ $channel->name }}</td>
                        <td class="py-3 px-4">
                            <img src="{{ $channel->image_url ? $channel->image_url : 'https://ui-avatars.com/api/?name=' . urlencode($channel->name) . '&background=random' }}"
                                alt="{{ $channel->name }}" class="rounded w-12 h-16 object-cover">
                        </td>

                        <td class="py-3 px-4 flex items-center space-x-2">
                            <a href="{{ route('admin.tv.links', $channel->id) }}" class="text-gray-400 hover:text-gray-300" title="Manage Links">
                                <i class="fas fa-link"></i>
                            </a>

                            <a href="{{ route('admin.tv.edit', $channel->id) }}" class="text-gray-400 hover:text-gray-300" title="Edit Channel">
                                <i class="fas fa-edit"></i>
                            </a>

                            <form action="{{ route('admin.tv.delete', $channel->id) }}" method="POST"
                                onsubmit="return confirm('Tem certeza que deseja excluir este canal?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-500 hover:text-red-400" title="Delete Channel">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{-- Links de paginação --}}
        <div class="mt-4">
            {{ $channels->links() }}
        </div>
    </div>
</div>
@endsection
