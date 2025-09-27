@extends('layouts.public.app')


@section('styles')
    <style>
        /* Movie Detail Section */
        .movie-detail-section {
            margin-bottom: 40px;
        }

        .movie-backdrop {
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

        .movie-backdrop::after {
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

        .movie-content {
            position: relative;
            z-index: 2;
        }

        .movie-info {
            padding: 20px 0;
        }

        .movie-title {
            font-size: 36px;
            font-weight: 700;
            margin-bottom: 10px;
            color: var(--text-color);
        }

        .movie-meta {
            display: flex;
            align-items: center;
            gap: 15px;
            margin-bottom: 20px;
            flex-wrap: wrap;
        }

        .movie-rating {
            display: flex;
            align-items: center;
            background-color: rgba(245, 197, 24, 0.2);
            padding: 5px 10px;
            border-radius: 5px;
            color: #f5c518;
            font-weight: 600;
        }

        .movie-rating i {
            margin-right: 5px;
        }

        .movie-year,
        .movie-runtime {
            background-color: rgba(255, 255, 255, 0.1);
            padding: 5px 10px;
            border-radius: 5px;
            font-weight: 600;
        }

        .movie-actions {
            display: flex;
            gap: 15px;
            margin-bottom: 25px;
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

        .movie-overview {
            font-size: 16px;
            line-height: 1.6;
            margin-bottom: 25px;
            color: var(--light-text-color);
        }

        .movie-details {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
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
            margin-bottom: 30px;
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

        /* Cast Section */
        .cast-section {
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

        /* Similar Movies Section */
        .similar-movies-section {
            margin-bottom: 40px;
        }

        .movies-container {
            display: flex;
            overflow-x: auto;
            scroll-behavior: smooth;
            padding: 10px;
        }

        .movie-card {
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

        .movie-card:hover {
            transform: scale(1.05);
            z-index: 2;
            border: 1px solid var(--primary-color);
        }

        .movie-card img {
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

        .movie-title-card {
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

        .change-player-btn {
            width: 100%;
            background-color: rgba(0, 0, 0, 0.7);
            color: var(--text-color);
            border: 1px solid var(--primary-color);
            padding: 12px 15px;
            border-radius: 5px;
            cursor: pointer;
            transition: all 0.3s;
            margin-bottom: 30px;
            font-weight: 600;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
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
        .movies-container::-webkit-scrollbar {
            height: 8px;
        }

        .cast-container::-webkit-scrollbar-thumb,
        .movies-container::-webkit-scrollbar-thumb {
            background-color: var(--scrollbar-color);
            border-radius: 10px;
        }

        .cast-container::-webkit-scrollbar-track,
        .movies-container::-webkit-scrollbar-track {
            background-color: #333;
        }

        /* ===== RESPONSIVIDADE ===== */

        /* Tablets (768px pra baixo) */
        @media (max-width: 768px) {

            .movie-backdrop,
            .video-player-container {
                height: 35vh;
                min-height: 250px;
            }

            .movie-title {
                font-size: 28px;
            }

            .movie-meta {
                gap: 10px;
            }

            .movie-details {
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

            .movie-card {
                min-width: 160px;
                height: 240px;
                margin-right: 15px;
            }

        }

        /* Celulares grandes (480px pra baixo) */
        @media (max-width: 480px) {

            .movie-title {
                font-size: 20px;
            }

            .movie-meta {
                gap: 8px;
                font-size: 14px;
            }

            .movie-actions {
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

            .movie-card {
                min-width: 120px;
                height: 180px;
                margin-right: 12px;
            }

            .movie-title-card {
                font-size: 14px;
            }

        }

        /* Celulares pequenos (360px pra baixo) */
        @media (max-width: 360px) {

            .movie-title {
                font-size: 18px;
            }

            .movie-meta {
                font-size: 12px;
            }

            .movie-overview {
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

            .movie-card {
                min-width: 100px;
                height: 150px;
                margin-right: 10px;
            }

            .movie-title-card {
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
        const movieBackdrop = document.getElementById('movieBackdrop');
        const videoPlayerContainer = document.getElementById('videoPlayerContainer');
        const videoPlayer = document.getElementById('videoPlayer');
        const changePlayerBtn = document.getElementById('changePlayerBtn');

        // ===================================================================
        // AQUI ESTÁ A MUDANÇA: Carregando os links reais do PHP/Laravel
        // Certifique-se de que o seu controller está passando a variável $links
        // ===================================================================
        const videoUrls = @json($links);

        let currentPlayer = null;
        let currentPlayerType = null;

        // Função para criar opções de player
        function createPlayerOptions() {
            playerOptions.innerHTML = '';

            // Filtra links que podem estar sem URL por algum erro no DB
            const availableUrls = videoUrls.filter(video => video.url);

            if (availableUrls.length === 0) {
                playerOptions.innerHTML = '<div class="player-option">Nenhum player disponível.</div>';
                return;
            }

            availableUrls.forEach((video, index) => {
                const option = document.createElement('div');
                option.className = 'player-option';
                option.innerHTML = `
            <div class="player-option-info">
                <div class="player-option-name">${video.name}</div>
                <div class="player-option-details">${video.quality || 'N/A'} • ${video.type ? video.type.toUpperCase() : 'N/A'}</div>
            </div>
            <button class="player-option-select" data-index="${index}">Selecionar</button>
        `;

                const selectBtn = option.querySelector('.player-option-select');
                selectBtn.addEventListener('click', (e) => {
                    e.stopPropagation();
                    // Passa os dados do link real
                    loadPlayer(video.type, video.url, index);
                    playerModal.classList.remove('active');
                });

                playerOptions.appendChild(option);
            });
        }

        // Função para carregar o player baseado no tipo
        function loadPlayer(type, url, index) {
            // Esconder o backdrop e mostrar o player
            movieBackdrop.style.display = 'none';
            videoPlayerContainer.style.display = 'block';
            changePlayerBtn.style.display = 'block';

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
                video.id = `video-player-${index}`;
                video.className = 'video-js vjs-default-skin';
                video.controls = true;
                video.preload = 'auto';
                video.width = '100%';
                video.height = '100%';

                const source = document.createElement('source');
                source.src = url;

                if (type === 'hls' || type === 'm3u8') { // Adicionando 'm3u8' por segurança
                    source.type = 'application/x-mpegURL';
                } else if (type === 'mp4' || type === 'mkv') {
                    source.type = `video/mp4`; // Simplificado para video/mp4, Video.js gerencia extensões
                } else {
                    source.type = `video/${type}`;
                }

                video.appendChild(source);
                videoPlayer.appendChild(video);

                // Inicializar Video.js
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
        }

        // Abrir modal ao clicar em Assistir Agora ou no botão do backdrop
        function openPlayerModal() {
            playerModal.classList.add('active');
            createPlayerOptions();
        }

        watchBtn.addEventListener('click', openPlayerModal);
        backdropPlayBtn.addEventListener('click', openPlayerModal);

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
            // Verifica se é um player do Video.js para descartá-lo corretamente
            if (currentPlayer && currentPlayerType !== 'embed' && typeof currentPlayer.dispose === 'function') {
                currentPlayer.dispose();
            }
            openPlayerModal();
        });
    </script>
@endsection
