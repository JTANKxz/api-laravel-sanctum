@extends('layouts.public.grid')

@section('title', 'Todos os filmes - ' . config('app.name'))

@section('content')
<section class="grid-section">
    <div class="section-header">
        <h2 class="section-title">Todos os Filmes</h2>
    </div>
    <div class="grid-container">
        @foreach ($movies as $movie)
            <a href="{{ route('movie.show', ['slug' => $movie->slug]) }}">
                <div class="content-card">
                    <img src="{{ $movie->poster_url }}" alt="Poster de {{ $movie->title }}">
                    <div class="rating">{{ $movie->rating }}/10</div>
                    <div class="card-info">
                        <div class="content-title" title="{{ $movie->title }}">{{ $movie->title }}</div>
                        <div class="release-year">{{ $movie->year }}</div>
                    </div>
                </div>
            </a>
        @endforeach
    </div>

    <!-- Paginação Laravel -->
    @if ($movies->hasPages())
        <div class="pagination">
            {{-- Link para a primeira página --}}
            @if (!$movies->onFirstPage())
                <li class="page-item">
                    <a class="page-link" href="{{ $movies->url(1) }}" aria-label="Primeira">
                        <span aria-hidden="true">&laquo;&laquo;</span>
                    </a>
                </li>
                <li class="page-item">
                    <a class="page-link" href="{{ $movies->previousPageUrl() }}" aria-label="Anterior">
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
            @foreach ($movies->getUrlRange(max(1, $movies->currentPage() - 2), min($movies->lastPage(), $movies->currentPage() + 2)) as $page => $url)
                @if ($page == $movies->currentPage())
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
            @if ($movies->hasMorePages())
                <li class="page-item">
                    <a class="page-link" href="{{ $movies->nextPageUrl() }}" aria-label="Próxima">
                        <span aria-hidden="true">&raquo;</span>
                    </a>
                </li>
                <li class="page-item">
                    <a class="page-link" href="{{ $movies->url($movies->lastPage()) }}" aria-label="Última">
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
        </div>
    @endif
</section>
@endsection
