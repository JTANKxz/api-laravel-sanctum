@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
    <div class="mb-8">
        <h1 class="text-2xl font-bold mb-6">Dashboard</h1>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            <div class="bg-medium-gray rounded-xl shadow-lg p-6 card-hover animate-fadeIn">
                <div class="flex items-center">
                    <div class="bg-netflix-red p-3 rounded-full mr-4">
                        <i class="fas fa-film text-white text-xl"></i>
                    </div>
                    <div>
                        <p class="text-gray-400">Total de Filmes</p>
                        <p class="text-2xl font-bold">{{ $movieCount }}</p>
                    </div>
                </div>
                <div class="mt-4">
                    <div class="h-2 bg-dark-gray rounded-full">
                        <div class="h-2 bg-netflix-red rounded-full" style="width: 65%"></div>
                    </div>
                    <p class="text-xs text-gray-400 mt-2">+12% em relação ao mês passado</p>
                </div>
            </div>

            <div class="bg-medium-gray rounded-xl shadow-lg p-6 card-hover animate-fadeIn">
                <div class="flex items-center">
                    <div class="bg-netflix-red p-3 rounded-full mr-4">
                        <i class="fas fa-tv text-white text-xl"></i>
                    </div>
                    <div>
                        <p class="text-gray-400">Total de Séries</p>
                        <p class="text-2xl font-bold">{{ $serieCount }}</p>
                    </div>
                </div>
                <div class="mt-4">
                    <div class="h-2 bg-dark-gray rounded-full">
                        <div class="h-2 bg-netflix-red rounded-full" style="width: 45%"></div>
                    </div>
                    <p class="text-xs text-gray-400 mt-2">+8% em relação ao mês passado</p>
                </div>
            </div>

            <div class="bg-medium-gray rounded-xl shadow-lg p-6 card-hover animate-fadeIn">
                <div class="flex items-center">
                    <div class="bg-netflix-red p-3 rounded-full mr-4">
                        <i class="fas fa-users text-white text-xl"></i>
                    </div>
                    <div>
                        <p class="text-gray-400">Usuários Ativos</p>
                        <p class="text-2xl font-bold">{{ $userCount }}</p>
                    </div>
                </div>
                <div class="mt-4">
                    <div class="h-2 bg-dark-gray rounded-full">
                        <div class="h-2 bg-netflix-red rounded-full" style="width: 75%"></div>
                    </div>
                    <p class="text-xs text-gray-400 mt-2">+15% em relação ao mês passado</p>
                </div>
            </div>

            <div class="bg-medium-gray rounded-xl shadow-lg p-6 card-hover animate-fadeIn">
                <div class="flex items-center">
                    <div class="bg-netflix-red p-3 rounded-full mr-4">
                        <i class="fas fa-chart-line text-white text-xl"></i>
                    </div>
                    <div>
                        <p class="text-gray-400">Acessos Hoje</p>
                        <p class="text-2xl font-bold">2,345</p>
                    </div>
                </div>
                <div class="mt-4">
                    <div class="h-2 bg-dark-gray rounded-full">
                        <div class="h-2 bg-netflix-red rounded-full" style="width: 85%"></div>
                    </div>
                    <p class="text-xs text-gray-400 mt-2">+20% em relação a ontem</p>
                </div>
            </div>
        </div>
    </div>

    <div class="bg-medium-gray rounded-xl shadow-lg p-6 mb-8 animate-fadeIn">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-xl font-bold">Importação de Conteúdos via TMDB</h2>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
            <button
                class="btn-hover bg-netflix-red hover:bg-red-800 text-white py-3 px-4 rounded-lg flex items-center justify-center">
                <i class="fas fa-download mr-2"></i> Importar Filmes
            </button>
            <button
                class="btn-hover bg-netflix-red hover:bg-red-800 text-white py-3 px-4 rounded-lg flex items-center justify-center">
                <i class="fas fa-download mr-2"></i> Importar Séries
            </button>
            <button
                class="btn-hover bg-netflix-red hover:bg-red-800 text-white py-3 px-4 rounded-lg flex items-center justify-center">
                <i class="fas fa-download mr-2"></i> Importar Temporadas
            </button>
            <button
                class="btn-hover bg-netflix-red hover:bg-red-800 text-white py-3 px-4 rounded-lg flex items-center justify-center">
                <i class="fas fa-download mr-2"></i> Importar Episódios
            </button>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full">
                <thead>
                    <tr class="border-b border-dark-gray">
                        <th class="py-3 px-4 text-left">Imagem</th>
                        <th class="py-3 px-4 text-left">Título</th>
                        <th class="py-3 px-4 text-left">Tipo</th>
                        <th class="py-3 px-4 text-left">Avaliação</th>
                        <th class="py-3 px-4 text-left">Data</th>
                        <th class="py-3 px-4 text-left">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($media as $item)
                        <tr class="border-b border-dark-gray hover:bg-dark-gray">
                            <td class="py-3 px-4"><img src="{{ $item->poster_url }}" alt="{{ $item->title }}"
                                    class="rounded w-10 h-15"></td>
                            <td class="py-3 px-4 font-medium">{{ $item->title }}</td>
                            <td class="py-3 px-4"><span
                                    class="bg-netflix-red text-white px-2 py-1 rounded-full text-xs">{{ $item->content_type }}</span>
                            </td>
                            <td class="py-3 px-4">
                                <div class="flex items-center">
                                    <i class="fas fa-star text-yellow-400 mr-1"></i>
                                    <span>{{ $item->rating }}</span>
                                </div>
                            </td>
                            <td class="py-3 px-4 text-gray-400">{{ $item->year }}</td>
                            <td class="py-3 px-4">
                                <button class="text-blue-400 hover:text-blue-300 mr-2"><i class="fas fa-edit"></i></button>
                                <button class="text-red-400 hover:text-red-300"><i class="fas fa-trash"></i></button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
        <div class="bg-medium-gray rounded-xl shadow-lg p-6 animate-fadeIn">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-xl font-bold">Usuários</h2>
                <button class="btn-hover bg-netflix-red hover:bg-red-800 text-white py-2 px-4 rounded-lg flex items-center">
                    <i class="fas fa-plus mr-2"></i> Adicionar Novo
                </button>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full">
                    <thead>
                        <tr class="border-b border-dark-gray">
                            <th class="py-3 px-4 text-left">ID</th>
                            <th class="py-3 px-4 text-left">Usuário</th>
                            <th class="py-3 px-4 text-left">Email</th>
                            <!-- <th class="py-3 px-4 text-left">Plano</th>
                            <th class="py-3 px-4 text-left">Status</th> -->
                            <th class="py-3 px-4 text-left">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $user)
                            <tr class="border-b border-dark-gray hover:bg-dark-gray">
                                <td class="py-3 px-4 text-gray-400">{{ $user->id }}</td>
                                <td class="py-3 px-4">
                                    <div class="flex items-center">
                                        <img src="https://ui-avatars.com/api/?name={{ $user->name }}&background=random"
                                            alt="{{ $user->name }}" class="rounded-full w-8 h-8 mr-3">
                                        <span>{{ $user->name }}</span>
                                    </div>
                                </td>
                                <td class="py-3 px-4 text-gray-400">{{ $user->email }}</td>
                                <!-- <td class="py-3 px-4">
                                <span
                                    class="bg-yellow-500 text-black px-2 py-1 rounded-full text-xs">Premium</span>
                            </td>
                            <td class="py-3 px-4">
                                <span
                                    class="bg-green-500 text-white px-2 py-1 rounded-full text-xs">Ativo</span>
                            </td> -->
                                <td class="py-3 px-4">
                                    <button class="text-blue-400 hover:text-blue-300 mr-2"><i
                                            class="fas fa-eye"></i></button>
                                    <button class="text-gray-400 hover:text-gray-300"><i class="fas fa-edit"></i></button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <div class="bg-medium-gray rounded-xl shadow-lg p-6 animate-fadeIn">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-xl font-bold">Players de Vídeo</h2>
                <button
                    class="btn-hover bg-netflix-red hover:bg-red-800 text-white py-2 px-4 rounded-lg flex items-center">
                    <i class="fas fa-plus mr-2"></i> Novo Player
                </button>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full">
                    <thead>
                        <tr class="border-b border-dark-gray">
                            <th class="py-3 px-4 text-left">Nome</th>
                            <th class="py-3 px-4 text-left">Qualidade</th>
                            <th class="py-3 px-4 text-left">Tipo</th>
                            <th class="py-3 px-4 text-left">Status</th>
                            <th class="py-3 px-4 text-left">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="border-b border-dark-gray hover:bg-dark-gray">
                            <td class="py-3 px-4 font-medium">Player Principal</td>
                            <td class="py-3 px-4">
                                <span class="bg-green-500 text-white px-2 py-1 rounded-full text-xs">4K</span>
                            </td>
                            <td class="py-3 px-4">HLS</td>
                            <td class="py-3 px-4">
                                <span class="bg-green-500 text-white px-2 py-1 rounded-full text-xs">Online</span>
                            </td>
                            <td class="py-3 px-4">
                                <button class="text-green-400 hover:text-green-300 mr-2"><i
                                        class="fas fa-play-circle"></i></button>
                                <button class="text-blue-400 hover:text-blue-300 mr-2"><i
                                        class="fas fa-edit"></i></button>
                                <button class="text-red-400 hover:text-red-300"><i class="fas fa-trash"></i></button>
                            </td>
                        </tr>
                        <tr class="border-b border-dark-gray hover:bg-dark-gray">
                            <td class="py-3 px-4 font-medium">Backup Player</td>
                            <td class="py-3 px-4">
                                <span class="bg-yellow-500 text-black px-2 py-1 rounded-full text-xs">1080p</span>
                            </td>
                            <td class="py-3 px-4">MPEG-DASH</td>
                            <td class="py-3 px-4">
                                <span class="bg-green-500 text-white px-2 py-1 rounded-full text-xs">Online</span>
                            </td>
                            <td class="py-3 px-4">
                                <button class="text-green-400 hover:text-green-300 mr-2"><i
                                        class="fas fa-play-circle"></i></button>
                                <button class="text-blue-400 hover:text-blue-300 mr-2"><i
                                        class="fas fa-edit"></i></button>
                                <button class="text-red-400 hover:text-red-300"><i class="fas fa-trash"></i></button>
                            </td>
                        </tr>
                        <tr class="border-b border-dark-gray hover:bg-dark-gray">
                            <td class="py-3 px-4 font-medium">Mobile Player</td>
                            <td class="py-3 px-4">
                                <span class="bg-blue-500 text-white px-2 py-1 rounded-full text-xs">720p</span>
                            </td>
                            <td class="py-3 px-4">HLS</td>
                            <td class="py-3 px-4">
                                <span class="bg-red-500 text-white px-2 py-1 rounded-full text-xs">Offline</span>
                            </td>
                            <td class="py-3 px-4">
                                <button class="text-green-400 hover:text-green-300 mr-2"><i
                                        class="fas fa-play-circle"></i></button>
                                <button class="text-blue-400 hover:text-blue-300 mr-2"><i
                                        class="fas fa-edit"></i></button>
                                <button class="text-red-400 hover:text-red-300"><i class="fas fa-trash"></i></button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="mb-8">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-xl font-bold">Conteúdos em Destaque</h2>
            <div class="flex space-x-2">
                <button class="btn-hover bg-medium-gray hover:bg-light-gray text-white p-2 rounded-lg">
                    <i class="fas fa-filter"></i>
                </button>
                <button class="btn-hover bg-medium-gray hover:bg-light-gray text-white p-2 rounded-lg">
                    <i class="fas fa-sort"></i>
                </button>
            </div>
        </div>
        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-4">
            @foreach ($sliders as $slider)
                <div class="bg-light-gray rounded-xl shadow-lg overflow-hidden card-hover">
                    <div class="relative">
                        <img src="{{ $slider->backdrop_url }}" alt="{{ $slider->title }}"
                            class="w-full h-48 object-cover">
                        <div class="absolute top-2 right-2 bg-netflix-red text-white text-xs px-2 py-1 rounded">
                            {{ $slider->type }}</div>
                    </div>
                    <div class="p-4">
                        <h3 class="font-bold truncate">{{ $slider->title }}</h3>
                        <div class="flex justify-between items-center mt-2">
                            <span class="text-gray-400 text-sm">{{ $slider->year }}</span>
                            <div class="flex items-center">
                                <i class="fas fa-star text-yellow-400 mr-1"></i>
                                <span>{{ $slider->rating }}</span>
                            </div>
                        </div>
                        <div class="mt-4 flex justify-between">
                            {{-- <button class="text-green-400 hover:text-green-300"><i class="fas fa-play"></i></button>
                            <button class="text-blue-400 hover:text-blue-300"><i class="fas fa-edit"></i></button> --}}
                            <form action="{{ route('admin.deleteSlider', $slider->id) }}" method="POST"
                                onsubmit="return confirm('Tem certeza que deseja excluir este filme?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-500 hover:text-red-400">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <div class="bg-medium-gray rounded-xl shadow-lg p-6 animate-fadeIn">
        <h2 class="text-xl font-bold mb-6">Componentes de UI</h2>

        <div class="mb-8">
            <h3 class="text-lg font-bold mb-4">Botões</h3>
            <div class="flex flex-wrap gap-3">
                <button class="btn-hover bg-netflix-red hover:bg-red-800 text-white py-2 px-4 rounded">Primário</button>
                <button class="btn-hover bg-gray-700 hover:bg-gray-600 text-white py-2 px-4 rounded">Secundário</button>
                <button
                    class="btn-hover border border-netflix-red text-netflix-red hover:bg-red-900 hover:text-white py-2 px-4 rounded">Outline</button>
                <button
                    class="btn-hover text-netflix-red hover:bg-red-900 hover:text-white py-2 px-4 rounded">Ghost</button>
                <button class="btn-hover bg-netflix-red hover:bg-red-800 text-white py-2 px-4 rounded flex items-center">
                    <i class="fas fa-plus mr-2"></i> Com Ícone
                </button>
                <button class="btn-hover bg-gray-700 hover:bg-gray-600 text-white py-2 px-4 rounded flex items-center">
                    <i class="fas fa-cog mr-2"></i> Configurações
                </button>
            </div>
        </div>

        <div class="mb-8">
            <h3 class="text-lg font-bold mb-4">Alertas</h3>
            <div class="space-y-4">
                <div class="bg-green-900 text-green-300 p-4 rounded-lg">Sucesso: Operação realizada com
                    sucesso.</div>
                <div class="bg-red-900 text-red-300 p-4 rounded-lg">Erro: Ocorreu um problema na operação.
                </div>
                <div class="bg-yellow-900 text-yellow-300 p-4 rounded-lg">Aviso: Atenção necessária para
                    esta ação.</div>
                <div class="bg-blue-900 text-blue-300 p-4 rounded-lg">Informação: Detalhes importantes sobre
                    o sistema.</div>
            </div>
        </div>

        <div class="mb-8">
            <h3 class="text-lg font-bold mb-4">Badges/Tags</h3>
            <div class="flex flex-wrap gap-2">
                <span class="bg-netflix-red text-white px-3 py-1 rounded-full">Premium</span>
                <span class="bg-yellow-500 text-black px-3 py-1 rounded-full">Novo</span>
                <span class="bg-purple-500 text-white px-3 py-1 rounded-full">Em Alta</span>
                <span class="bg-blue-500 text-white px-3 py-1 rounded-full">Em Produção</span>
                <span class="bg-green-500 text-white px-3 py-1 rounded-full">Ativo</span>
                <span class="bg-red-500 text-white px-3 py-1 rounded-full">Inativo</span>
            </div>
        </div>

        <div>
            <h3 class="text-lg font-bold mb-4">Formulários</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-gray-400 mb-2">Nome</label>
                    <input type="text"
                        class="w-full bg-dark-gray border border-gray-700 rounded-lg py-2 px-4 focus:outline-none focus:ring-2 focus:ring-netflix-red"
                        placeholder="Digite seu nome">
                </div>
                <div>
                    <label class="block text-gray-400 mb-2">Email</label>
                    <input type="email"
                        class="w-full bg-dark-gray border border-gray-700 rounded-lg py-2 px-4 focus:outline-none focus:ring-2 focus:ring-netflix-red"
                        placeholder="email@exemplo.com">
                </div>
                <div>
                    <label class="block text-gray-400 mb-2">Plano</label>
                    <select
                        class="w-full bg-dark-gray border border-gray-700 rounded-lg py-2 px-4 focus:outline-none focus:ring-2 focus:ring-netflix-red">
                        <option>Selecione um plano</option>
                        <option>Básico</option>
                        <option>Padrão</option>
                        <option>Premium</option>
                    </select>
                </div>
                <div>
                    <label class="block text-gray-400 mb-2">Categoria</label>
                    <select
                        class="w-full bg-dark-gray border border-gray-700 rounded-lg py-2 px-4 focus:outline-none focus:ring-2 focus:ring-netflix-red">
                        <option>Selecione uma categoria</option>
                        <option>Filmes</option>
                        <option>Séries</option>
                        <option>Documentários</option>
                    </select>
                </div>
                <div class="flex items-center">
                    <input type="checkbox"
                        class="h-5 w-5 text-netflix-red focus:ring-netflix-red border-gray-700 rounded">
                    <label class="ml-2 text-gray-400">Manter conectado</label>
                </div>
                <div class="flex items-center">
                    <div class="relative inline-block w-10 mr-2 align-middle select-none">
                        <input type="checkbox" id="toggle" class="sr-only">
                        <div class="block bg-gray-700 w-10 h-6 rounded-full"></div>
                        <div class="dot absolute left-1 top-1 bg-gray-400 w-4 h-4 rounded-full transition">
                        </div>
                    </div>
                    <label for="toggle" class="text-gray-400">Modo noturno</label>
                </div>
                <div class="md:col-span-2 flex justify-end space-x-3">
                    <button class="btn-hover bg-gray-700 hover:bg-gray-600 text-white py-2 px-6 rounded">Cancelar</button>
                    <button class="btn-hover bg-netflix-red hover:bg-red-800 text-white py-2 px-6 rounded">Salvar</button>
                </div>
            </div>
        </div>
    </div>
@endsection
