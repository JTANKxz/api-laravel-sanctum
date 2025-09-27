@extends('layouts.public.movie')

@section('title', "Assistir {$movie->title} online - " . config('app.name'))

@section('content')
    <!-- Seção de Detalhes do Filme -->
    <section class="movie-detail-section">
        <!-- Backdrop do Filme -->
        <div class="movie-backdrop" id="movieBackdrop">
            <img src="{{ $movie->backdrop_url }}" alt="Backdrop de {{ $movie->title }}">
            <button class="backdrop-play-btn" id="backdropPlayBtn">
                <i class="fas fa-play"></i>
            </button>
        </div>

        <!-- Container do Player de Vídeo (inicialmente oculto) -->
        <div class="video-player-container" id="videoPlayerContainer">
            <div class="video-player" id="videoPlayer">
                <!-- O player será inserido aqui dinamicamente -->
            </div>
        </div>

        <!-- Botão para trocar player -->
        <button class="change-player-btn" id="changePlayerBtn" style="display: none;">
            <i class="fas fa-exchange-alt"></i> Trocar Player
        </button>

        <div class="movie-content">
            <div class="movie-info">
                <h1 class="movie-title">{{ $movie->title }}</h1>

                <div class="movie-meta">
                    <div class="movie-rating">
                        <i class="fa-solid fa-star"></i> {{ $movie->rating }}/10
                    </div>
                    <div class="movie-year">{{ $movie->year }}</div>
                    <div class="movie-runtime">{{ $movie->runtime }} min</div>
                </div>

                <div class="movie-actions">
                    <button class="watch-btn" id="watchBtn">
                        <i class="fa-solid fa-play"></i> Assistir
                    </button>
                    <button class="favorite-btn">
                        <i class="fa-regular fa-heart"></i> Favoritar
                    </button>
                </div>

                <p class="movie-overview">
                    {{ $movie->overview }}
                </p>

                {{-- <div class="movie-details">
                    <div class="detail-item">
                        <div class="detail-label">Diretor</div>
                        <div class="detail-value">Denis Villeneuve</div>
                    </div>
                    <div class="detail-item">
                        <div class="detail-label">Elenco Principal</div>
                        <div class="detail-value">Timothée Chalamet, Zendaya, Rebecca Ferguson</div>
                    </div>
                    <div class="detail-item">
                        <div class="detail-label">Produção</div>
                        <div class="detail-value">Legendary Entertainment</div>
                    </div>
                    <div class="detail-item">
                        <div class="detail-label">Classificação</div>
                        <div class="detail-value">14 anos</div>
                    </div>
                </div> --}}
            </div>
        </div>
    </section>

    <!-- Seção de Gêneros -->
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

<!-- Seção do Elenco -->
{{-- <section class="cast-section">
    <div class="section-header">
        <h2 class="section-title">Elenco Principal</h2>
        <a href="#" class="see-all-btn">Ver todo elenco <i class="fa-solid fa-arrow-right"></i></a>
    </div>
    <div class="cast-container">
        <div class="cast-card">
            <div class="cast-photo">
                <img src="https://image.tmdb.org/t/p/w185/z7Rl8u4vbVh6p1fAgd3VRJdydrZ.jpg" alt="Timothée Chalamet">
            </div>
            <div class="cast-name">Timothée Chalamet</div>
            <div class="cast-character">Paul Atreides</div>
        </div>
        <div class="cast-card">
            <div class="cast-photo">
                <img src="https://image.tmdb.org/t/p/w185/so5K8kZTX2j8tLnpOCTBseQ5bZU.jpg" alt="Zendaya">
            </div>
            <div class="cast-name">Zendaya</div>
            <div class="cast-character">Chani</div>
        </div>
        <div class="cast-card">
            <div class="cast-photo">
                <img src="https://image.tmdb.org/t/p/w185/9lhHYV6Z3ayjK2FgjTjTpSkf9tC.jpg" alt="Rebecca Ferguson">
            </div>
            <div class="cast-name">Rebecca Ferguson</div>
            <div class="cast-character">Lady Jessica</div>
        </div>
        <div class="cast-card">
            <div class="cast-photo">
                <img src="https://image.tmdb.org/t/p/w185/9uxTw6nB6aSYb0bKf6Fq4p8v8pV.jpg" alt="Josh Brolin">
            </div>
            <div class="cast-name">Josh Brolin</div>
            <div class="cast-character">Gurney Halleck</div>
        </div>
        <div class="cast-card">
            <div class="cast-photo">
                <img src="https://image.tmdb.org/t/p/w185/c9Vm9FZxkB6C9McNs4W5adTQm45.jpg" alt="Austin Butler">
            </div>
            <div class="cast-name">Austin Butler</div>
            <div class="cast-character">Feyd-Rautha</div>
        </div>
        <div class="cast-card">
            <div class="cast-photo">
                <img src="https://image.tmdb.org/t/p/w185/5YZ6bTq1fHAc2gSu67B9jR0qk3B.jpg" alt="Florence Pugh">
            </div>
            <div class="cast-name">Florence Pugh</div>
            <div class="cast-character">Princesa Irulan</div>
        </div>
    </div>
</section> --}}

<!-- Seção de Filmes Similares -->
<section class="similar-movies-section">
    <div class="section-header">
        <h2 class="section-title">Filmes Similares</h2>
    </div>
    <div class="movies-container">
        @foreach ($relatedMovies as $movie)
            <div class="movie-card">
                <img src="{{ $movie->poster_url }}" alt="{{ $movie->title }}">
                <div class="rating">{{ $movie->rating }}/10</div>
                <div class="card-info">
                    <div class="movie-title-card">{{ $movie->title }}</div>
                    <div class="release-year">{{ $movie->year }}</div>
                </div>
            </div>
        @endforeach
    </div>
</section>
@endsection
