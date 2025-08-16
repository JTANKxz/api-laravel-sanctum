@extends('layouts.admin')

@section('title', 'Nova Seção Personalizada')

@section('content')

    <div class="bg-medium-gray rounded-xl shadow-lg p-6 animate-fadeIn max-w-4xl mx-auto">
        <h2 class="text-xl font-bold mb-6">Nova Seção Personalizada</h2>
        <x-alert />

        <form action="{{ route('admin.sections.store') }}" method="POST" id="sectionForm">
            @csrf

            {{-- Nome da Seção --}}
            <div class="mb-4">
                <label class="block text-gray-400 mb-2">Nome da Seção</label>
                <input type="text" name="name"
                    class="w-full bg-dark-gray border border-gray-700 rounded-lg py-2 px-4 text-white" required>
            </div>

            {{-- Ordem --}}
            <div class="mb-6">
                <label class="block text-gray-400 mb-2">Ordem da Seção</label>
                <input type="number" name="order" value="0"
                    class="w-full bg-dark-gray border border-gray-700 rounded-lg py-2 px-4 text-white">
            </div>

            <hr class="my-6 border-gray-700">

            {{-- Tipo de conteúdo --}}
            <div class="mb-4">
                <label class="block text-gray-400 mb-2">Tipo de Conteúdo</label>
                <select id="type_select" class="w-full bg-dark-gray border border-gray-700 rounded-lg py-2 px-4 text-white">
                    <option value="movie">Filme</option>
                    <option value="serie">Série</option>
                </select>
            </div>

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
                    Criar Seção
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
                url: "{{ route('admin.sliders.search') }}", // rota de busca
                method: 'GET',
                data: {
                    type,
                    query
                },
                success: function(data) {
                    let html = '';
                    if (data.length > 0) {
                        data.forEach(item => {
                            let title = item.title ?? item.name ?? 'Sem título';
                            let year = item.year ?
                                `<span class="text-sm text-gray-400 ml-2">(${item.year})</span>` :
                                '';

                            html += `<li class="p-2 hover:bg-gray-700 cursor-pointer flex items-center justify-between"
                            data-id="${item.id}"
                            data-title="${title}"
                            data-type="${type}">
                            <span>${title} ${year}</span>
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
            const type = $(this).data('type');

            const newItem = `
            <li class="bg-gray-700 p-2 rounded flex items-center justify-between gap-4">
                <div>
                    <strong>${title}</strong> <small class="text-sm">(${type})</small>
                    <input type="hidden" name="items[${itemIndex}][content_id]" value="${id}">
                    <input type="hidden" name="items[${itemIndex}][content_type]" value="${type}">
                </div>
                <div class="flex gap-2 items-center">
                    <label>Ordem:</label>
                    <input type="number" name="items[${itemIndex}][order]" value="0" class="w-20 bg-dark-gray border border-gray-700 rounded-lg py-1 px-2 text-white">
                    <button type="button" class="removeItem bg-red-600 hover:bg-red-700 text-white px-3 py-1 rounded">
                        Remover
                    </button>
                </div>
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
