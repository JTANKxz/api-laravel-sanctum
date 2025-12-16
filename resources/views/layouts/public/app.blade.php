<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', config('app.name', 'MaxCine'))</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link href="https://vjs.zencdn.net/8.10.0/video-js.css" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            /* Primary Colors */
            --primary-color: #9537e2;
            --secondary-color: #131313;

            /* Background Colors */
            --background-color: #000000;
            --light-background-color: #f5f5f5;

            /* Text Colors */
            --text-color: #f0f0f0;
            --light-text-color: rgba(255, 255, 255, 0.7);

            /* Auxiliary Colors */
            --hover-color: rgb(96, 4, 172);
            --scrollbar-color: #a052e0;
            --shadow-color: rgba(0, 0, 0, 0.7);
            --content-shadow-color: rgba(0, 0, 0, 0.9);
        }

        /* General Styles */
        body {
            margin: 0;
            font-family: 'Inter', sans-serif;
            background-color: var(--background-color);
            color: var(--text-color);
            overflow-x: hidden;
        }

        /* Header */
        .header {
            background-color: #0d0d0d;
            padding: 0px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: sticky;
            top: 0;
            z-index: 10;
            transition: transform 0.3s ease-in-out;
            border-bottom: 1px solid rgba(160, 82, 224, 0.2);
            height: 60px;
        }

        .logo {
            font-size: 24px;
            color: var(--primary-color);
            text-align: center;
            flex-grow: 1;
        }

        /* Menu e Search Icons */
        .header-nav {
            display: flex;
        }

        .header-menu {
            list-style: none;
            padding: 0;
            margin: 0;
            display: flex;
        }

        .header-item {
            margin-left: 20px;
        }

        .menu-icon,
        .header-item a {
            font-size: 24px;
            /* aumenta o tamanho do ícone */
            padding: 10px;
            /* aumenta a área clicável */
            color: var(--text-color);
            cursor: pointer;
            transition: color 0.3s ease-in-out, transform 0.2s;
        }

        .menu-icon:hover,
        .header-item a:hover {
            color: var(--hover-color);
            transform: scale(1.1);
            /* leve zoom ao passar o mouse */
        }

        /* Menu e Searchbar flutuantes */
        .menu-bar,
        .search-bar {
            position: fixed;
            top: 60px;
            left: 0;
            width: 100%;
            background-color: #0d0d0d;
            box-shadow: 0 8px 16px rgba(0, 0, 0, .3);
            z-index: 999;
            max-height: 0;
            opacity: 0;
            visibility: hidden;
            overflow: hidden;
            transition:
                max-height 0.35s ease-out,
                opacity 0.35s ease-out,
                padding 0.35s ease-out,
                visibility 0s linear 0.35s;
        }

        .menu-bar.visible,
        .search-bar.visible {
            max-height: calc(100vh - 60px);
            opacity: 1;
            visibility: visible;
            padding: 15px 20px;
            transition:
                max-height 0.35s ease-in,
                opacity 0.35s ease-in,
                padding 0.35s ease-in,
                visibility 0s linear 0s;
        }

        .menu-bar nav {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .menu-bar a {
            color: var(--text-color);
            text-decoration: none;
            padding: 8px 15px;
            border-radius: 8px;
            transition: background-color 0.3s ease;
        }

        .menu-bar a:hover {
            background-color: #2c2c2c;
        }

        .search-bar-input {
            width: 90%;
            padding: 12px;
            font-size: 16px;
            border: 1px solid var(--primary-color);
            border-radius: 25px;
            background-color: #1a1a1a;
            color: var(--text-color);
            transition: border-color 0.3s ease;
        }

        .search-bar-input:focus {
            outline: none;
            border-color: var(--hover-color);
        }

        /* Main Content */
        .main {
            padding: 20px;
        }

        /* Footer */
        .footer {
            background: linear-gradient(180deg, #0d0d0d 0%, #000 100%);
            color: var(--text-color);
            padding: 50px 20px 20px;
            border-top: 1px solid rgba(160, 82, 224, 0.3);
        }

        .footer-content {
            max-width: 1200px;
            margin: 0 auto;
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 40px;
            margin-bottom: 40px;
        }

        .footer-column h3 {
            font-size: 18px;
            margin-bottom: 20px;
            color: var(--primary-color);
            position: relative;
            padding-bottom: 10px;
        }

        .footer-column h3::after {
            content: '';
            position: absolute;
            left: 0;
            bottom: 0;
            width: 40px;
            height: 2px;
            background-color: var(--primary-color);
        }

        .footer-links {
            list-style: none;
            padding: 0;
        }

        .footer-links li {
            margin-bottom: 12px;
        }

        .footer-links a {
            color: var(--light-text-color);
            text-decoration: none;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
        }

        .footer-links a:hover {
            color: var(--primary-color);
            transform: translateX(5px);
        }

        .footer-links a i {
            margin-right: 10px;
            font-size: 14px;
            width: 20px;
            text-align: center;
        }

        .footer-about p {
            line-height: 1.6;
            color: var(--light-text-color);
            margin-bottom: 20px;
        }

        .social-links {
            display: flex;
            gap: 15px;
            margin-top: 20px;
        }

        .social-link {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 40px;
            height: 40px;
            background-color: rgba(160, 82, 224, 0.1);
            border-radius: 50%;
            color: var(--text-color);
            transition: all 0.3s ease;
            text-decoration: none;
        }

        .social-link:hover {
            background-color: var(--primary-color);
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(160, 82, 224, 0.4);
        }

        .footer-apps {
            display: flex;
            gap: 15px;
            margin-top: 20px;
            flex-wrap: wrap;
        }

        .app-download {
            display: flex;
            align-items: center;
            background-color: rgba(255, 255, 255, 0.05);
            padding: 10px 15px;
            border-radius: 8px;
            text-decoration: none;
            color: var(--text-color);
            transition: all 0.3s ease;
            border: 1px solid rgba(160, 82, 224, 0.2);
        }

        .app-download:hover {
            background-color: rgba(160, 82, 224, 0.1);
            border-color: var(--primary-color);
            transform: translateY(-2px);
        }

        .app-download i {
            font-size: 24px;
            margin-right: 10px;
            color: var(--primary-color);
        }

        .app-info {
            display: flex;
            flex-direction: column;
        }

        .app-info span:first-child {
            font-size: 12px;
            color: var(--light-text-color);
        }

        .app-info span:last-child {
            font-size: 16px;
            font-weight: 600;
        }

        .footer-bottom {
            max-width: 1200px;
            margin: 0 auto;
            padding-top: 30px;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
        }

        .footer-logo {
            font-size: 28px;
            font-weight: 700;
            color: var(--primary-color);
            margin-bottom: 15px;
        }

        .copyright {
            color: var(--light-text-color);
            font-size: 14px;
            margin-bottom: 10px;
        }

        .footer-legal {
            display: flex;
            gap: 20px;
            flex-wrap: wrap;
            justify-content: center;
            margin-top: 15px;
        }

        .footer-legal a {
            color: var(--light-text-color);
            text-decoration: none;
            font-size: 14px;
            transition: color 0.3s ease;
        }

        .footer-legal a:hover {
            color: var(--primary-color);
        }

        @media (max-width: 768px) {
            .header {
                padding: 0px 15px;
                height: 55px;
            }

            .logo {
                font-size: 22px;
            }

            .header-item a,
            .menu-icon {
                font-size: 18px;
            }

            .menu-bar,
            .search-bar {
                top: 55px;
            }

            .main {
                padding: 15px;
            }

            .footer {
                padding: 40px 15px 15px;
            }

            .footer-content {
                gap: 30px;
            }
        }

        @media (max-width: 480px) {
            .header {
                padding: 0px 10px;
                height: 50px;
            }

            .logo {
                font-size: 20px;
            }

            .header-item {
                margin-left: 15px;
            }

            .header-item a,
            .menu-icon {
                font-size: 18px;
            }

            .menu-bar,
            .search-bar {
                top: 50px;
                padding: 10px 15px;
            }

            .main {
                padding: 10px;
            }

            .footer {
                padding: 30px 10px 10px;
            }

            .footer-content {
                grid-template-columns: 1fr;
                gap: 25px;
            }

            .footer-column h3 {
                font-size: 16px;
            }

            .footer-logo {
                font-size: 24px;
            }

            .social-links,
            .footer-apps {
                justify-content: center;
            }

            .footer-legal {
                flex-direction: column;
                gap: 10px;
                text-align: center;
            }
        }

        /* Celulares pequenos (360px pra baixo) */
        @media (max-width: 360px) {
            .header {
                padding: 0px 8px;
                height: 45px;
            }

            .logo {
                font-size: 18px;
            }

            .header-item {
                margin-left: 10px;
            }

            .main {
                padding: 8px;
            }

            .footer {
                padding: 25px 8px 8px;
            }

            .app-download {
                padding: 8px 12px;
            }

            .app-download i {
                font-size: 20px;
            }

            .app-info span:last-child {
                font-size: 14px;
            }
        }
    </style>
    @yield('styles')
</head>

<body>

    <div id="menuBar" class="menu-bar">
        <nav>
            <a href="{{ route('home') }}">Início</a>
            <a href="{{ route('movie.index') }}">Filmes</a>
            <a href="{{ route('serie.index') }}">Séries</a>
            <a href="{{ route('app.download') }}">Baixe Nosso App</a>
        </nav>
    </div>

    <div id="searchBar" class="search-bar">
        <form action="{{ route('search.index') }}" method="GET">
            <input type="text" name="q" id="searchInput" class="search-bar-input" placeholder="Pesquise..." />
        </form>
    </div>

    @yield('modal')

    <div class="main-container">
        <header class="header">
            <a href="#" id="menuIcon" class="menu-icon"><i class="fa-solid fa-bars"></i></a>
            <h1 class="logo">MaxCIne</h1>
            <nav class="header-nav">
                <ul class="header-menu">
                    <li class="header-item">
                        <a href="{{ route('home') }}" id="searchIcon"><i class="fa-solid fa-magnifying-glass"></i></a>
                    </li>
                </ul>
            </nav>
        </header>
        <main class="main">
            @yield('content') {{-- Conteúdo específico de cada página --}}
        </main>

        <!-- Footer (comum a todas as páginas) -->
        <footer class="footer">
            <div class="footer-content">

                {{-- <div class="footer-column">
                    <h3>Categorias</h3>
                    <ul class="footer-links">
                        <li><a href="#"><i class="fas fa-theater-masks"></i> Ação</a></li>
                    </ul>
                </div> --}}
                <div class="footer-column">
                    <h3>Navegação</h3>
                    <ul class="footer-links">
                        <li><a href="{{ route('home') }}"><i class="fas fa-home"></i> Início</a></li>
                    </ul>
                </div>

                <div class="footer-column footer-about">
                    <h3>Sobre Nós</h3>
                    <p>O MaxCine é a sua plataforma de streaming preferida, oferecendo os melhores filmes e séries
                        com qualidade premium a qualquer hora, em qualquer lugar.</p>

                    <div class="social-links">
                        {{-- <a href="#" class="social-link" aria-label="Facebook">
                            <i class="fab fa-facebook-f"></i>
                        </a> --}}
                        {{-- <a href="#" class="social-link" aria-label="Twitter">
                            <i class="fab fa-twitter"></i>
                        </a> --}}
                        <a href="#" class="social-link" aria-label="Twitter">
                            <i class="fab fa-whatsapp"></i>
                        </a>
                        <a href="instagram.com/fyneofc" class="social-link" aria-label="Instagram">
                            <i class="fab fa-instagram"></i>
                        </a>
                        {{-- <a href="#" class="social-link" aria-label="YouTube">
                            <i class="fab fa-youtube"></i>
                        </a> --}}
                    </div>
                </div>

                <div class="footer-column">
                    <h3>Baixe Nosso App</h3>
                    <p>Assista em qualquer dispositivo com nosso aplicativo exclusivo.</p>

                    <div class="footer-apps">

                        <a href="{{ route('app.download') }}" class="app-download">
                            <i class="fas fa-download"></i>
                            <div class="app-info">
                                <span>Download</span>
                                <span>APK Android</span>
                            </div>
                        </a>

                        {{-- <a href="#" class="app-download">
                            <i class="fab fa-google-play"></i>
                            <div class="app-info">
                                <span>Disponível no</span>
                                <span>Google Play</span>
                            </div>
                        </a>

                        <a href="#" class="app-download">
                            <i class="fab fa-apple"></i>
                            <div class="app-info">
                                <span>Baixe na</span>
                                <span>App Store</span>
                            </div>
                        </a> --}}
                    </div>
                </div>
            </div>

            <div class="footer-bottom">
                <div class="footer-logo">MaxCine</div>
                <p class="copyright">© 2025 MaxCine. Todos os direitos reservados.</p>

                <div class="footer-legal">
                    <a href="#">Política de Privacidade</a>
                    <a href="#">Termos de Uso</a>
                    <a href="#">Cookies</a>
                    <a href="#">Ajuda</a>
                    <a href="#">Contato</a>
                </div>
            </div>
        </footer>
    </div>
    <script>
        // Ocultar e mostrar a barra de menu de navegação
        const menuIcon = document.getElementById("menuIcon");
        const menuBar = document.getElementById("menuBar");

        menuIcon.addEventListener("click", (event) => {
            event.preventDefault();
            menuBar.classList.toggle("visible");
            searchBar.classList.remove("visible");
        });

        // Ocultar e mostrar a barra de pesquisa
        const searchIcon = document.getElementById("searchIcon");
        const searchBar = document.getElementById("searchBar");

        searchIcon.addEventListener("click", (event) => {
            event.preventDefault();
            searchBar.classList.toggle("visible");
            menuBar.classList.remove("visible");
            if (searchBar.classList.contains("visible")) {
                document.getElementById("searchInput").focus();
            }
        });
    </script>
    @yield('scripts') {{-- Scripts específicos de cada página --}}
</body>

</html>
