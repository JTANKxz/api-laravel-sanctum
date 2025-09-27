@extends('layouts.public.serie')

@section('title', "Assistir {$serie->title} online - " . config('app.name'))

@section('content')
    <!-- Seção de Detalhes da Série -->
    <section class="serie-detail-section">
        <!-- Backdrop da Série -->
        <div class="serie-backdrop" id="serieBackdrop">
            <img src="{{ $serie->backdrop_url }}" alt="Backdrop de {{ $serie->title }}">
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

        <!-- Controles do Player -->
        <div class="player-controls" id="playerControls">
            <button class="episode-nav-btn" id="prevEpisodeBtn" disabled>
                <i class="fas fa-chevron-left"></i> Ant.
            </button>
            <button class="change-player-btn" id="changePlayerBtn">
                <i class="fas fa-exchange-alt"></i> Mudar
            </button>
            <button class="episode-nav-btn" id="nextEpisodeBtn">
                Próx. <i class="fas fa-chevron-right"></i>
            </button>
        </div>

        <div class="serie-content">
            <div class="serie-info">
                <h1 class="serie-title">{{ $serie->title }}</h1>

                <div class="serie-meta">
                    <div class="serie-rating">
                        <i class="fa-solid fa-star"></i> {{ $serie->rating }}/10
                    </div>
                    <div class="serie-year">{{ $serie->year }}</div>
                    <div class="serie-seasons">{{ count($serie->seasons) }} Temporadas</div>
                </div>

                <div class="serie-actions">
                    <button class="watch-btn" id="watchBtn">
                        <i class="fa-solid fa-play"></i> Assistir
                    </button>
                    <button class="favorite-btn">
                        <i class="fa-regular fa-heart"></i> Favoritar
                    </button>
                </div>

                <p class="serie-overview">
                    {{ $serie->overview }}
                </p>

                {{-- <div class="serie-details">
                            <div class="detail-item">
                                <div class="detail-label">Criadores</div>
                                <div class="detail-value">{{ $serie->creators }}</div>
                            </div>
                            <div class="detail-item">
                                <div class="detail-label">Elenco Principal</div>
                                <div class="detail-value">{{ $serie->cast }}</div>
                            </div>
                            <div class="detail-item">
                                <div class="detail-label">Produção</div>
                                <div class="detail-value">{{ $serie->production }}</div>
                            </div>
                            <div class="detail-item">
                                <div class="detail-label">Classificação</div>
                                <div class="detail-value">{{ $serie->classification }}</div>
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

    <!-- Seção de Temporadas -->
    <section class="seasons-section">
        <div class="section-header">
            <h2 class="section-title">Temporadas</h2>
        </div>

        @foreach ($seasons as $season)
            <div class="season-accordion">
                <div class="season-header {{ $loop->first ? 'active' : '' }}" data-season="{{ $season->season_number }}">
                    <div class="season-title">
                        <i class="fas fa-chevron-down season-icon"></i>
                        Temporada {{ $season->season_number }}
                    </div>
                    <div class="season-episode-count">{{ count($season->episodes) }} Episódios</div>
                </div>
                <div class="season-content {{ $loop->first ? 'active' : '' }}">
                    <ul class="episodes-list">
                        @foreach ($season->episodes as $episode)
                            <li class="episode-item {{ $loop->first && $loop->parent->first ? 'active' : '' }}"
                                data-episode="{{ $episode->episode_number }}" data-season="{{ $season->season_number }}"
                                data-links='@json($episode->all_links ?? $episode->playLinks, JSON_UNESCAPED_SLASHES)'>
                                <div class="episode-number">{{ sprintf('%02d', $episode->episode_number) }}
                                </div>
                                <div class="episode-info">
                                    <div class="episode-title">{{ $episode->name }}</div>
                                    {{-- <div class="episode-description">{{ $episode->description }}</div> --}}
                                </div>
                                <div class="episode-duration">{{ $episode->runtime }} min</div>
                                <button
                                    class="episode-play-btn {{ $loop->first && $loop->parent->first ? 'active' : '' }}">
                                    <i class="fas fa-play"></i>
                                </button>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endforeach
    </section>

    <!-- Seção do Elenco -->
    {{-- <section class="cast-section">
                <div class="section-header">
                    <h2 class="section-title">Elenco Principal</h2>
                    <a href="#" class="see-all-btn">Ver todo elenco <i class="fa-solid fa-arrow-right"></i></a>
                </div>
                <div class="cast-container">
                    @foreach ($serie->cast_members as $cast)
                    <div class="cast-card">
                        <div class="cast-photo">
                            <img src="{{ $cast->photo }}" alt="{{ $cast->name }}">
                        </div>
                        <div class="cast-name">{{ $cast->name }}</div>
                        <div class="cast-character">{{ $cast->character }}</div>
                    </div>
                    @endforeach
                </div>
            </section> --}}

    <!-- Seção de Séries Similares -->
    <section class="similar-series-section">
        <div class="section-header">
            <h2 class="section-title">Séries Similares</h2>
        </div>
        <div class="series-container">
            @foreach ($relatedSeries as $similar)
                <a href="{{ route('serie.show', ['slug' => $similar->slug]) }}">
                    <div class="serie-card">
                        <img src="{{ $similar->poster_url }}" alt="{{ $similar->title }}">
                        <div class="rating">{{ $similar->rating }}/10</div>
                        <div class="card-info">
                            <div class="serie-title-card">{{ $similar->title }}</div>
                            <div class="release-year">{{ $similar->year }}</div>
                        </div>
                    </div>
                </a>
            @endforeach
        </div>
    </section>
@endsection
