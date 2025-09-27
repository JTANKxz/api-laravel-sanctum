@extends('layouts.public.app')

@section('styles')
    <style>
        /* Serie Detail Section */
        .serie-detail-section {
            margin-bottom: 40px;
        }

        .serie-backdrop {
            position: relative;
            width: 100%;
            min-height: 300px;
            /* mostrar a imagem inteira */
            background-size: contain;
            background-repeat: no-repeat;
            background-position: center;
            /* remova o aspect-ratio fixo */
            aspect-ratio: 16/9;
            border-radius: 10px;
            overflow: hidden;
            margin-bottom: 30px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.7);
            display: flex;
            align-items: flex-end;
        }


        .serie-backdrop::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            background: linear-gradient(to top, rgba(0, 0, 0, 0.9) 0%, transparent 100%);
        }

        .backdrop-play-btn {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background-color: rgba(160, 82, 224, 0.8);
            color: white;
            border: none;
            width: 80px;
            height: 80px;
            border-radius: 50%;
            cursor: pointer;
            z-index: 2;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 30px;
            transition: all 0.3s;
        }

        .backdrop-play-btn:hover {
            background-color: var(--primary-color);
            transform: translate(-50%, -50%) scale(1.1);
        }

        .serie-content {
            position: relative;
            z-index: 2;
        }

        .serie-info {
            padding: 5px 0;
        }

        .serie-title {
            font-size: 36px;
            font-weight: 700;
            margin-bottom: 10px;
            color: var(--text-color);
        }

        .serie-meta {
            display: flex;
            align-items: center;
            gap: 15px;
            margin-bottom: 10px;
            flex-wrap: wrap;
        }

        .serie-rating {
            display: flex;
            align-items: center;
            background-color: rgba(245, 197, 24, 0.2);
            padding: 5px 10px;
            border-radius: 5px;
            color: #f5c518;
            font-weight: 600;
        }

        .serie-rating i {
            margin-right: 5px;
        }

        .serie-year,
        .serie-seasons {
            background-color: rgba(255, 255, 255, 0.1);
            padding: 5px 10px;
            border-radius: 5px;
            font-weight: 600;
        }

        .serie-actions {
            display: flex;
            gap: 15px;
            margin-bottom: 10px;
        }

        .watch-btn {
            background-color: var(--primary-color);
            color: white;
            border: none;
            padding: 12px 30px;
            border-radius: 5px;
            font-weight: 600;
            cursor: pointer;
            transition: background-color 0.3s;
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 16px;
        }

        .watch-btn:hover {
            background-color: var(--hover-color);
        }

        .favorite-btn {
            background-color: transparent;
            color: var(--text-color);
            border: 1px solid var(--text-color);
            padding: 12px 20px;
            border-radius: 5px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .favorite-btn:hover {
            border-color: var(--primary-color);
            color: var(--primary-color);
        }

        .serie-overview {
            font-size: 16px;
            line-height: 1.6;
            margin-bottom: 5px;
            color: var(--light-text-color);
        }

        .serie-details {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 10px;
            margin-bottom: 10px;
        }

        .detail-item {
            margin-bottom: 10px;
        }

        .detail-label {
            font-weight: 600;
            color: var(--primary-color);
            margin-bottom: 5px;
        }

        .detail-value {
            color: var(--light-text-color);
        }

        /* Seção Gêneros */
        .genres-section {
            margin-bottom: 10px;
        }

        .genres-container {
            display: flex;
            flex-wrap: wrap;
            gap: 15px;
            padding-bottom: 10px;
        }

        .genre-card {
            background-color: transparent;
            border: 1px solid rgba(160, 82, 224, 0.5);
            border-radius: 50px;
            padding: 8px 20px;
            color: var(--text-color);
            text-align: center;
            text-decoration: none;
            font-weight: 600;
            font-size: 14px;
            transition: background-color 0.3s ease, transform 0.3s ease, border-color 0.3s ease;
            white-space: nowrap;
        }

        .genre-card:hover {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
            transform: scale(1.05);
        }

        /* Seção Temporadas */
        .seasons-section {
            margin-bottom: 40px;
        }

        .section-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .section-title {
            font-size: 24px;
            font-weight: 700;
            color: var(--primary-color);
            margin: 0;
        }

        .see-all-btn {
            color: var(--light-text-color);
            text-decoration: none;
            font-size: 14px;
            font-weight: 600;
            padding: 6px 12px;
            border-radius: 20px;
            border: 1px solid transparent;
            transition: all 0.3s ease;
        }

        .see-all-btn:hover {
            color: var(--primary-color);
            border-color: var(--primary-color);
            background-color: rgba(160, 82, 224, 0.1);
        }

        .season-accordion {
            margin-bottom: 15px;
            border-radius: 10px;
            overflow: hidden;
            background-color: var(--secondary-color);
            box-shadow: 0 4px 15px var(--shadow-color);
            border: 1px solid rgba(160, 82, 224, 0.3);
        }

        .season-header {
            padding: 15px 20px;
            background-color: #1a1a1a;
            cursor: pointer;
            display: flex;
            justify-content: space-between;
            align-items: center;
            transition: background-color 0.3s;
        }

        .season-header:hover {
            background-color: #2a2a2a;
        }

        .season-header.active {
            background-color: rgba(160, 82, 224, 0.2);
        }

        .season-title {
            font-size: 18px;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .season-icon {
            transition: transform 0.3s;
        }

        .season-header.active .season-icon {
            transform: rotate(180deg);
        }

        .season-episode-count {
            font-size: 14px;
            color: var(--light-text-color);
        }

        .season-content {
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.5s ease;
        }

        .season-content.active {
            max-height: 1000px;
        }

        .episodes-list {
            padding: 0;
            margin: 0;
            list-style: none;
        }

        .episode-item {
            display: flex;
            align-items: center;
            padding: 15px 20px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            transition: background-color 0.3s;
        }

        .episode-item:last-child {
            border-bottom: none;
        }

        .episode-item:hover {
            background-color: rgba(255, 255, 255, 0.05);
        }

        .episode-item.active {
            background-color: rgba(160, 82, 224, 0.1);
        }

        .episode-number {
            font-size: 16px;
            font-weight: 600;
            color: var(--primary-color);
            min-width: 40px;
        }

        .episode-info {
            flex: 1;
            margin: 0 15px;
        }

        .episode-title {
            font-weight: 600;
            margin-bottom: 5px;
        }

        .episode-description {
            font-size: 14px;
            color: var(--light-text-color);
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .episode-duration {
            font-size: 14px;
            color: var(--light-text-color);
            min-width: 70px;
            text-align: right;
        }

        .episode-play-btn {
            background-color: transparent;
            border: 1px solid var(--primary-color);
            color: var(--primary-color);
            width: 36px;
            height: 36px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.3s;
            margin-left: 15px;
        }

        .episode-play-btn:hover {
            background-color: var(--primary-color);
            color: white;
        }

        .episode-play-btn.active {
            background-color: var(--primary-color);
            color: white;
        }

        /* Cast Section */
        .cast-section {
            margin-bottom: 40px;
        }

        .cast-container {
            display: flex;
            overflow-x: auto;
            scroll-behavior: smooth;
            padding: 10px;
            gap: 20px;
        }

        .cast-card {
            min-width: 150px;
            text-align: center;
        }

        .cast-photo {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            overflow: hidden;
            margin: 0 auto 15px;
            border: 2px solid var(--primary-color);
        }

        .cast-photo img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .cast-name {
            font-weight: 600;
            margin-bottom: 5px;
        }

        .cast-character {
            font-size: 14px;
            color: var(--light-text-color);
        }

        /* Similar Series Section */
        .similar-series-section {
            margin-bottom: 40px;
        }

        .series-container {
            display: flex;
            overflow-x: auto;
            scroll-behavior: smooth;
            padding: 10px;
        }

        .serie-card {
            position: relative;
            min-width: 180px;
            height: 270px;
            margin-right: 20px;
            border-radius: 12px;
            overflow: hidden;
            background-color: var(--secondary-color);
            box-shadow: 0 4px 15px var(--shadow-color);
            cursor: pointer;
            border: 1px solid rgba(160, 82, 224, 0.4);
            transition: transform 0.4s ease, box-shadow 0.4s ease, border 0.3s ease;
        }

        .serie-card:hover {
            transform: scale(1.05);
            z-index: 2;
            border: 1px solid var(--primary-color);
        }

        .serie-card img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .rating {
            position: absolute;
            top: 10px;
            right: 10px;
            background-color: var(--content-shadow-color);
            color: var(--primary-color);
            font-size: 14px;
            padding: 5px 10px;
            border-radius: 5px;
            font-weight: bold;
        }

        .card-info {
            position: absolute;
            bottom: 0;
            width: 100%;
            background: rgba(0, 0, 0, 0.8);
            padding: 10px 0;
            text-align: center;
            overflow: hidden;
            color: var(--text-color);
        }

        .serie-title-card {
            font-size: 16px;
            font-weight: bold;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            padding: 0 10px;
            box-sizing: border-box;
        }

        .release-year {
            font-size: 12px;
            color: var(--primary-color);
            margin-top: 5px;
        }

        /* Video Player */
        .video-player-container {
            aspect-ratio: 16/9;
            min-height: 300px;
            background-color: #000;
            border-radius: 10px;
            overflow: hidden;
            margin-bottom: 5px;
            position: relative;
            display: none;
        }

        .video-player {
            width: 100%;
            height: 100%;
        }

        .video-js {
            width: 100%;
            height: 100%;
        }

        /* Estilização dos controles do Video.js */
        .video-js .vjs-control-bar {
            background: rgba(0, 0, 0, 0.7) !important;
        }

        .video-js .vjs-play-progress,
        .video-js .vjs-volume-level {
            background-color: var(--primary-color) !important;
        }

        .video-js .vjs-slider {
            background-color: rgba(255, 255, 255, 0.2) !important;
        }

        .video-js .vjs-big-play-button {
            background-color: rgba(160, 82, 224, 0.8) !important;
            border: none !important;
            border-radius: 50% !important;
            width: 80px !important;
            height: 80px !important;
            line-height: 80px !important;
            margin-top: -40px !important;
            margin-left: -40px !important;
        }

        .video-js .vjs-big-play-button:hover {
            background-color: var(--primary-color) !important;
        }

        /* Player Controls */
        .player-controls {
            display: none;
            justify-content: space-between;
            align-items: center;
            gap: 15px;
            margin-bottom: 30px;
        }

        .episode-nav-btn {
            background-color: rgba(0, 0, 0, 0.7);
            color: var(--text-color);
            border: 1px solid var(--primary-color);
            padding: 10px 15px;
            border-radius: 5px;
            cursor: pointer;
            transition: all 0.3s;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .episode-nav-btn:hover:not(:disabled) {
            background-color: var(--primary-color);
        }

        .episode-nav-btn:disabled {
            opacity: 0.5;
            cursor: not-allowed;
        }

        .change-player-btn {
            background-color: rgba(0, 0, 0, 0.7);
            color: var(--text-color);
            border: 1px solid var(--primary-color);
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            transition: all 0.3s;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .change-player-btn:hover {
            background-color: var(--primary-color);
        }

        /* Modal de Seleção de Player */
        .player-modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.9);
            z-index: 1000;
            align-items: center;
            justify-content: center;
        }

        .player-modal.active {
            display: flex;
        }

        .player-modal-content {
            width: 90%;
            max-width: 600px;
            background-color: #1a1a1a;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.7);
        }

        .player-modal-header {
            padding: 20px;
            background-color: #0d0d0d;
            border-bottom: 1px solid rgba(160, 82, 224, 0.3);
        }

        .player-modal-title {
            font-size: 24px;
            font-weight: 700;
            color: var(--primary-color);
            margin: 0;
        }

        .player-modal-body {
            padding: 20px;
            max-height: 60vh;
            overflow-y: auto;
        }

        .player-option {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px;
            background-color: #2a2a2a;
            border: 1px solid rgba(160, 82, 224, 0.3);
            border-radius: 5px;
            margin-bottom: 10px;
            cursor: pointer;
            transition: all 0.3s;
        }

        .player-option:hover {
            background-color: rgba(160, 82, 224, 0.2);
            border-color: var(--primary-color);
        }

        .player-option.active {
            background-color: rgba(160, 82, 224, 0.3);
            border-color: var(--primary-color);
        }

        .player-option-info {
            flex: 1;
        }

        .player-option-name {
            font-weight: 600;
            margin-bottom: 5px;
        }

        .player-option-details {
            font-size: 14px;
            color: var(--light-text-color);
        }

        .player-option-select {
            background-color: var(--primary-color);
            color: white;
            border: none;
            padding: 8px 15px;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .player-option-select:hover {
            background-color: var(--hover-color);
        }

        .player-modal-footer {
            padding: 15px 20px;
            background-color: #0d0d0d;
            border-top: 1px solid rgba(160, 82, 224, 0.3);
            text-align: right;
        }

        .player-modal-close {
            background-color: transparent;
            color: var(--text-color);
            border: 1px solid var(--text-color);
            padding: 8px 20px;
            border-radius: 5px;
            cursor: pointer;
            transition: all 0.3s;
        }

        .player-modal-close:hover {
            border-color: var(--primary-color);
            color: var(--primary-color);
        }

        /* Scrollbars */
        .cast-container::-webkit-scrollbar,
        .series-container::-webkit-scrollbar {
            height: 8px;
        }

        .cast-container::-webkit-scrollbar-thumb,
        .series-container::-webkit-scrollbar-thumb {
            background-color: var(--scrollbar-color);
            border-radius: 10px;
        }

        .cast-container::-webkit-scrollbar-track,
        .series-container::-webkit-scrollbar-track {
            background-color: #333;
        }

        /* ===== RESPONSIVIDADE ===== */

        /* Tablets (768px pra baixo) */
        @media (max-width: 768px) {

            .serie-title {
                font-size: 28px;
            }

            .serie-meta {
                gap: 10px;
            }

            .serie-details {
                grid-template-columns: 1fr;
            }

            .section-title {
                font-size: 22px;
            }

            .cast-card {
                min-width: 120px;
            }

            .cast-photo {
                width: 100px;
                height: 100px;
            }

            .serie-card {
                min-width: 160px;
                height: 240px;
                margin-right: 15px;
            }

        }

        /* Celulares grandes (480px pra baixo) */
        @media (max-width: 480px) {

            .serie-title {
                font-size: 20px;
            }

            .serie-meta {
                gap: 8px;
                font-size: 14px;
            }

            .serie-actions {
                flex-direction: row;
                align-items: flex-start;
                gap: 10px;
            }

            .watch-btn,
            .favorite-btn {
                padding: 10px 15px;
                font-size: 14px;
            }

            .section-header {
                margin-bottom: 15px;
            }

            .section-title {
                font-size: 18px;
            }

            .see-all-btn {
                font-size: 12px;
                padding: 4px 8px;
            }

            .cast-card {
                min-width: 100px;
            }

            .cast-photo {
                width: 80px;
                height: 80px;
            }

            .serie-card {
                min-width: 120px;
                height: 180px;
                margin-right: 12px;
            }

            .serie-title-card {
                font-size: 14px;
            }

            .episode-item {
                flex-direction: column;
                align-items: flex-start;
            }

            .episode-info {
                margin: 10px 0;
            }

            .episode-duration {
                text-align: left;
                margin-bottom: 10px;
            }

            .player-controls {}

            .episode-nav-btn,
            .change-player-btn {
                width: 100%;
                justify-content: center;
            }

        }

        /* Celulares pequenos (360px pra baixo) */
        @media (max-width: 360px) {

            .serie-title {
                font-size: 18px;
            }

            .serie-meta {
                font-size: 12px;
            }

            .serie-overview {
                font-size: 14px;
            }

            .cast-card {
                min-width: 80px;
            }

            .cast-photo {
                width: 60px;
                height: 60px;
            }

            .cast-name {
                font-size: 14px;
            }

            .serie-card {
                min-width: 100px;
                height: 150px;
                margin-right: 10px;
            }

            .serie-title-card {
                font-size: 12px;
            }
        }
    </style>
@endsection

@section('modal')
 <!-- Modal de Seleção de Player -->
 <div class="player-modal" id="playerModal">
    <div class="player-modal-content">
        <div class="player-modal-header">
            <h2 class="player-modal-title">Selecione uma Opção de Reprodução</h2>
        </div>
        <div class="player-modal-body" id="playerOptions">
            <!-- As opções serão geradas dinamicamente pelo JavaScript -->
        </div>
        <div class="player-modal-footer">
            <button class="player-modal-close" id="playerModalClose">Fechar</button>
        </div>
    </div>
</div>
@endsection

@section('content')
   
@endsection

@section('scripts')
    <script src="https://vjs.zencdn.net/8.10.0/video.min.js"></script>
    <script>
        // Função para alternar o botão de favorito
        const favoriteBtn = document.querySelector('.favorite-btn');
        const favoriteIcon = favoriteBtn.querySelector('i');

        favoriteBtn.addEventListener('click', () => {
            favoriteBtn.classList.toggle('favorited');
            if (favoriteBtn.classList.contains('favorited')) {
                favoriteIcon.classList.remove('fa-regular');
                favoriteIcon.classList.add('fa-solid');
                favoriteBtn.style.borderColor = 'var(--primary-color)';
                favoriteBtn.style.color = 'var(--primary-color)';
            } else {
                favoriteIcon.classList.remove('fa-solid');
                favoriteIcon.classList.add('fa-regular');
                favoriteBtn.style.borderColor = 'var(--text-color)';
                favoriteBtn.style.color = 'var(--text-color)';
            }
        });

        // Lógica do Player
        const playerModal = document.getElementById('playerModal');
        const playerModalClose = document.getElementById('playerModalClose');
        const watchBtn = document.getElementById('watchBtn');
        const backdropPlayBtn = document.getElementById('backdropPlayBtn');
        const playerOptions = document.getElementById('playerOptions');
        const serieBackdrop = document.getElementById('serieBackdrop');
        const videoPlayerContainer = document.getElementById('videoPlayerContainer');
        const videoPlayer = document.getElementById('videoPlayer');
        const changePlayerBtn = document.getElementById('changePlayerBtn');
        const playerControls = document.getElementById('playerControls');
        const prevEpisodeBtn = document.getElementById('prevEpisodeBtn');
        const nextEpisodeBtn = document.getElementById('nextEpisodeBtn');

        // Variáveis globais
        let currentPlayer = null;
        let currentPlayerType = null;
        let currentSeason = 1;
        let currentEpisode = 1;
        let currentEpisodeLinks = [];
        let lastPlayedSeason = 1;
        let lastPlayedEpisode = 1;
        let lastPlayedLinks = [];

        // Inicializar com o primeiro episódio da primeira temporada
        document.addEventListener('DOMContentLoaded', function() {
            // Encontrar o primeiro episódio da primeira temporada
            const firstEpisodeItem = document.querySelector('.episode-item[data-season="1"][data-episode="1"]');
            if (firstEpisodeItem) {
                const season = firstEpisodeItem.dataset.season;
                const episode = firstEpisodeItem.dataset.episode;
                const links = JSON.parse(firstEpisodeItem.dataset.links);

                // Definir como episódio atual e último reproduzido
                currentSeason = parseInt(season);
                currentEpisode = parseInt(episode);
                currentEpisodeLinks = links;
                lastPlayedSeason = currentSeason;
                lastPlayedEpisode = currentEpisode;
                lastPlayedLinks = currentEpisodeLinks;
            }

            // Inicializar a navegação de episódios
            updateEpisodeNavigation();
        });

        // Lógica do acordeão de temporadas
        const seasonHeaders = document.querySelectorAll('.season-header');

        seasonHeaders.forEach(header => {
            header.addEventListener('click', () => {
                const season = header.dataset.season;
                const content = header.nextElementSibling;

                // Fechar todas as outras temporadas
                document.querySelectorAll('.season-content').forEach(item => {
                    if (item !== content) {
                        item.classList.remove('active');
                    }
                });

                document.querySelectorAll('.season-header').forEach(item => {
                    if (item !== header) {
                        item.classList.remove('active');
                    }
                });

                // Alternar a temporada clicada
                header.classList.toggle('active');
                content.classList.toggle('active');
            });
        });

        // Elementos dos episódios
        const episodeItems = document.querySelectorAll('.episode-item');
        const episodePlayBtns = document.querySelectorAll('.episode-play-btn');

        // Função para reproduzir um episódio
        function playEpisode(episodeItem) {
            const season = episodeItem.dataset.season;
            const episode = episodeItem.dataset.episode;
            const links = JSON.parse(episodeItem.dataset.links);

            // Remover classe active de todos os episódios
            episodeItems.forEach(item => {
                item.classList.remove('active');
            });

            episodePlayBtns.forEach(button => {
                button.classList.remove('active');
            });

            // Adicionar classe active ao episódio clicado
            episodeItem.classList.add('active');
            const btn = episodeItem.querySelector('.episode-play-btn');
            btn.classList.add('active');

            // Atualizar episódio atual E último reproduzido
            currentSeason = parseInt(season);
            currentEpisode = parseInt(episode);
            currentEpisodeLinks = links;

            // ATUALIZAR também o último episódio reproduzido
            lastPlayedSeason = currentSeason;
            lastPlayedEpisode = currentEpisode;
            lastPlayedLinks = currentEpisodeLinks;

            // Abrir modal de seleção de player
            openPlayerModal();

            // Atualizar controles de navegação
            updateEpisodeNavigation();
        }

        // No evento de clique dos botões de play, chamar a função playEpisode
        episodePlayBtns.forEach((btn, index) => {
            btn.addEventListener('click', (e) => {
                e.stopPropagation();
                const episodeItem = btn.closest('.episode-item');
                playEpisode(episodeItem);
            });
        });

        // Função para atualizar navegação entre episódios
        function updateEpisodeNavigation() {
            // Encontrar todos os episódios da temporada atual
            const seasonEpisodes = document.querySelectorAll(`.episode-item[data-season="${currentSeason}"]`);
            const currentIndex = Array.from(seasonEpisodes).findIndex(item =>
                parseInt(item.dataset.episode) === currentEpisode
            );

            // Habilitar/desabilitar botões de navegação
            prevEpisodeBtn.disabled = currentIndex <= 0;
            nextEpisodeBtn.disabled = currentIndex >= seasonEpisodes.length - 1;
        }

        // Navegação entre episódios - CORRIGIDA
        prevEpisodeBtn.addEventListener('click', () => {
            if (prevEpisodeBtn.disabled) return;

            // Encontrar todos os episódios da temporada atual
            const seasonEpisodes = document.querySelectorAll(`.episode-item[data-season="${currentSeason}"]`);
            const currentIndex = Array.from(seasonEpisodes).findIndex(item =>
                parseInt(item.dataset.episode) === currentEpisode
            );

            // Encontrar o episódio anterior
            const prevEpisodeItem = seasonEpisodes[currentIndex - 1];
            playEpisode(prevEpisodeItem);
        });

        nextEpisodeBtn.addEventListener('click', () => {
            if (nextEpisodeBtn.disabled) return;

            // Encontrar todos os episódios da temporada atual
            const seasonEpisodes = document.querySelectorAll(`.episode-item[data-season="${currentSeason}"]`);
            const currentIndex = Array.from(seasonEpisodes).findIndex(item =>
                parseInt(item.dataset.episode) === currentEpisode
            );

            // Encontrar o próximo episódio
            const nextEpisodeItem = seasonEpisodes[currentIndex + 1];
            playEpisode(nextEpisodeItem);
        });

        // Função para criar opções de player
        function createPlayerOptions() {
            playerOptions.innerHTML = '';

            if (currentEpisodeLinks.length === 0) {
                playerOptions.innerHTML =
                    '<p style="text-align: center; color: var(--light-text-color);">Nenhuma opção de reprodução disponível para este episódio.</p>';
                return;
            }

            currentEpisodeLinks.forEach((link, index) => {
                const option = document.createElement('div');
                option.className = 'player-option';
                option.innerHTML = `
                <div class="player-option-info">
                    <div class="player-option-name">Player ${index + 1}</div>
                    <div class="player-option-details">${link.quality} • ${link.type.toUpperCase()}</div>
                </div>
                <button class="player-option-select" data-type="${link.type}" data-url="${link.url}">Selecionar</button>
            `;

                const selectBtn = option.querySelector('.player-option-select');
                selectBtn.addEventListener('click', (e) => {
                    e.stopPropagation();
                    loadPlayer(link.type, link.url);
                    playerModal.classList.remove('active');
                });

                playerOptions.appendChild(option);
            });
        }

        // Função para carregar o player baseado no tipo
        function loadPlayer(type, url) {
            // Esconder o backdrop e mostrar o player
            serieBackdrop.style.display = 'none';
            videoPlayerContainer.style.display = 'block';
            playerControls.style.display = 'flex';

            // Limpar player anterior se existir
            if (currentPlayer) {
                if (currentPlayerType !== 'embed' && typeof currentPlayer.dispose === 'function') {
                    currentPlayer.dispose();
                }
                currentPlayer = null;
            }

            videoPlayer.innerHTML = '';
            currentPlayerType = type;

            if (type === 'embed') {
                // Player para embed (YouTube, Vimeo, etc.)
                const iframe = document.createElement('iframe');
                iframe.src = url;
                iframe.width = '100%';
                iframe.height = '100%';
                iframe.frameBorder = '0';
                iframe.allowFullscreen = true;
                iframe.allow = 'autoplay; encrypted-media';
                videoPlayer.appendChild(iframe);
                currentPlayer = iframe;
            } else {
                // Player para vídeos diretos (mp4, mkv, hls) usando Video.js
                const video = document.createElement('video');
                video.id = `video-player-${currentSeason}-${currentEpisode}`;
                video.className = 'video-js vjs-default-skin';
                video.controls = true;
                video.preload = 'auto';
                video.width = '100%';
                video.height = '100%';

                const source = document.createElement('source');
                source.src = url;

                if (type === 'hls') {
                    source.type = 'application/x-mpegURL';
                } else {
                    source.type = `video/${type}`;
                }

                video.appendChild(source);
                videoPlayer.appendChild(video);

                // Inicializar Video.js com controles nativos
                currentPlayer = videojs(video.id, {
                    fluid: true,
                    responsive: true,
                    controls: true,
                    playbackRates: [0.5, 1, 1.25, 1.5, 2],
                    html5: {
                        vhs: {
                            overrideNative: true
                        }
                    }
                });

                // Adicionar evento de erro para debug
                currentPlayer.on('error', function() {
                    console.error('Erro no player de vídeo:', currentPlayer.error());
                });
            }

            // Atualizar o último episódio reproduzido
            lastPlayedSeason = currentSeason;
            lastPlayedEpisode = currentEpisode;
            lastPlayedLinks = currentEpisodeLinks;
        }

        // Função para abrir modal ao clicar em Assistir Agora ou no botão do backdrop
        function openPlayerModal() {
            // Sempre usar o último episódio reproduzido, não resetar para o primeiro
            if (lastPlayedLinks.length > 0) {
                currentSeason = lastPlayedSeason;
                currentEpisode = lastPlayedEpisode;
                currentEpisodeLinks = lastPlayedLinks;
            } else {
                // Fallback: usar o primeiro episódio se não houver último reproduzido
                const firstEpisodeItem = document.querySelector('.episode-item[data-season="1"][data-episode="1"]');
                if (firstEpisodeItem) {
                    currentSeason = parseInt(firstEpisodeItem.dataset.season);
                    currentEpisode = parseInt(firstEpisodeItem.dataset.episode);
                    currentEpisodeLinks = JSON.parse(firstEpisodeItem.dataset.links);
                }
            }

            playerModal.classList.add('active');
            createPlayerOptions();
        }

        // Event listeners para os botões de play
        backdropPlayBtn.addEventListener('click', openPlayerModal);
        watchBtn.addEventListener('click', openPlayerModal);

        // Fechar modal
        playerModalClose.addEventListener('click', () => {
            playerModal.classList.remove('active');
        });

        // Fechar modal ao clicar fora dele
        playerModal.addEventListener('click', (e) => {
            if (e.target === playerModal) {
                playerModal.classList.remove('active');
            }
        });

        // Botão para trocar o player (reabrir o modal)
        changePlayerBtn.addEventListener('click', () => {
            if (currentPlayer) {
                if (currentPlayerType !== 'embed' && typeof currentPlayer.dispose === 'function') {
                    currentPlayer.dispose();
                }
                currentPlayer = null;
            }
            openPlayerModal();
        });
    </script>
@endsection
