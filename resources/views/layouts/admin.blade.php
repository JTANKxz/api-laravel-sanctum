<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MAXSTREAM - Dashboard</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'amoled': '#000000',
                        'netflix-red': '#E50914',
                        'dark-gray': '#121212',
                        'medium-gray': '#1a1a1a',
                        'light-gray': '#242424'
                    },
                    animation: {
                        'pulse-slow': 'pulse 3s cubic-bezier(0.4, 0, 0.6, 1) infinite'
                    }
                }
            }
        }
    </script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');

        body {
            font-family: 'Inter', sans-serif;
            background-color: #000;
            color: #e5e5e5;
            overflow-x: hidden;
        }

        /* Scrollbar personalizada */
        ::-webkit-scrollbar {
            width: 8px;
            height: 8px;
        }

        ::-webkit-scrollbar-track {
            background: #121212;
        }

        ::-webkit-scrollbar-thumb {
            background: #333;
            border-radius: 4px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: #444;
        }

        /* Animações */
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animate-fadeIn {
            animation: fadeIn 0.3s ease-out forwards;
        }

        .sidebar-item {
            transition: all 0.2s ease;
        }

        .sidebar-item:hover {
            background: rgba(229, 9, 20, 0.1);
        }

        .card-hover {
            transition: all 0.2s ease;
        }

        .card-hover:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(229, 9, 20, 0.1);
        }

        .btn-hover {
            transition: all 0.2s ease;
        }

        .btn-hover:hover {
            transform: translateY(-2px);
        }

        .notification-badge {
            position: absolute;
            top: -5px;
            right: -5px;
        }

        /* Responsividade e Menu */
        #sidebar {
            transform: translateX(-100%);
            transition: transform 0.3s ease-in-out;
            z-index: 50;
        }

        #sidebar.open {
            transform: translateX(0);
        }

        .overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 40;
            opacity: 0;
            visibility: hidden;
            transition: opacity 0.3s ease-in-out, visibility 0.3s ease-in-out;
        }

        .overlay.open {
            opacity: 1;
            visibility: visible;
        }

        .submenu {
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.3s ease-in-out;
        }

        .submenu.open {
            max-height: 200px;
        }
    </style>
</head>

<body class="bg-amoled">
    <div class="flex h-screen overflow-hidden">
        <div id="overlay" class="overlay"></div>
        <aside id="sidebar" class="bg-dark-gray w-64 flex-shrink-0 fixed inset-y-0 left-0 flex flex-col">
            <div class="p-4 border-b border-medium-gray flex items-center justify-between">
                <div class="flex items-center">
                    <div class="text-netflix-red text-2xl">
                        <i class="fas fa-play-circle"></i>
                    </div>
                    <span class="logo-text ml-3 text-xl font-bold whitespace-nowrap">StreamFlix Admin</span>
                </div>
                <button id="closeSidebar" class="text-gray-300 text-2xl">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="flex-1 overflow-y-auto py-4">
                <nav>
                    <a href="{{ route('admin.dashboard') }}" class="sidebar-item flex items-center p-4 text-gray-300 hover:text-white">
                        <i class="fas fa-home text-netflix-red w-6"></i>
                        <span class="sidebar-label ml-4">Dashboard</span>
                    </a>
                    <div class="group">
                        <button
                            class="sidebar-item flex items-center justify-between w-full p-4 text-gray-300 hover:text-white submenu-btn">
                            <div class="flex items-center">
                                <i class="fas fa-film text-netflix-red w-6"></i>
                                <span class="sidebar-label ml-4">Conteúdos</span>
                            </div>
                            <i class="fas fa-chevron-down text-sm transition-transform duration-300"></i>
                        </button>
                        <ul class="submenu bg-light-gray ml-4 rounded-md">
                            <li><a href="{{ route('admin.movies.index') }}"
                                    class="block px-8 py-2 text-gray-300 hover:bg-dark-gray hover:text-white">Filmes</a>
                            </li>
                            <li><a href="{{ route('admin.series.index') }}"
                                    class="block px-8 py-2 text-gray-300 hover:bg-dark-gray hover:text-white">Séries</a>
                            </li>
                        </ul>
                    </div>
                    <div class="group">
                        <button
                            class="sidebar-item flex items-center justify-between w-full p-4 text-gray-300 hover:text-white submenu-btn">
                            <div class="flex items-center">
                                <i class="fas fa-cog text-netflix-red w-6"></i>
                                <span class="sidebar-label ml-4">App Config</span>
                            </div>
                            <i class="fas fa-chevron-down text-sm transition-transform duration-300"></i>
                        </button>
                        <ul class="submenu bg-light-gray ml-4 rounded-md">
                            <li><a href="{{ route('admin.sections.index') }}"
                                    class="block px-8 py-2 text-gray-300 hover:bg-dark-gray hover:text-white">Custom Home</a>
                            </li>
                            <li><a href="{{ route('admin.sliders.index') }}"
                                    class="block px-8 py-2 text-gray-300 hover:bg-dark-gray hover:text-white">Sliders</a>
                            </li>
                            <li><a href="{{ route('admin.networks.index') }}"
                                    class="block px-8 py-2 text-gray-300 hover:bg-dark-gray hover:text-white">Networks</a>
                            </li>
                            <li><a href="{{ route('admin.explore.index') }}"
                                    class="block px-8 py-2 text-gray-300 hover:bg-dark-gray hover:text-white">App Explore Section</a>
                            </li>
                        </ul>
                    </div>
                    <a href="{{ route('admin.tv.index') }}" class="sidebar-item flex items-center p-4 text-gray-300 hover:text-white">
                        <i class="fa-solid fa-tv text-netflix-red w-6"></i>
                        <span class="sidebar-label ml-4">TV Channels</span>
                    </a>
                    <a href="{{ route('admin.notifications.create') }}" class="sidebar-item flex items-center p-4 text-gray-300 hover:text-white">
                        <i class="fas fa-bell text-netflix-red w-6"></i>
                        <span class="sidebar-label ml-4">Notificações</span>
                    </a>
                    <a href="{{ route('admin.users.index') }}" class="sidebar-item flex items-center p-4 text-gray-300 hover:text-white">
                        <i class="fas fa-users text-netflix-red w-6"></i>
                        <span class="sidebar-label ml-4">Usuários</span>
                    </a>
                    <a href="{{ route('admin.payments.index') }}" class="sidebar-item flex items-center p-4 text-gray-300 hover:text-white">
                        <i class="fa-regular fa-money-bill-1 text-netflix-red w-6"></i>
                        <span class="sidebar-label ml-4">Payments Status</span>
                    </a>
                    <a href="{{ route('admin.subscriptions.index') }}" class="sidebar-item flex items-center p-4 text-gray-300 hover:text-white">
                        <i class="fas fa-credit-card text-netflix-red w-6"></i>
                        <span class="sidebar-label ml-4">Assinaturas</span>
                    </a>
                    <a href="{{ route('admin.tmdb.index') }}" class="sidebar-item flex items-center p-4 text-gray-300 hover:text-white">
                        <i class="fas fa-database text-netflix-red w-6"></i>
                        <span class="sidebar-label ml-4">TMDb</span>
                    </a>
                    <a href="{{ route('admin.coupans.index')}}" class="sidebar-item flex items-center p-4 text-gray-300 hover:text-white">
                        <i class="fa-solid fa-ticket text-netflix-red w-6"></i>
                        <span class="sidebar-label ml-4">Codigos de resgate</span>
                    </a>
                    <a href="{{ route('admin.config.index') }}" class="sidebar-item flex items-center p-4 text-gray-300 hover:text-white">
                        <i class="fas fa-cog text-netflix-red w-6"></i>
                        <span class="sidebar-label ml-4">Configurações</span>
                    </a>
                </nav>
            </div>
            <div class="p-4 border-t border-medium-gray">
                <div class="flex items-center">
                    <img src="https://ui-avatars.com/api/?name=Admin&background=E50914&color=fff" alt="Admin"
                        class="rounded-full w-10 h-10">
                    <div class="ml-3 sidebar-label">
                        <p class="font-medium">Administrador</p>
                        <p class="text-xs text-gray-400">admin@streamflix.com</p>
                    </div>
                </div>
            </div>
        </aside>

        <div class="flex-1 flex flex-col overflow-hidden">
            <header class="bg-dark-gray border-b border-medium-gray p-4 flex items-center justify-between">
                <div class="flex items-center">
                    <button id="openSidebar" class="mr-4 text-gray-300 text-2xl">
                        <i class="fas fa-bars"></i>
                    </button>
                    <div class="relative">
                        <input type="text" placeholder="Pesquisar..."
                            class="bg-medium-gray text-white rounded-full py-2 px-4 pl-10 w-64 focus:outline-none focus:ring-2 focus:ring-netflix-red">
                        <i class="fas fa-search absolute left-3 top-3 text-gray-400"></i>
                    </div>
                </div>
                <div class="flex items-center space-x-4">
                    <button class="relative p-2 rounded-full hover:bg-medium-gray">
                        <i class="fas fa-bell"></i>
                        <span
                            class="notification-badge bg-netflix-red text-white text-xs rounded-full h-5 w-5 flex items-center justify-center">3</span>
                    </button>
                    <div class="flex items-center">
                        <img src="https://ui-avatars.com/api/?name=Admin&background=E50914&color=fff" alt="Admin"
                            class="rounded-full h-10 w-10">
                        <span class="ml-2 hidden md:inline">Admin</span>
                    </div>
                </div>
            </header>

            <main class="flex-1 overflow-y-auto p-4 md:p-6">
                @yield('content')
            </main>
        </div>
    </div>

    <div id="confirmationModal"
        class="fixed inset-0 bg-black bg-opacity-75 flex items-center justify-center z-50 hidden">
        <div class="bg-medium-gray rounded-xl shadow-xl w-full max-w-md p-6 animate-fadeIn">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-xl font-bold">Confirmar Exclusão</h3>
                <button id="closeModal" class="text-gray-400 hover:text-white">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <p class="mb-6">Tem certeza que deseja excluir este item? Esta ação não pode ser desfeita.</p>
            <div class="flex justify-end space-x-3">
                <button id="cancelModal"
                    class="btn-hover bg-gray-700 hover:bg-gray-600 text-white py-2 px-6 rounded">Cancelar</button>
                <button class="btn-hover bg-red-600 hover:bg-red-700 text-white py-2 px-6 rounded">Excluir</button>
            </div>
        </div>
    </div>

    <script>
        // Toggle sidebar em dispositivos móveis
        const sidebar = document.getElementById('sidebar');
        const openSidebarBtn = document.getElementById('openSidebar');
        const closeSidebarBtn = document.getElementById('closeSidebar');
        const overlay = document.getElementById('overlay');

        function openSidebar() {
            sidebar.classList.add('open');
            overlay.classList.add('open');
        }

        function closeSidebar() {
            sidebar.classList.remove('open');
            overlay.classList.remove('open');
        }

        openSidebarBtn.addEventListener('click', openSidebar);
        closeSidebarBtn.addEventListener('click', closeSidebar);
        overlay.addEventListener('click', closeSidebar);

        // Toggle submenus
        document.querySelectorAll('.submenu-btn').forEach(button => {
            button.addEventListener('click', () => {
                const submenu = button.nextElementSibling;
                const icon = button.querySelector('.fa-chevron-down');

                submenu.classList.toggle('open');
                icon.classList.toggle('rotate-180');
            });
        });

        // Modal de confirmação
        const confirmationModal = document.getElementById('confirmationModal');
        const closeModal = document.getElementById('closeModal');
        const cancelModal = document.getElementById('cancelModal');

        // Exemplo de como abrir o modal (em um sistema real, você adicionaria isso aos botões de exclusão)
        function openConfirmationModal() {
            confirmationModal.classList.remove('hidden');
        }

        closeModal.addEventListener('click', function() {
            confirmationModal.classList.add('hidden');
        });

        cancelModal.addEventListener('click', function() {
            confirmationModal.classList.add('hidden');
        });

        // Fechar modal ao clicar fora
        window.addEventListener('click', function(event) {
            if (event.target === confirmationModal) {
                confirmationModal.classList.add('hidden');
            }
        });

        // Simular animações de entrada
        document.querySelectorAll('.animate-fadeIn').forEach((el, index) => {
            el.style.animationDelay = `${index * 0.1}s`;
        });
    </script>
</body>

</html>