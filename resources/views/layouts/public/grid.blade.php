@extends('layouts.public.app')

@section('styles')
    <style>
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

        /* Grid Section */
        .grid-section {
            margin-bottom: 40px;
        }

        .grid-container {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
            gap: 20px;
            padding: 10px 0;
        }

        /* Cards */
        .content-card {
            position: relative;
            border-radius: 12px;
            overflow: hidden;
            background-color: var(--secondary-color);
            box-shadow: 0 4px 15px var(--shadow-color);
            cursor: pointer;
            border: 1px solid rgba(140, 0, 255, 0.4);
            transition: transform 0.4s ease, box-shadow 0.4s ease, border 0.3s ease;
            aspect-ratio: 2/3;
        }

        .content-card:hover {
            transform: scale(1.05);
            z-index: 2;
            border: 1px solid var(--primary-color);
        }

        .content-card img {
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

        .content-title {
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

        /* Pagination Styles */
        .pagination {
            display: flex;
            justify-content: center;
            align-items: center;
            margin-top: 40px;
            gap: 10px;
            flex-wrap: wrap;
        }

        .pagination .page-item {
            list-style: none;
            margin: 0;
        }

        .pagination .page-link {
            display: flex;
            align-items: center;
            justify-content: center;
            min-width: 40px;
            height: 40px;
            padding: 0 15px;
            background-color: var(--secondary-color);
            color: var(--text-color);
            text-decoration: none;
            border: 1px solid rgba(140, 0, 255, 0.4);
            border-radius: 8px;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .pagination .page-link:hover {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
            transform: translateY(-2px);
        }

        .pagination .page-item.active .page-link {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
        }

        .pagination .page-item.disabled .page-link {
            background-color: #333;
            color: #666;
            cursor: not-allowed;
            opacity: 0.6;
        }

        .pagination .page-item.disabled .page-link:hover {
            transform: none;
            background-color: #333;
            border-color: rgba(140, 0, 255, 0.4);
        }

        /* ===== RESPONSIVIDADE ===== */

        /* Tablets (768px pra baixo) */
        @media (max-width: 768px) {
            .grid-container {
                grid-template-columns: repeat(auto-fill, minmax(130px, 1fr));
                gap: 15px;
            }

            .pagination {
                gap: 8px;
            }

            .pagination .page-link {
                min-width: 36px;
                height: 36px;
                padding: 0 12px;
                font-size: 14px;
            }
        }

        /* Celulares grandes (480px pra baixo) */
        @media (max-width: 480px) {
            .main {
                padding: 10px;
            }

            .section-header {
                margin-bottom: 15px;
            }

            .section-title {
                font-size: 20px;
            }

            .grid-container {
                grid-template-columns: repeat(auto-fill, minmax(110px, 1fr));
                gap: 12px;
            }

            .content-title {
                font-size: 14px;
            }

            .rating {
                font-size: 12px;
                padding: 3px 8px;
            }

            .pagination {
                margin-top: 30px;
                gap: 5px;
            }

            .pagination .page-link {
                min-width: 32px;
                height: 32px;
                padding: 0 10px;
                font-size: 13px;
            }
        }

        /* Celulares pequenos (360px pra baixo) */
        @media (max-width: 360px) {
            .grid-container {
                grid-template-columns: repeat(auto-fill, minmax(90px, 1fr));
                gap: 10px;
            }

            .content-title {
                font-size: 12px;
            }

            .pagination .page-link {
                min-width: 28px;
                height: 28px;
                padding: 0 8px;
                font-size: 12px;
            }
        }
    </style>
@endsection
