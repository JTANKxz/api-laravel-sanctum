@extends('layouts.admin')

@section('title', 'Criar slider')

@section('content')

    <div class="bg-medium-gray rounded-xl shadow-lg p-6 animate-fadeIn max-w-3xl mx-auto">
        <h2 class="text-xl font-bold mb-6">Criando Slider</h2>
        <x-alert />

        {{-- Seleção de tipo --}}
        <div class="mb-4">
            <label for="type_select" class="block text-gray-400 mb-2">Tipo de Conteúdo</label>
            <select id="type_select"
                class="w-full bg-dark-gray border border-gray-700 rounded-lg py-2 px-4 text-white focus:outline-none focus:ring-2 focus:ring-netflix-red">
                <option value="movie">Filme</option>
                <option value="serie">Série</option>
            </select>
        </div>

        {{-- Campo de busca --}}
        <div class="mb-6">
            <label for="search" class="block text-gray-400 mb-2">Buscar</label>
            <input type="text" id="search" placeholder="Digite o nome..."
                class="w-full bg-dark-gray border border-gray-700 rounded-lg py-2 px-4 text-white focus:outline-none focus:ring-2 focus:ring-netflix-red"
                autocomplete="off">
            <ul id="results"
                class="bg-gray-900 border border-gray-700 text-white rounded mt-2 hidden max-h-60 overflow-y-auto"></ul>
        </div>

        <form action="{{ route('admin.sliders.store') }}" method="POST">
            @csrf
            @method('POST')

            {{-- Campos ocultos --}}
            <input type="hidden" name="type" id="input_type">
            <input type="hidden" name="content_id" id="input_content_id">
            <input type="hidden" name="slug" id="input_slug">
            <input type="hidden" name="rating" id="input_rating">
            <input type="hidden" name="season_count" id="input_seasoncount">

            {{-- Campos preenchidos automaticamente --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-gray-400 mb-2">Title</label>
                    <input type="text" name="title" id="input_title" readonly
                        class="w-full bg-dark-gray border border-gray-700 rounded-lg py-2 px-4 text-white">
                </div>
                <div>
                    <label class="block text-gray-400 mb-2">Year</label>
                    <input type="text" name="year" id="input_year" readonly
                        class="w-full bg-dark-gray border border-gray-700 rounded-lg py-2 px-4 text-white">
                </div>
                <div>
                    <label class="block text-gray-400 mb-2">Duration (min)</label>
                    <input type="text" name="runtime" id="input_runtime" readonly
                        class="w-full bg-dark-gray border border-gray-700 rounded-lg py-2 px-4 text-white">
                </div>
                <div>
                    <label class="block text-gray-400 mb-2">Image url</label>
                    <input type="text" name="backdrop_url" id="input_backdrop" readonly
                        class="w-full bg-dark-gray border border-gray-700 rounded-lg py-2 px-4 text-white">
                </div>
            </div>

            {{-- Botões --}}
            <div class="mt-6 flex justify-end space-x-3">
                <a href="{{ url()->previous() }}" class="btn bg-netflix-red text-white py-2 px-4 rounded">
                    Voltar
                </a>
                <button type="submit" class="bg-netflix-red hover:bg-red-800 text-white py-2 px-6 rounded">
                    Salvar
                </button>
            </div>
        </form>
    </div>

    {{-- Scripts de busca e preenchimento --}}
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $('#type_select').change(function() {
            $('#search').val('');
            $('#results').empty().hide();

            $('#input_type').val('');
            $('#input_content_id').val('');
            $('#input_title').val('');
            $('#input_year').val('');
            $('#input_runtime').val('');
            $('#input_backdrop').val('');
        });

        $('#search').on('input', function() {
            let type = $('#type_select').val();
            let query = $(this).val();

            if (query.length < 2) {
                $('#results').hide();
                return;
            }

            $.ajax({
                url: "{{ route('admin.sliders.search') }}",
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
                            let runtime = item.runtime !== null ? item.runtime : '';

                            html += `<li class="p-2 hover:bg-gray-700 cursor-pointer" 
                            data-id="${item.id}"
                            data-slug="${item.slug ?? ''}"
                            data-title="${title}"
                            data-year="${item.year ?? ''}"
                            data-runtime="${runtime}"
                            data-backdrop="${item.backdrop_url ?? ''}"
                            data-rating="${item.rating ?? ''}"
                            data-seasoncount="${item.seasoncount ?? ''}">
                            ${title}
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
            $('#input_slug').val($(this).data('slug'));
            $('#input_rating').val($(this).data('rating'));
            $('#input_seasoncount').val($(this).data('seasoncount'));
            $('#input_type').val($('#type_select').val());
            $('#input_content_id').val($(this).data('id'));
            $('#input_title').val($(this).data('title'));
            $('#input_year').val($(this).data('year'));
            $('#input_runtime').val($(this).data('runtime'));
            $('#input_backdrop').val($(this).data('backdrop'));
            $('#results').hide();
            $('#search').val($(this).data('title'));
        });
    </script>

@endsection
