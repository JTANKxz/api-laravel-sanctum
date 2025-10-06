@extends('layouts.admin')

@section('title', 'Nova Network')

@section('content')

<div class="bg-medium-gray rounded-xl shadow-lg p-6 animate-fadeIn max-w-4xl mx-auto">
    <h2 class="text-xl font-bold mb-6">Nova Network</h2>
    <x-alert />

    <form action="{{ route('admin.networks.store') }}" method="POST" id="networkForm">
        @csrf

        {{-- Nome --}}
        <div class="mb-4">
            <label class="block text-gray-400 mb-2">Name</label>
            <input type="text" name="name" placeholder="Ex: Netflix"
                class="w-full bg-dark-gray border border-gray-700 rounded-lg py-2 px-4 text-white" required>
        </div>

        {{-- Logo --}}
        <div class="mb-4">
            <label class="block text-gray-400 mb-2">Logo url</label>
            <input type="text" name="logo_url" placeholder="Ex: https://example.com/logo.png"
                class="w-full bg-dark-gray border border-gray-700 rounded-lg py-2 px-4 text-white">
        </div>

        {{-- Tipo de conteúdo --}}
        <div class="mb-4">
            <label class="block text-gray-400 mb-2">Tipo de conteúdo</label>
            <select id="type_select"
                class="w-full bg-dark-gray border border-gray-700 rounded-lg py-2 px-4 text-white">
                <option value="movie">Filme</option>
                <option value="serie">Série</option>
            </select>
        </div>

        <hr class="my-6 border-gray-700">

        {{-- Campo de busca --}}
        <div class="mb-6">
            <label class="block text-gray-400 mb-2">Buscar Conteúdo</label>
            <input type="text" id="search" placeholder="Digite o nome..."
                class="w-full bg-dark-gray border border-gray-700 rounded-lg py-2 px-4 text-white" autocomplete="off">
            <ul id="results"
                class="bg-gray-900 border border-gray-700 text-white rounded mt-2 hidden max-h-60 overflow-y-auto"></ul>
        </div>

        {{-- Itens selecionados --}}
        <div class="mb-6">
            <h4 class="text-lg font-semibold text-gray-300 mb-2">Itens Selecionados</h4>
            <ul id="selectedItems" class="space-y-2"></ul>
        </div>

        {{-- Botões --}}
        <div class="flex justify-end space-x-3">
            <a href="{{ url()->previous() }}" class="btn bg-netflix-red text-white py-2 px-4 rounded">
                Voltar
            </a>
            <button type="submit" class="bg-netflix-red hover:bg-red-800 text-white py-2 px-6 rounded">
                Criar Network
            </button>
        </div>
    </form>
</div>

{{-- Scripts --}}
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    let itemIndex = 0;

    $('#type_select').change(function() {
        $('#search').val('');
        $('#results').empty().hide();
    });

    $('#search').on('input', function() {
        let type = $('#type_select').val();
        let query = $(this).val();

        if (query.length < 2) {
            $('#results').hide();
            return;
        }

        $.ajax({
            url: "{{ route('admin.sliders.search') }}", // rota AJAX para buscar conteúdos
            method: 'GET',
            data: { type, query },
            success: function(data) {
                let html = '';
                if (data.length > 0) {
                    data.forEach(item => {
                        let year = item.year ? `<span class="text-sm text-gray-400 ml-2">(${item.year})</span>` : '';
                        html += `<li class="p-2 hover:bg-gray-700 cursor-pointer flex items-center justify-between"
                            data-id="${item.id}"
                            data-title="${item.title}">
                            <span>${item.title} ${year}</span>
                        </li>`;
                    });
                } else {
                    html = '<li class="p-2 text-red-400">Nenhum resultado encontrado</li>';
                }
                $('#results').html(html).show();
            }
        });
    });

    $(document).on('click', '#results li', function() {
        const id = $(this).data('id');
        const title = $(this).data('title');
        const type = $('#type_select').val(); // pega o tipo do select atual

        const newItem = `
        <li class="bg-gray-700 p-2 rounded flex items-center justify-between gap-4">
            <div>
                <strong>${title}</strong> <small class="text-sm">(${type})</small>
                <input type="hidden" name="items[${itemIndex}][content_id]" value="${id}">
                <input type="hidden" name="items[${itemIndex}][content_type]" value="${type}">
            </div>
            <button type="button" class="removeItem bg-red-600 hover:bg-red-700 text-white px-3 py-1 rounded">
                Remover
            </button>
        </li>
        `;

        $('#selectedItems').append(newItem);
        $('#search').val('');
        $('#results').hide();
        itemIndex++;
    });

    $(document).on('click', '.removeItem', function() {
        $(this).closest('li').remove();
    });
</script>

{{-- Estilo extra para resultados --}}
<style>
    #results li {
        padding: 10px 14px;
        border-bottom: 1px solid #2d2d2d;
        transition: background-color 0.2s ease, transform 0.1s ease;
        border-radius: 6px;
        margin: 4px;
    }

    #results li:hover {
        background-color: #4c4c70;
        transform: scale(1.02);
    }
</style>

@endsection
