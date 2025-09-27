@extends('layouts.public.grid')

@section('title', "Categoria {$genre->name} - " . config('app.name'))

@section('content')
    <section class="grid-section">
        <div class="section-header">
            <h2 class="section-title">Categoria: {{ $genre->name }}</h2>
        </div>
        <div class="grid-container">
            @foreach ($paginated as $item)
                @php
                    // Escolhe a rota conforme o tipo
                    $route =
                        $item->content_type === 'movie'
                            ? route('movie.show', ['slug' => $item->slug])
                            : route('serie.show', ['slug' => $item->slug]);
                @endphp
                <a href="{{ $route }}">
                    <div class="content-card">
                        <img src="{{ $item->poster_url }}" alt="Poster de {{ $item->title }}">
                        <div class="rating">{{ $item->rating }}/10</div>
                        <div class="card-info">
                            <div class="content-title" title="{{ $item->title }}">{{ $item->title }}</div>
                            <div class="release-year">{{ $item->year }}</div>
                        </div>
                    </div>
                </a>
            @endforeach
        </div>

        <!-- Paginação Laravel -->
        <!-- Paginação Laravel -->
        @if ($paginated->hasPages())
            <ul class="pagination">
                {{-- Link para a primeira página --}}
                @if (!$paginated->onFirstPage())
                    <li class="page-item">
                        <a class="page-link" href="{{ $paginated->url(1) }}" aria-label="Primeira">
                            <span aria-hidden="true">&laquo;&laquo;</span>
                        </a>
                    </li>
                    <li class="page-item">
                        <a class="page-link" href="{{ $paginated->previousPageUrl() }}" aria-label="Anterior">
                            <span aria-hidden="true">&laquo;</span>
                        </a>
                    </li>
                @else
                    <li class="page-item disabled">
                        <span class="page-link">&laquo;&laquo;</span>
                    </li>
                    <li class="page-item disabled">
                        <span class="page-link">&laquo;</span>
                    </li>
                @endif

                {{-- Links das páginas --}}
                @foreach ($paginated->getUrlRange(max(1, $paginated->currentPage() - 2), min($paginated->lastPage(), $paginated->currentPage() + 2)) as $page => $url)
                    @if ($page == $paginated->currentPage())
                        <li class="page-item active" aria-current="page">
                            <span class="page-link">{{ $page }}</span>
                        </li>
                    @else
                        <li class="page-item">
                            <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                        </li>
                    @endif
                @endforeach

                {{-- Link para a próxima página --}}
                @if ($paginated->hasMorePages())
                    <li class="page-item">
                        <a class="page-link" href="{{ $paginated->nextPageUrl() }}" aria-label="Próxima">
                            <span aria-hidden="true">&raquo;</span>
                        </a>
                    </li>
                    <li class="page-item">
                        <a class="page-link" href="{{ $paginated->url($paginated->lastPage()) }}" aria-label="Última">
                            <span aria-hidden="true">&raquo;&raquo;</span>
                        </a>
                    </li>
                @else
                    <li class="page-item disabled">
                        <span class="page-link">&raquo;</span>
                    </li>
                    <li class="page-item disabled">
                        <span class="page-link">&raquo;&raquo;</span>
                    </li>
                @endif
            </ul>
        @endif
    </section>
@endsection
