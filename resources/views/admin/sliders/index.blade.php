@extends('layouts.admin')

@section('title', 'Sliders')

@section('content')
    <div class="mb-8">
        <h1 class="text-2xl font-bold mb-6">List Sliders</h1>

        <x-alert />

        <div class="bg-medium-gray rounded-xl shadow-lg p-6 animate-fadeIn w-full">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-xl font-bold">Sliders</h2>
                <a href="{{ route('admin.sliders.create') }}"
                    class="btn-hover bg-netflix-red hover:bg-red-800 text-white py-2 px-4 rounded-lg flex items-center">
                    <i class="fas fa-plus mr-2"></i> Adicionar Novo
                </a>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full">
                    <thead>
                        <tr class="border-b border-dark-gray">
                            <th class="py-3 px-4 text-left">ID</th>
                            <th class="py-3 px-4 text-left">Image</th>
                            <th class="py-3 px-4 text-left">Title</th>
                            <th class="py-3 px-4 text-left">Type</th>
                            <th class="py-3 px-4 text-left">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($sliders as $slider)
                            <tr class="border-b border-dark-gray hover:bg-dark-gray">
                                <td class="py-3 px-4 text-gray-400">{{ $slider->id }}</td>

                                {{-- Poster separado --}}
                                <td class="py-3 px-4">
                                    <img src="{{ $slider->backdrop_url ? $slider->backdrop_url : 'https://ui-avatars.com/api/?name=' . urlencode($slider->title) . '&background=random' }}"
                                        alt="{{ $slider->title }}" class="rounded w-12 h-16 object-cover">

                                </td>

                                {{-- Título --}}
                                <td class="py-3 px-4 text-gray-200">{{ $slider->title }}</td>

                                {{-- Tipo --}}
                                <td class="py-3 px-4 text-gray-400">{{ $slider->type }}</td>

                                {{-- Ações --}}
                                <td class="py-3 px-4 flex items-center space-x-2">

                                    <form action="{{ route('admin.sliders.delete', $slider->id) }}" method="POST"
                                        onsubmit="return confirm('Tem certeza que deseja excluir este filme?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-500 hover:text-red-400">
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
