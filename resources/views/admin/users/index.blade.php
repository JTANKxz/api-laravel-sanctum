@extends('layouts.admin')

@section('title', 'Users')

@section('content')

<div class="mb-8">
    <h1 class="text-2xl font-bold mb-6">List Users</h1>
    <x-alert />

    <div class="bg-medium-gray rounded-xl shadow-lg p-6 animate-fadeIn w-full">

        {{-- TOPO: search + filtros + botão adicionar --}}
        <div class="flex flex-wrap justify-between items-center mb-6">

            {{-- Search --}}
            <form method="GET" class="flex items-center w-full md:w-1/3 mb-4 md:mb-0">
                <input type="text"
                    name="search"
                    value="{{ request('search') }}"
                    placeholder="Pesquisar usuário..."
                    class="w-full bg-dark-gray border border-gray-700 rounded-lg py-2 px-4 text-white">
            </form>

            {{-- Filtros --}}
            <div class="relative">
                <button onclick="document.getElementById('filterBox').classList.toggle('hidden')"
                    class="bg-gray-700 hover:bg-gray-600 text-white py-2 px-4 rounded flex items-center">
                    <i class="fas fa-filter mr-2"></i> Filtros
                </button>

                <div id="filterBox"
                     class="hidden absolute right-0 mt-2 w-48 bg-dark-gray shadow-xl border border-gray-700 rounded-lg z-50">

                    <a href="?filter=with_plan"
                       class="block px-4 py-2 hover:bg-gray-700 text-white">Com plano</a>

                    <a href="?filter=without_plan"
                       class="block px-4 py-2 hover:bg-gray-700 text-white">Sem plano</a>

                    <a href="?filter=active"
                       class="block px-4 py-2 hover:bg-gray-700 text-white">Assinaturas ativas</a>

                    <a href="?filter=expired"
                       class="block px-4 py-2 hover:bg-gray-700 text-white">Assinaturas expiradas</a>

                    <a href="?filter=admin"
                       class="block px-4 py-2 hover:bg-gray-700 text-white">Admins</a>

                    <a href="?filter=user"
                       class="block px-4 py-2 hover:bg-gray-700 text-white">Users</a>

                    <a href="{{ route('admin.users.index') }}"
                       class="block px-4 py-2 hover:bg-gray-700 text-gray-300">Limpar filtros</a>
                </div>
            </div>

            {{-- Botão Adicionar --}}
            <a href="#"
                class="btn-hover bg-netflix-red hover:bg-red-800 text-white py-2 px-4 rounded-lg flex items-center">
                <i class="fas fa-plus mr-2"></i> Adicionar Novo
            </a>
        </div>

        {{-- TABELA --}}
        <div class="overflow-x-auto">
            <table class="min-w-full">
                <thead>
                    <tr class="border-b border-dark-gray">
                        <th class="py-3 px-4 text-left">ID</th>
                        <th class="py-3 px-4 text-left">Name</th>
                        <th class="py-3 px-4 text-left">Email</th>
                        <th class="py-3 px-4 text-left">Plano</th>
                        <th class="py-3 px-4 text-left">Status</th>
                        <th class="py-3 px-4 text-left">Ações</th>
                    </tr>
                </thead>
                <tbody>

                    @foreach($users as $user)
                    <tr class="border-b border-dark-gray hover:bg-dark-gray">
                        <td class="py-3 px-4 text-gray-400">{{ $user->id }}</td>

                        <td class="py-3 px-4">
                            <div class="flex items-center">
                                <img src="https://ui-avatars.com/api/?name={{ $user->name }}&background=random"
                                    class="rounded-full w-8 h-8 mr-3">
                                <span>{{ $user->name }}</span>
                            </div>
                        </td>

                        <td class="py-3 px-4 text-gray-400">{{ $user->email }}</td>

                        {{-- Plano --}}
                        <td class="py-3 px-4">
                            @if($user->subscription && $user->subscription->plan)
                                <span class="px-2 py-1 rounded bg-gray-700 text-gray-300 text-sm">
                                    {{ $user->subscription->plan->name }}
                                </span>
                            @else
                                <span class="text-gray-500 text-sm">Sem plano</span>
                            @endif
                        </td>

                        {{-- Status --}}
                        <td class="py-3 px-4">
                            @if(!$user->subscription)
                                <span class="bg-gray-600 text-white px-2 py-1 rounded-full text-xs">
                                    Sem assinatura
                                </span>
                            @elseif($user->subscription->status === 'active' && !$user->subscription->isExpired())
                                <span class="bg-green-600 text-white px-2 py-1 rounded-full text-xs">
                                    Ativo
                                </span>
                            @else
                                <span class="bg-red-600 text-white px-2 py-1 rounded-full text-xs">
                                    Expirado
                                </span>
                            @endif
                        </td>

                        <td class="py-3 px-4 flex space-x-3">

                            <a href="{{ route('admin.users.show', $user->id) }}"
                               class="text-blue-400 hover:text-blue-300">
                                <i class="fas fa-eye"></i>
                            </a>

                            <a href="{{ route('admin.users.edit', $user->id) }}"
                               class="text-gray-400 hover:text-gray-300">
                                <i class="fas fa-edit"></i>
                            </a>

                            <form action="{{ route('admin.users.delete', $user->id) }}"
                                  method="POST"
                                  onsubmit="return confirm('Tem certeza que deseja excluir este usuário?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-500 hover:text-red-400">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>

                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="mt-4">
                {{ $users->appends(request()->query())->links() }}
            </div>
        </div>

    </div>
</div>

@endsection
