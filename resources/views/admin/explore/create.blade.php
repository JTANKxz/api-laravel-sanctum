@extends('layouts.admin')

@section('title', 'Nova Seção do Catálogo')

@section('content')

<div class="bg-medium-gray rounded-xl shadow-lg p-6 animate-fadeIn max-w-3xl mx-auto">
    <h2 class="text-xl font-bold mb-6">Criar Nova Seção</h2>

    <x-alert />

    <form action="{{ route('admin.explore.store') }}" method="POST">
        @csrf
        @method('POST')

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

            {{-- Nome --}}
            <div class="col-span-2">
                <label class="block text-gray-400 mb-2">Nome da Seção</label>
                <input type="text"
                    name="title"
                    placeholder="Filmes Populares, Séries em Alta, Ação, etc."
                    class="w-full bg-dark-gray border border-gray-700 rounded-lg py-2 px-4 text-white focus:outline-none focus:ring-2 focus:ring-netflix-red">
            </div>

            {{-- Tipo --}}
            <div>
                <label class="block text-gray-400 mb-2">Tipo de Conteúdo</label>
                <select id="typeSelect" name="type"
                    class="w-full bg-dark-gray border border-gray-700 rounded-lg py-2 px-4 text-white focus:outline-none focus:ring-2 focus:ring-netflix-red">
                    <option value="movies">Filmes</option>
                    <option value="series">Séries</option>
                    <option value="genre">Gênero</option>
                    <option value="genres_list">Lista de Gêneros</option>
                    <option value="collection">Coleção</option>
                    <option value="collections_list">Lista de Coleções</option>
                    <option value="network">Network</option>
                    <option value="networks_list">Lista de Networks</option>
                    <option value="custom">Personalizado</option>
                </select>
            </div>

            {{-- ID de Referência ou Seletor Dinâmico --}}
            <div id="referenceWrapper" class="col-span-2">
                <label class="block text-gray-400 mb-2">Referência</label>

                {{-- Campo numérico padrão --}}
                <input type="number"
                    name="reference_id"
                    id="referenceInput"
                    placeholder="Ex: ID do gênero, network, etc."
                    class="w-full bg-dark-gray border border-gray-700 rounded-lg py-2 px-4 text-white focus:outline-none focus:ring-2 focus:ring-netflix-red">

                {{-- Campo de seleção dinâmico --}}
                <select name="reference_id" id="referenceSelect"
                    class="hidden w-full bg-dark-gray border border-gray-700 rounded-lg py-2 px-4 mt-2 text-white focus:outline-none focus:ring-2 focus:ring-netflix-red">
                </select>
            </div>

            {{-- Ordem --}}
            <div>
                <label class="block text-gray-400 mb-2">Ordem</label>
                <input type="number"
                    name="order"
                    placeholder="1"
                    value="1"
                    class="w-full bg-dark-gray border border-gray-700 rounded-lg py-2 px-4 text-white focus:outline-none focus:ring-2 focus:ring-netflix-red">
            </div>

            {{-- Ativo --}}
            <div>
                <label class="block text-gray-400 mb-2">Ativo?</label>
                <select name="is_active"
                    class="w-full bg-dark-gray border border-gray-700 rounded-lg py-2 px-4 text-white focus:outline-none focus:ring-2 focus:ring-netflix-red">
                    <option value="1" selected>Sim</option>
                    <option value="0">Não</option>
                </select>
            </div>

        </div>

        {{-- Botões --}}
        <div class="mt-6 flex justify-end space-x-3">
            <a href="{{ route('admin.explore.index') }}" class="btn bg-gray-700 hover:bg-gray-600 text-white py-2 px-4 rounded">
                Voltar
            </a>

            <button type="submit"
                class="bg-netflix-red hover:bg-red-800 text-white py-2 px-6 rounded">
                Salvar
            </button>
        </div>
    </form>
</div>

{{-- Script Dinâmico --}}
<script>
    const typeSelect = document.getElementById('typeSelect');
    const referenceSelect = document.getElementById('referenceSelect');
    const referenceInput = document.getElementById('referenceInput');

    typeSelect.addEventListener('change', async function() {
        const type = this.value;
        referenceSelect.innerHTML = ''; // limpa as opções anteriores

        // Exibir input padrão se não for tipo listável
        const listableTypes = ['genre', 'collection', 'network'];
        if (!listableTypes.includes(type)) {
            referenceInput.classList.remove('hidden');
            referenceSelect.classList.add('hidden');
            return;
        }

        referenceInput.classList.add('hidden');
        referenceSelect.classList.remove('hidden');

        // Rota para buscar dados
        let url = '';
        if (type === 'genre') url = '/dashboard/genres/list';
        if (type === 'collection') url = '/dashboard/collections/list';
        if (type === 'network') url = '/dashboard/networks/list';

        try {
            const response = await fetch(url);
            const data = await response.json();

            if (data.length === 0) {
                referenceSelect.innerHTML = '<option value="">Nenhum item encontrado</option>';
                return;
            }

            referenceSelect.innerHTML = '<option value="">Selecione...</option>';
            data.forEach(item => {
                const opt = document.createElement('option');
                opt.value = item.id;
                opt.textContent = item.name;
                referenceSelect.appendChild(opt);
            });
        } catch (e) {
            console.error('Erro ao buscar lista:', e);
        }
    });
</script>

@endsection
