@extends('layouts.admin')

@section('title', 'Series')

@section('content')
<div class="mb-8">
    <h1 class="text-2xl font-bold mb-6">List Series</h1>

    <x-alert />

    <div class="bg-medium-gray rounded-xl shadow-lg p-6 animate-fadeIn w-full">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-xl font-bold">Series</h2>
        </div>

        <div class="overflow-x-auto">

            {{-- 🔍 Busca --}}
            <div class="mb-4">
                <input
                    type="text"
                    id="serie-search"
                    placeholder="Buscar série por título..."
                    class="w-full px-4 py-2 rounded-lg bg-dark-gray text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-red-600"
                >
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
                <tbody id="series-tbody">
                    @foreach($series as $serie)
                    <tr class="border-b border-dark-gray hover:bg-dark-gray">
                        <td class="py-3 px-4 text-gray-400">{{ $serie->id }}</td>
                        <td class="py-3 px-4">
                            <img
                                src="{{ $serie->poster_url ?? 'https://ui-avatars.com/api/?name=' . urlencode($serie->title) }}"
                                class="rounded w-12 h-16 object-cover"
                            >
                        </td>
                        <td class="py-3 px-4 text-gray-200">{{ $serie->title }}</td>
                        <td class="py-3 px-4 text-gray-400">{{ $serie->year }}</td>
                        <td class="py-3 px-4 flex space-x-2">
                            <a href="{{ route('admin.series.seasons', $serie->id) }}" class="text-blue-400">
                                <i class="fas fa-list"></i>
                            </a>
                            <a href="{{ route('admin.series.edit', $serie->id) }}" class="text-gray-400">
                                <i class="fas fa-edit"></i>
                            </a>

                            <form action="{{ route('admin.series.delete', $serie->id) }}" method="POST"
                                onsubmit="return confirm('Tem certeza que deseja excluir esta série?');">
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

        <div class="mt-4">
            {{ $series->links() }}
        </div>
    </div>
</div>

{{-- 🔥 JS Busca em tempo real --}}
<script>
document.addEventListener('DOMContentLoaded', () => {
    let timeout = null;
    const input = document.getElementById('serie-search');
    const tbody = document.getElementById('series-tbody');

    input.addEventListener('keyup', function () {
        const q = this.value;

        clearTimeout(timeout);

        timeout = setTimeout(() => {
            fetch(`{{ route('admin.series.search') }}?q=${encodeURIComponent(q)}`)
                .then(res => res.json())
                .then(data => {
                    tbody.innerHTML = '';

                    if (!data.length) {
                        tbody.innerHTML = `
                            <tr>
                                <td colspan="5" class="text-center py-6 text-gray-400">
                                    Nenhuma série encontrada
                                </td>
                            </tr>
                        `;
                        return;
                    }

                    data.forEach(serie => {
                        tbody.innerHTML += `
                            <tr class="border-b border-dark-gray hover:bg-dark-gray">
                                <td class="py-3 px-4 text-gray-400">${serie.id}</td>
                                <td class="py-3 px-4">
                                    <img src="${serie.poster_url ?? `https://ui-avatars.com/api/?name=${encodeURIComponent(serie.title)}`}"
                                         class="rounded w-12 h-16 object-cover">
                                </td>
                                <td class="py-3 px-4 text-gray-200">${serie.title}</td>
                                <td class="py-3 px-4 text-gray-400">${serie.year ?? '-'}</td>
                                <td class="py-3 px-4 flex space-x-2">
                                    <a href="/dashboard/series/${serie.id}/seasons" class="text-blue-400">
                                        <i class="fas fa-list"></i>
                                    </a>
                                    <a href="/dashboard/series/${serie.id}/edit" class="text-gray-400">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                </td>
                            </tr>
                        `;
                    });
                });
        }, 300);
    });
});
</script>
@endsection
