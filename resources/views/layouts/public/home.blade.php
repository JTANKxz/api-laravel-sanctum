@extends('layouts.public.app')

@section('title', 'MaxCine - Início')

@section('styles')

    <style>
        /* Slides Section */
        .slides-section {
            margin-bottom: 40px;
            position: relative;
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

        .see-all-btn i {
            margin-left: 5px;
        }

        /* Slider */
        .slides-container {
            position: relative;
            width: 100%;
            margin: 0 auto;
            aspect-ratio: 16 / 9;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.7);
        }

        .slides-wrapper {
            display: flex;
            width: 100%;
            height: 100%;
            transition: transform 0.7s cubic-bezier(0.25, 0.46, 0.45, 0.94);
        }

        .slide {
            min-width: 100%;
            height: 100%;
            position: relative;
            display: flex;
            justify-content: center;
            align-items: center;
            background-color: #000;
        }

        .slide img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.5s ease;
            display: block;
        }

        .slide:hover img {
            transform: scale(1.02);
        }

        /* Progress Bar */
        .progressBar {
            position: absolute;
            bottom: 0;
            left: 0;
            height: 5px;
            background-color: var(--primary-color);
            width: 0;
            transition: width 5s linear;
            z-index: 5;
        }

        /* Indicators */
        .indicators {
            display: flex;
            justify-content: center;
            margin-top: 20px;
            gap: 10px;
        }

        .indicator {
            width: 10px;
            height: 10px;
            background-color: #555;
            border-radius: 50%;
            cursor: pointer;
            transition: all 0.3s;
            border: 2px solid transparent;
        }

        .indicator.active {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
            transform: scale(1.2);
        }

        .indicator:hover {
            background-color: var(--hover-color);
        }

        /* Slide Info */
        .slide-info {
            position: absolute;
            bottom: 30px;
            left: 30px;
            max-width: 50%;
            background: rgba(0, 0, 0, 0.144);
            padding: 20px;
            border-radius: 10px;
            backdrop-filter: blur(1px);
            z-index: 4;
        }

        .slide-title {
            font-size: 28px;
            font-weight: 700;
            margin-bottom: 10px;
            color: var(--primary-color);
        }

        .slide-meta {
            display: flex;
            align-items: center;
            gap: 15px;
            margin-bottom: 10px;
            color: var(--light-text-color);
            font-size: 14px;
        }

        .slide-rating {
            color: #f5c518;
            font-weight: 600;
            display: flex;
            align-items: center;
        }

        .slide-rating i {
            margin-right: 5px;
        }

        .slide-year,
        .slide-type {
            background-color: rgba(255, 255, 255, 0.1);
            padding: 3px 8px;
            border-radius: 5px;
            font-weight: 600;
        }

        .slide-button {
            display: inline-block;
            text-decoration: none;
            color: var(--text-color);
            font-size: 16px;
            background-color: var(--primary-color);
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            font-weight: 600;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .slide-button:hover {
            background-color: var(--hover-color);
        }

        /* Seção Gêneros */
        .genres-section {
            margin-bottom: 40px;
        }

        .genres-container {
            display: flex;
            flex-wrap: nowrap;
            overflow-x: auto;
            gap: 15px;
            padding-bottom: 10px;
        }

        .genre-card {
            background-color: transparent;
            border: 1px solid rgba(160, 82, 224, 0.5);
            border-radius: 50px;
            padding: 10px 25px;
            color: var(--text-color);
            text-align: center;
            text-decoration: none;
            font-weight: 600;
            font-size: 16px;
            transition: background-color 0.3s ease, transform 0.3s ease, border-color 0.3s ease;
            white-space: nowrap;
        }

        .genre-card:hover {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
            transform: scale(1.05);
        }

        /* Horizontal Scroll Sections */
        .movies-section,
        .series-section {
            margin-bottom: 40px;
        }

        .movies-container,
        .series-container {
            display: flex;
            overflow-x: auto;
            scroll-behavior: smooth;
            padding: 10px;
        }

        .genres-container::-webkit-scrollbar,
        .movies-container::-webkit-scrollbar,
        .series-container::-webkit-scrollbar {
            height: 8px;
        }

        .genres-container::-webkit-scrollbar-thumb,
        .movies-container::-webkit-scrollbar-thumb,
        .series-container::-webkit-scrollbar-thumb {
            background-color: var(--scrollbar-color);
            border-radius: 10px;
        }

        .genres-container::-webkit-scrollbar-track,
        .movies-container::-webkit-scrollbar-track,
        .series-container::-webkit-scrollbar-track {
            background-color: #333;
        }

        .movie-card,
        .series-card {
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

        .movie-card:hover,
        .series-card:hover {
            transform: scale(1.05);
            z-index: 2;
            border: 1px solid var(--primary-color);
        }

        .movie-card img,
        .series-card img {
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

        .movie-title,
        .series-title {
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

        /* ===== RESPONSIVIDADE ===== */

        /* Tablets (768px pra baixo) */
        @media (max-width: 768px) {

            .section-title {
                font-size: 22px;
            }

            .slides-container {
                aspect-ratio: 16/9;
            }

            .slide-info {
                max-width: 70%;
                padding: 15px;
                bottom: 20px;
                left: 20px;
            }

            .slide-title {
                font-size: 22px;
            }

            .slide-meta {
                font-size: 13px;
                gap: 10px;
            }

            .movie-card,
            .series-card {
                min-width: 160px;
                height: 240px;
                margin-right: 15px;
            }

            .genre-card {
                padding: 8px 20px;
                font-size: 15px;
            }
        }

        /* Celulares grandes (480px pra baixo) */
        @media (max-width: 480px) {
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

            .slides-container {
                aspect-ratio: 16/9;
                border-radius: 8px;
            }

            .slide-info {
                max-width: 85%;
                padding: 10px;
                bottom: 15px;
                left: 15px;
            }

            .slide-title {
                font-size: 16px;
                margin-bottom: 5px;
            }

            .slide-meta {
                font-size: 11px;
                gap: 8px;
                margin-bottom: 8px;
            }

            .slide-button {
                padding: 8px 15px;
                font-size: 12px;
            }

            .indicators {
                margin-top: 15px;
                gap: 8px;
            }

            .indicator {
                width: 8px;
                height: 8px;
            }

            .movie-card,
            .series-card {
                min-width: 120px;
                height: 180px;
                margin-right: 12px;
            }

            .movie-title,
            .series-title {
                font-size: 14px;
            }

            .rating {
                font-size: 12px;
                padding: 3px 8px;
            }

            .genre-card {
                padding: 6px 15px;
                font-size: 13px;
                min-width: 70px;
            }
        }

        /* Celulares pequenos (360px pra baixo) */
        @media (max-width: 360px) {

            .slides-container {
                aspect-ratio: 16/9;
            }

            .slide-info {
                max-width: 90%;
                padding: 8px;
                bottom: 10px;
                left: 10px;
            }

            .slide-title {
                font-size: 12px;
            }

            .slide-meta {
                flex-wrap: wrap;
                gap: 5px;
            }

            .movie-card,
            .series-card {
                min-width: 100px;
                height: 150px;
                margin-right: 10px;
            }

            .movie-title,
            .series-title {
                font-size: 12px;
            }

            .genre-card {
                padding: 5px 12px;
                font-size: 12px;
                min-width: 60px;
            }
        }
    </style>
@endsection

@section('content')
    {{-- Aqui fica TODO o conteúdo real da home --}}
@endsection

@section('scripts')
    <script>
        // Slider Functionality
        let currentSlide = 0;
        const slidesWrapper = document.querySelector('.slides-wrapper');
        const slides = document.querySelectorAll('.slide');
        const totalSlides = slides.length;
        const progressBar = document.querySelector('.progressBar');
        const indicatorsContainer = document.querySelector('.indicators');
        let slideshowInterval;

        // Create indicators
        for (let i = 0; i < totalSlides; i++) {
            const indicator = document.createElement('div');
            indicator.classList.add('indicator');
            if (i === 0) indicator.classList.add('active');
            indicator.addEventListener('click', () => goToSlide(i));
            indicatorsContainer.appendChild(indicator);
        }

        const indicators = document.querySelectorAll('.indicator');

        // Function to go to a specific slide
        function goToSlide(index) {
            currentSlide = index;
            updateSlider();
            resetProgressBar();
            startSlideShow();
        }

        // Function to update slider position
        function updateSlider() {
            slidesWrapper.style.transform = `translateX(-${currentSlide * 100}%)`;

            // Update indicators
            indicators.forEach((indicator, i) => {
                indicator.classList.toggle('active', i === currentSlide);
            });
        }

        // Function to reset and restart progress bar
        function resetProgressBar() {
            progressBar.style.transition = 'none';
            progressBar.style.width = '0';
            setTimeout(() => {
                progressBar.style.transition = 'width 5s linear';
                progressBar.style.width = '100%';
            }, 50);
        }

        // Function to start slideshow
        function startSlideShow() {
            clearInterval(slideshowInterval);
            slideshowInterval = setInterval(() => {
                currentSlide = (currentSlide + 1) % totalSlides;
                updateSlider();
                resetProgressBar();
            }, 5000);
        }

        // Touch and drag navigation
        let startX = 0;
        let isDragging = false;

        slidesWrapper.addEventListener('touchstart', (e) => {
            startX = e.touches[0].clientX;
            isDragging = true;
            clearInterval(slideshowInterval);
        });

        slidesWrapper.addEventListener('touchmove', (e) => {
            if (!isDragging) return;
            const currentX = e.touches[0].clientX;
            const deltaX = currentX - startX;

            if (Math.abs(deltaX) > 50) {
                if (deltaX > 0) {
                    currentSlide = (currentSlide - 1 + totalSlides) % totalSlides;
                } else {
                    currentSlide = (currentSlide + 1) % totalSlides;
                }
                goToSlide(currentSlide);
                isDragging = false;
            }
        });

        slidesWrapper.addEventListener('touchend', () => {
            isDragging = false;
            startSlideShow();
        });

        // Initialize slideshow
        updateSlider();
        resetProgressBar();
        startSlideShow();
    </script>
@endsection
