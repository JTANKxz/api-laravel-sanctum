@extends('layouts.public.grid')

@section('title', 'Todos as series - ' . config('app.name'))

@section('content')
    <section class="grid-section">
        <div class="section-header">
            <h2 class="section-title">Todos as Séries</h2>
        </div>
        <div class="grid-container">
            @foreach ($series as $serie)
                <a href="{{ route('serie.show', ['slug' => $serie->slug]) }}">
                    <div class="content-card">
                        <img src="{{ $serie->poster_url }}" alt="Poster de {{ $serie->title }}">
                        <div class="rating">{{ $serie->rating }}/10</div>
                        <div class="card-info">
                            <div class="content-title" title="{{ $serie->title }}">{{ $serie->title }}</div>
                            <div class="release-year">{{ $serie->year }}</div>
                        </div>
                    </div>
                </a>
            @endforeach
        </div>

        <!-- Paginação Laravel -->
        @if ($series->hasPages())
            <div class="pagination">
                {{-- Link para a primeira página --}}
                @if (!$series->onFirstPage())
                    <li class="page-item">
                        <a class="page-link" href="{{ $series->url(1) }}" aria-label="Primeira">
                            <span aria-hidden="true">&laquo;&laquo;</span>
                        </a>
                    </li>
                    <li class="page-item">
                        <a class="page-link" href="{{ $series->previousPageUrl() }}" aria-label="Anterior">
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
                @foreach ($series->getUrlRange(max(1, $series->currentPage() - 2), min($series->lastPage(), $series->currentPage() + 2)) as $page => $url)
                    @if ($page == $series->currentPage())
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
                @if ($series->hasMorePages())
                    <li class="page-item">
                        <a class="page-link" href="{{ $series->nextPageUrl() }}" aria-label="Próxima">
                            <span aria-hidden="true">&raquo;</span>
                        </a>
                    </li>
                    <li class="page-item">
                        <a class="page-link" href="{{ $series->url($series->lastPage()) }}" aria-label="Última">
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
