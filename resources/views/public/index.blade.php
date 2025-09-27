@extends('layouts.public.home')

@section('content')

    <section class="slides-section">
        <div class="slides-container">
            <div class="slides-wrapper">
                @foreach ($sliders as $slider)
                    @php
                        $route =
                            $slider->type === 'movie'
                                ? route('movie.show', $slider->slug)
                                : route('serie.show', $slider->slug);
                        $tipoTexto = $slider->type === 'movie' ? 'Filme' : 'Série';
                    @endphp
                    <div class="slide">
                        <img src="{{ $slider->backdrop_url }}" alt="{{ $slider->title }}">
                        <div class="slide-info">
                            <div class="slide-title">{{ $slider->title }}</div>
                            <div class="slide-meta">
                                <span class="slide-rating"><i class="fa-solid fa-star"></i> 8.3</span>
                                <span class="slide-year">{{ $slider->year }}</span>
                                <span class="slide-type">{{ $tipoTexto }}</span>
                            </div>
                            {{-- <div class="slide-description">Paul Atreides se une a Chani e aos Fremen enquanto busca
                                    vingança contra os conspiradores que destruíram sua família.</div> --}}
                            <a href="{{ $route }}" class="slide-button">Assistir Agora</a>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="progressBar"></div>
        </div>
        <div class="indicators"></div>
    </section>

    <section class="genres-section">
        <div class="section-header">
            <h2 class="section-title">Gêneros</h2>
        </div>
        <div class="genres-container">
            @foreach ($genres as $genre)
                <a href="{{ route('genres.show', ['slug' => $genre->slug]) }}" class="genre-card">{{ $genre->name }}</a>
            @endforeach
        </div>
    </section>

    @foreach ($sections as $section)
        @if ($section->active)
            <section class="movies-section">
                <div class="section-header">
                    <h2 class="section-title">{{ $section->name }}</h2>
                    {{-- <a href="#" class="see-all-btn">Ver tudo <i class="fa-solid fa-arrow-right"></i></a> --}}
                </div>

                <div class="movies-container">
                    @foreach ($section->items as $item)
                        @php $content = $item->content; @endphp

                        @if ($content)
                            @php
                                // Escolhe a rota conforme o tipo
                                $route =
                                    $content->content_type === 'movie'
                                        ? route('movie.show', ['slug' => $content->slug])
                                        : route('serie.show', ['slug' => $content->slug]);
                            @endphp

                            <a href="{{ $route }}">
                                <div class="movie-card">
                                    <img src="{{ $content->poster_url }}" alt="Poster do {{ $content->type }}">
                                    <div class="rating">{{ $content->rating }}/10</div>
                                    <div class="card-info">
                                        <div class="movie-title" title="{{ $content->title }}">
                                            {{ $content->title }}</div>
                                        <div class="release-year">{{ $content->year }}</div>
                                    </div>
                                </div>
                            </a>
                        @endif
                    @endforeach
                </div>
            </section>
        @endif
    @endforeach


    <section class="movies-section">
        <div class="section-header">
            <h2 class="section-title">Filmes</h2>
            <a href="{{ route('movie.index') }}" class="see-all-btn">Ver tudo <i class="fa-solid fa-arrow-right"></i></a>
        </div>
        <div class="movies-container">
            @foreach ($movies as $movie)
                <a href="{{ route('movie.show', ['slug' => $movie->slug]) }}">

                    <div class="movie-card">
                        <img src="{{ $movie->poster_url }}" alt="Poster do filme">
                        <div class="rating">{{ $movie->rating }}/10</div>
                        <div class="card-info">
                            <div class="movie-title" title="{{ $movie->title }}">{{ $movie->title }}</div>
                            <div class="release-year">{{ $movie->year }}</div>
                        </div>
                    </div>
                </a>
            @endforeach
        </div>
    </section>

    <section class="series-section">
        <div class="section-header">
            <h2 class="section-title">Séries</h2>
            <a href="{{ route('serie.index') }}" class="see-all-btn">Ver tudo <i class="fa-solid fa-arrow-right"></i></a>
        </div>
        <div class="series-container">
            @foreach ($series as $serie)
                <a href="{{ route('serie.show', ['slug' => $serie->slug]) }}">
                    <div class="series-card">
                        <img src="{{ $serie->poster_url }}" alt="Poster da série">
                        <div class="rating">{{ $serie->rating }}/10</div>
                        <div class="card-info">
                            <div class="series-title" title="{{ $serie->title }}">{{ $serie->title }}</div>
                            <div class="release-year">{{ $serie->year }}</div>
                        </div>
                    </div>
                </a>
            @endforeach
        </div>
    </section>

@endsection
