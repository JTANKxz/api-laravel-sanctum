@extends('layouts.public.grid')

@section('title', 'Pesquisa - ' . config('app.name'))

@section('content')
    <section class="grid-section">
        <div class="section-header">
            <h2 class="section-title">Resultados da busca por: "{{ $query }}"</h2>
        </div>
        @if ($results->isEmpty())
            <p>Nenhum resultado encontrado.</p>
        @else
            <div class="grid-container">
                @foreach ($results as $item)
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
        @endif
    </section>
@endsection
