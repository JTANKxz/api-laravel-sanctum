@extends('layouts.admin')

@section('title', 'Movies')

@section('content')
    <div class="mb-8">
        <h1 class="text-2xl font-bold mb-6">List Movies</h1>

        <x-alert />

        <div class="bg-medium-gray rounded-xl shadow-lg p-6 animate-fadeIn w-full">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-xl font-bold">Movies</h2>
                <a href="#"
                    class="btn-hover bg-netflix-red hover:bg-red-800 text-white py-2 px-4 rounded-lg flex items-center">
                    <i class="fas fa-plus mr-2"></i> Adicionar Novo
                </a>
            </div>

            <div class="overflow-x-auto">
                <div class="mb-4">
                    <input type="text" id="movie-search" placeholder="Buscar filme por título..."
                        class="w-full px-4 py-2 rounded-lg bg-dark-gray text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-red-600">
                </div>

                <table class="min-w-full">
                    <thead>
                        <tr class="border-b border-dark-gray">
                            <th class="py-3 px-4 text-left">ID</th>
                            <th class="py-3 px-4 text-left">Poster</th>
                            <th class="py-3 px-4 text-left">Title</th>
                            <th class="py-3 px-4 text-left">Year</th>
                            <th class="py-3 px-4 text-left">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($movies as $movie)
                            <tr class="border-b border-dark-gray hover:bg-dark-gray">
                                <td class="py-3 px-4 text-gray-400">{{ $movie->id }}</td>

                                {{-- Poster separado --}}
                                <td class="py-3 px-4">
                                    <img src="{{ $movie->poster_url ? $movie->poster_url : 'https://ui-avatars.com/api/?name=' . urlencode($movie->title) . '&background=random' }}"
                                        alt="{{ $movie->title }}" class="rounded w-12 h-16 object-cover">

                                </td>

                                {{-- Título --}}
                                <td class="py-3 px-4 text-gray-200">{{ $movie->title }}</td>

                                {{-- Ano --}}
                                <td class="py-3 px-4 text-gray-400">{{ $movie->year }}</td>

                                {{-- Ações --}}
                                <td class="py-3 px-4 flex items-center space-x-2">
                                    <!-- <a href="{{ route('admin.movies.show', $movie->id) }}" class="text-blue-400 hover:text-blue-300">
                                                <i class="fas fa-eye"></i>
                                            </a> -->

                                    <a href="{{ route('admin.movies.links', $movie->id) }}"
                                        class="text-gray-400 hover:text-gray-300">
                                        <i class="fas fa-link"></i>
                                    </a>

                                    <a href="{{ route('admin.movies.edit', $movie->id) }}"
                                        class="text-gray-400 hover:text-gray-300">
                                        <i class="fas fa-edit"></i>
                                    </a>

                                    <form action="{{ route('admin.movies.delete', $movie->id) }}" method="POST"
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

            {{-- Links de paginaçãokk --}}
            <div class="mt-4">
                {{ $movies->links() }}
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            let timeout = null;
            const input = document.getElementById('movie-search');

            if (!input) {
                console.error('Input movie-search não encontrado');
                return;
            }

            input.addEventListener('keyup', function() {
                const query = this.value;

                clearTimeout(timeout);

                timeout = setTimeout(() => {
                    fetch(`{{ route('admin.movies.search') }}?q=${encodeURIComponent(query)}`, {
                            headers: {
                                'X-Requested-With': 'XMLHttpRequest',
                                'Accept': 'application/json'
                            }
                        })

                        .then(res => res.json())
                        .then(data => {
                            const tbody = document.querySelector('tbody');
                            tbody.innerHTML = '';

                            if (data.length === 0) {
                                tbody.innerHTML = `
                                    <tr>
                                        <td colspan="5" class="text-center py-6 text-gray-400">
                                            Nenhum filme encontrado
                                        </td>
                                    </tr>
                                `;
                                return;
                            }

                            data.forEach(movie => {
                                tbody.innerHTML += `
                                    <tr class="border-b border-dark-gray hover:bg-dark-gray">
                                        <td class="py-3 px-4 text-gray-400">${movie.id}</td>
                                        <td class="py-3 px-4">
                                            <img src="${movie.poster_url ?? `https://ui-avatars.com/api/?name=${encodeURIComponent(movie.title)}`}"
                                                 class="rounded w-12 h-16 object-cover">
                                        </td>
                                        <td class="py-3 px-4 text-gray-200">${movie.title}</td>
                                        <td class="py-3 px-4 text-gray-400">${movie.year ?? '-'}</td>
                                        <td class="py-3 px-4 flex items-center space-x-2">
                                            <a href="/dashboard/movies/${movie.id}/links" class="text-gray-400 hover:text-gray-300">
                                                <i class="fas fa-link"></i>
                                            </a>
                                            <a href="/dashboard/movies/${movie.id}/edit" class="text-gray-400 hover:text-gray-300">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                        </td>
                                    </tr>
                                `;
                            });
                        })
                        .catch(err => console.error(err));
                }, 300);
            });
        });
    </script>


@endsection
