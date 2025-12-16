<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FYNECINE | Streaming Gratuito de Filmes e Séries</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary-color: #8a4baf;
            --primary-dark: #6a3590;
            --secondary-color: #c770d1;
            --dark-bg: #000000;
            --dark-card: #0f0f0f;
            --light-text: #ffffff;
            --gray-text: #cccccc;
            --border-color: #222222;
            --gradient: linear-gradient(to right, #8a4baf, #c770d1);
            --shadow: 0 5px 15px rgba(0, 0, 0, 0.5);
            --card-shadow: 0 8px 20px rgba(0, 0, 0, 0.4);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background-color: var(--dark-bg);
            color: var(--light-text);
            line-height: 1.6;
            overflow-x: hidden;
        }

        a {
            text-decoration: none;
            color: inherit;
        }

        .container {
            width: 90%;
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
        }

        /* Header */
        header {
            padding: 20px 0;
            position: fixed;
            width: 100%;
            z-index: 1000;
            transition: all 0.3s ease;
            background-color: rgba(0, 0, 0, 0.95);
            border-bottom: 1px solid var(--border-color);
        }

        header.scrolled {
            padding: 15px 0;
            background-color: rgba(0, 0, 0, 0.98);
        }

        .header-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .logo {
            font-size: 28px;
            font-weight: 700;
            color: var(--light-text);
        }

        .logo span {
            color: var(--primary-color);
        }

        .nav-links {
            display: flex;
            list-style: none;
        }

        .nav-links li {
            margin-left: 30px;
        }

        .nav-links a {
            font-weight: 500;
            font-size: 16px;
            transition: color 0.3s ease;
            color: var(--gray-text);
        }

        .nav-links a:hover {
            color: var(--primary-color);
        }

        .mobile-menu-btn {
            display: none;
            font-size: 24px;
            cursor: pointer;
            color: var(--light-text);
        }

        /* Hero Section */
        .hero {
            padding: 180px 0 100px;
            position: relative;
            overflow: hidden;
            background-image:
                linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)),
                url("https://reactflix-sigma-peach.vercel.app/assets/bannerNetflix.ae2c1792.jpg");
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
        }

        .hero::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -20%;
            width: 60%;
            height: 150%;
            background: rgba(138, 75, 175, 0.05);
            transform: rotate(15deg);
            z-index: 0;
        }

        .hero-content {
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            position: relative;
            z-index: 1;
        }

        .hero-text {
            flex: 1;
            min-width: 300px;
            padding-right: 40px;
        }

        .hero-image {
            flex: 1;
            min-width: 300px;
            text-align: center;
        }

        .hero-image img {
            max-width: 100%;
            border-radius: 12px;
            box-shadow: var(--card-shadow);
            border: 1px solid var(--border-color);
        }

        .hero h1 {
            font-size: 48px;
            font-weight: 700;
            margin-bottom: 20px;
            line-height: 1.2;
        }

        .hero h1 span {
            color: var(--primary-color);
        }

        .hero p {
            font-size: 18px;
            color: var(--gray-text);
            margin-bottom: 30px;
        }

        .cta-button {
            display: inline-block;
            background: var(--gradient);
            color: white;
            padding: 16px 36px;
            border-radius: 8px;
            font-weight: 600;
            font-size: 18px;
            transition: all 0.3s ease;
            box-shadow: var(--shadow);
            border: none;
            cursor: pointer;
        }

        .cta-button:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 20px rgba(138, 75, 175, 0.3);
        }

        .cta-button i {
            margin-right: 10px;
        }

        /* Features Section */
        .features {
            padding: 100px 0;
            background-color: var(--dark-card);
        }

        .section-title {
            text-align: center;
            margin-bottom: 60px;
        }

        .section-title h2 {
            font-size: 36px;
            font-weight: 700;
            margin-bottom: 15px;
            color: var(--light-text);
        }

        .section-title h2 span {
            color: var(--primary-color);
        }

        .section-title p {
            color: var(--gray-text);
            font-size: 18px;
            max-width: 600px;
            margin: 0 auto;
        }

        .features-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 30px;
        }

        .feature-card {
            background-color: var(--dark-bg);
            border-radius: 12px;
            padding: 30px;
            text-align: center;
            transition: all 0.3s ease;
            border: 1px solid var(--border-color);
            box-shadow: var(--shadow);
        }

        .feature-card:hover {
            transform: translateY(-5px);
            border-color: var(--primary-color);
            box-shadow: var(--card-shadow);
        }

        .feature-icon {
            width: 70px;
            height: 70px;
            background: var(--dark-card);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
            border: 2px solid var(--primary-color);
        }

        .feature-icon i {
            font-size: 30px;
            color: var(--primary-color);
        }

        .feature-card h3 {
            font-size: 22px;
            margin-bottom: 15px;
            color: var(--light-text);
        }

        .feature-card p {
            color: var(--gray-text);
        }

        /* Download Section */
        .download {
            padding: 100px 0;
            background-color: var(--dark-bg);
            position: relative;
        }

        .download::before {
            content: '';
            position: absolute;
            bottom: -10%;
            left: -10%;
            width: 40%;
            height: 80%;
            background: rgba(138, 75, 175, 0.03);
            transform: rotate(-10deg);
            z-index: 0;
        }

        .download-content {
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            position: relative;
            z-index: 1;
        }

        .download-text {
            flex: 1;
            min-width: 300px;
            padding-right: 40px;
        }

        .download-text h2 {
            font-size: 36px;
            margin-bottom: 20px;
            color: var(--light-text);
        }

        .download-text h2 span {
            color: var(--primary-color);
        }

        .download-steps {
            flex: 1;
            min-width: 300px;
        }

        .download-step {
            display: flex;
            align-items: center;
            margin-bottom: 25px;
            background-color: var(--dark-card);
            padding: 20px;
            border-radius: 12px;
            border: 1px solid var(--border-color);
            transition: all 0.3s ease;
        }

        .download-step:hover {
            border-color: var(--primary-color);
        }

        .step-number {
            width: 50px;
            height: 50px;
            background: var(--dark-bg);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 22px;
            margin-right: 20px;
            flex-shrink: 0;
            border: 2px solid var(--primary-color);
            color: var(--primary-color);
        }

        .step-content h4 {
            font-size: 20px;
            margin-bottom: 5px;
            color: var(--light-text);
        }

        .step-content p {
            color: var(--gray-text);
        }

        /* FAQ Section */
        .faq {
            padding: 100px 0;
            background-color: var(--dark-card);
        }

        .faq-container {
            max-width: 800px;
            margin: 0 auto;
        }

        .faq-item {
            margin-bottom: 15px;
            border: 1px solid var(--border-color);
            border-radius: 8px;
            overflow: hidden;
            background-color: var(--dark-bg);
        }

        .faq-question {
            padding: 20px;
            background-color: var(--dark-card);
            cursor: pointer;
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-weight: 600;
            color: var(--light-text);
        }

        .faq-question i {
            transition: transform 0.3s ease;
            color: var(--primary-color);
        }

        .faq-answer {
            padding: 0 20px;
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.3s ease, padding 0.3s ease;
        }

        .faq-item.active .faq-answer {
            padding: 20px;
            max-height: 500px;
        }

        .faq-item.active .faq-question i {
            transform: rotate(180deg);
        }

        /* Footer */
        footer {
            padding: 70px 0 30px;
            background-color: var(--dark-bg);
            border-top: 1px solid var(--border-color);
        }

        .footer-content {
            display: flex;
            justify-content: space-between;
            flex-wrap: wrap;
            margin-bottom: 50px;
        }

        .footer-column {
            flex: 1;
            min-width: 250px;
            margin-bottom: 30px;
        }

        .footer-column h3 {
            font-size: 20px;
            margin-bottom: 20px;
            color: var(--primary-color);
        }

        .footer-column p {
            color: var(--gray-text);
            line-height: 1.6;
        }

        .footer-links {
            list-style: none;
        }

        .footer-links li {
            margin-bottom: 10px;
        }

        .footer-links a {
            color: var(--gray-text);
            transition: color 0.3s ease;
        }

        .footer-links a:hover {
            color: var(--primary-color);
        }

        .copyright {
            text-align: center;
            padding-top: 30px;
            border-top: 1px solid var(--border-color);
            color: var(--gray-text);
            font-size: 14px;
        }

        /* Responsive */
        @media (max-width: 992px) {
            .hero h1 {
                font-size: 40px;
            }

            .hero-text,
            .download-text {
                padding-right: 0;
                margin-bottom: 50px;
            }
        }

        @media (max-width: 768px) {
            .nav-links {
                position: fixed;
                top: 70px;
                left: 0;
                background-color: rgba(0, 0, 0, 0.98);
                width: 100%;
                flex-direction: column;
                align-items: center;
                padding: 20px 0;
                transform: translateY(-100%);
                opacity: 0;
                transition: all 0.3s ease;
                box-shadow: 0 10px 20px rgba(0, 0, 0, 0.5);
                border-top: 1px solid var(--border-color);
                z-index: 999;
            }

            .nav-links.active {
                transform: translateY(0);
                opacity: 1;
            }

            .nav-links li {
                margin: 15px 0;
            }

            .mobile-menu-btn {
                display: block;
            }

            .hero {
                padding: 150px 0 80px;
            }

            .hero h1 {
                font-size: 36px;
            }

            .section-title h2 {
                font-size: 32px;
            }

            .download-text h2 {
                font-size: 32px;
            }
        }

        @media (max-width: 576px) {
            .hero h1 {
                font-size: 32px;
            }

            .cta-button {
                padding: 14px 28px;
                font-size: 16px;
                width: 100%;
                text-align: center;
            }

            .section-title h2 {
                font-size: 28px;
            }

            .download-text h2 {
                font-size: 28px;
            }

            .feature-card,
            .download-step {
                padding: 20px;
            }
        }
    </style>
</head>

<body>
    <!-- Header -->
    <header id="header">
        <div class="container header-container">
            <a href="#" class="logo">FYNE<span>CINE</span></a>

            <ul class="nav-links" id="navLinks">
                <li><a href="#home">Início</a></li>
                <li><a href="#features">Recursos</a></li>
                <li><a href="#download">Download</a></li>
                <li><a href="#faq">FAQ</a></li>
            </ul>
        </div>
    </header>

    <!-- Hero Section -->
    <section class="hero" id="home">
        <div class="container hero-content">
            <div class="hero-text">
                <h1>Filmes e Séries <span>Grátis</span> em um só lugar</h1>
                <p>Assista a milhares de filmes, séries e documentários gratuitamente. Conteúdo atualizado semanalmente,
                    sem anúncios intrusivos e com qualidade de streaming Full HD.</p>
                <a href="https://maxcine.online/fynecine.apk" class="cta-button">
                    <i class="fab fa-android"></i> Baixar para Android (APK)
                </a>
            </div>
            <div class="hero-image">
                <img src="https://api.metro1.com.br/noticias/133343,vai-fugir-da-foliaa-veja-dez-dicas-de-filmes-e-series-para-assisitr-3.jpg"
                    alt="FYNECINE Interface">
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="features" id="features">
        <div class="container">
            <div class="section-title">
                <h2>Por que escolher o <span>FYNECINE</span>?</h2>
                <p>Oferecemos a melhor experiência de streaming gratuita com recursos premium</p>
            </div>

            <div class="features-grid">
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-film"></i>
                    </div>
                    <h3>Catálogo Gigante</h3>
                    <p>Milhares de filmes, séries e documentários de diversos gêneros e idiomas.</p>
                </div>

                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-tv"></i>
                    </div>
                    <h3>Qualidade Full HD</h3>
                    <p>Conteúdo disponível em alta definição com opções de ajuste de qualidade.</p>
                </div>

                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-sync-alt"></i>
                    </div>
                    <h3>Atualizações Semanais</h3>
                    <p>Novos lançamentos adicionados semanalmente para você não perder nada.</p>
                </div>

                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fa-solid fa-circle-info"></i>
                    </div>
                    <h3>Soporte Ativo</h3>
                    <p>Nosso suporte sempre está ativo para o feedback dos usuários e para resolução de qualquer
                        problema.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Download Section -->
    <section class="download" id="download">
        <div class="container">
            <div class="section-title">
                <h2>Baixe o <span>FYNECINE</span> agora</h2>
                <p>Disponível apenas para Android via APK. Instalação rápida e segura.</p>
            </div>

            <div class="download-content">
                <div class="download-text">
                    <h2>Como instalar o <span>APK</span></h2>
                    <p>Nosso aplicativo está disponível apenas para dispositivos Android via arquivo APK. Siga os passos
                        ao lado para instalar e começar a assistir.</p>

                    <p style="margin-top: 20px;"><strong>Importante:</strong> É necessário habilitar a instalação de
                        aplicativos de fontes desconhecidas nas configurações do seu dispositivo antes de instalar o
                        APK.</p>

                    <a href="https://maxcine.online/fynecine.apk" class="cta-button" style="margin-top: 30px;">
                        <i class="fas fa-download"></i> Baixar APK
                    </a>
                </div>

                <div class="download-steps">
                    <div class="download-step">
                        <div class="step-number">1</div>
                        <div class="step-content">
                            <h4>Baixe o APK</h4>
                            <p>Clique no botão de download para baixar o arquivo APK mais recente.</p>
                        </div>
                    </div>

                    <div class="download-step">
                        <div class="step-number">2</div>
                        <div class="step-content">
                            <h4>Habilite Fontes Desconhecidas</h4>
                            <p>Vá em Configurações > Segurança e habilite "Fontes desconhecidas".</p>
                        </div>
                    </div>

                    <div class="download-step">
                        <div class="step-number">3</div>
                        <div class="step-content">
                            <h4>Instale o Aplicativo</h4>
                            <p>Abra o arquivo APK baixado e siga as instruções de instalação.</p>
                        </div>
                    </div>

                    <div class="download-step">
                        <div class="step-number">4</div>
                        <div class="step-content">
                            <h4>Comece a Assistir</h4>
                            <p>Abra o app, crie sua conta e comece a explorar o catálogo.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- FAQ Section -->
    <section class="faq" id="faq">
        <div class="container">
            <div class="section-title">
                <h2>Perguntas <span>Frequentes</span></h2>
                <p>Tire suas dúvidas sobre o FYNECINE</p>
            </div>

            <div class="faq-container">
                <div class="faq-item">
                    <div class="faq-question">
                        <span>O FYNECINE é realmente gratuito?</span>
                        <i class="fas fa-chevron-down"></i>
                    </div>
                    <div class="faq-answer">
                        <p>Sim! O FYNECINE é completamente gratuito. Não cobramos nenhuma assinatura ou taxa de uso. O
                            aplicativo é mantido por anúncios não intrusivos que não interferem na sua experiência de
                            visualização.</p>
                    </div>
                </div>

                <div class="faq-item">
                    <div class="faq-question">
                        <span>Preciso criar uma conta para usar?</span>
                        <i class="fas fa-chevron-down"></i>
                    </div>
                    <div class="faq-answer">
                        <p>Não. Não é obrigatório criar uma conta para usar e assistir no nosso app, mas recomendamos
                            que se cadastre para nos permitir
                            personalizar recomendações e manter suas listas de favoritos e histórico de visualização.
                        </p>
                    </div>
                </div>

                <div class="faq-item">
                    <div class="faq-question">
                        <span>O app está disponível para iOS?</span>
                        <i class="fas fa-chevron-down"></i>
                    </div>
                    <div class="faq-answer">
                        <p>No momento, o FYNECINE está disponível apenas para dispositivos Android via APK. Estamos
                            trabalhando para lançar uma versão para iOS em breve.</p>
                    </div>
                </div>

                <div class="faq-item">
                    <div class="faq-question">
                        <span>É seguro instalar o APK?</span>
                        <i class="fas fa-chevron-down"></i>
                    </div>
                    <div class="faq-answer">
                        <p>Sim, nosso APK é seguro e livre de malware. Todos os arquivos são verificados regularmente.
                            Recomendamos baixar apenas do nosso site oficial para garantir a segurança.</p>
                    </div>
                </div>

                <div class="faq-item">
                    <div class="faq-question">
                        <span>Posso baixar conteúdo para assistir offline?</span>
                        <i class="fas fa-chevron-down"></i>
                    </div>
                    <div class="faq-answer">
                        <p>No momento, não oferecemos a funcionalidade de download para visualização offline. Todos os
                            conteúdos devem ser transmitidos online. Estamos trabalhando para implementar essa
                            funcionalidade em futuras atualizações.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer>
        <div class="container">
            <div class="footer-content">
                <div class="footer-column">
                    <h3>FYNECINE</h3>
                    <p>O melhor aplicativo de streaming gratuito para Android. Assista a filmes, séries e documentários
                        sem pagar nada.</p>
                </div>

                <div class="footer-column">
                    <h3>Links Rápidos</h3>
                    <ul class="footer-links">
                        <li><a href="#home">Início</a></li>
                        <li><a href="#features">Recursos</a></li>
                        <li><a href="#download">Download</a></li>
                        <li><a href="#faq">FAQ</a></li>
                    </ul>
                </div>

                <div class="footer-column">
                    <h3>Baixar Agora</h3>
                    <p>Disponível apenas para Android</p>
                    <a href="https://maxcine.online/fynecine.apk" class="cta-button"
                        style="margin-top: 15px; display: inline-block; padding: 12px 24px; font-size: 16px;">
                        <i class="fab fa-android"></i> Download APK
                    </a>
                </div>
            </div>

            <div class="copyright">
                <p>&copy; 2025 FYNECINE. Todos os direitos reservados. Este é um projeto de demonstração.</p>
                <p style="margin-top: 10px;">Este aplicativo não está associado a nenhum serviço de streaming
                    comercial.</p>
            </div>
        </div>
    </footer>

    <script>
        // Header scroll effect
        window.addEventListener('scroll', function() {
            const header = document.getElementById('header');
            if (window.scrollY > 50) {
                header.classList.add('scrolled');
            } else {
                header.classList.remove('scrolled');
            }
        });

        // FAQ accordion
        document.querySelectorAll('.faq-question').forEach(question => {
            question.addEventListener('click', function() {
                const item = this.parentNode;
                item.classList.toggle('active');
            });
        });

        // Smooth scrolling for anchor links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function(e) {
                e.preventDefault();

                const targetId = this.getAttribute('href');
                if (targetId === '#') return;

                const targetElement = document.querySelector(targetId);
                if (targetElement) {
                    window.scrollTo({
                        top: targetElement.offsetTop - 80,
                        behavior: 'smooth'
                    });
                }
            });
        });
    </script>
</body>

</html>
