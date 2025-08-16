@extends('layouts.admin')

@section('title', 'Pesquisa TMDB')

@section('content')

<div class="bg-medium-gray rounded-xl shadow-lg p-6 animate-fadeIn">
    <h2 class="text-xl font-bold mb-6">Pesquisar no TMDB</h2>

    {{-- Formulário de busca --}}
    <div class="mb-6">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div>
                <label class="block text-gray-400 mb-2">Título</label>
                <input type="text" id="searchTitle"
                    class="w-full bg-dark-gray border border-gray-700 rounded-lg py-2 px-4 focus:outline-none focus:ring-2 focus:ring-netflix-red"
                    placeholder="Digite o título do filme ou série">
            </div>
            <div>
                <label class="block text-gray-400 mb-2">Tipo</label>
                <select id="searchType"
                    class="w-full bg-dark-gray border border-gray-700 rounded-lg py-2 px-4 focus:outline-none focus:ring-2 focus:ring-netflix-red">
                    <option value="movie">Filme</option>
                    <option value="tv">Série</option>
                </select>
            </div>
            <div class="flex items-end">
                <button id="searchBtn"
                    class="bg-netflix-red hover:bg-red-800 text-white py-2 px-6 rounded w-full">Buscar</button>
            </div>
        </div>
    </div>

    {{-- Tabela de resultados --}}
    <div class="overflow-x-auto">
        <table class="min-w-full bg-dark-gray rounded-lg">
            <thead>
                <tr class="border-b border-gray-700">
                    <th class="py-3 px-4 text-left">Imagem</th>
                    <th class="py-3 px-4 text-left">Título</th>
                    <th class="py-3 px-4 text-left">Tipo</th>
                    <th class="py-3 px-4 text-left">Avaliação</th>
                    <th class="py-3 px-4 text-left">Data</th>
                    <th class="py-3 px-4 text-left">Ações</th>
                </tr>
            </thead>
            <tbody id="tmdbResults">
                <tr>
                    <td colspan="6" class="py-4 text-gray-400 text-center">Nenhum resultado</td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

{{-- Modal de importação de séries --}}
<div id="importModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden">
    <div class="bg-dark-gray rounded-xl shadow-lg p-6 w-11/12 md:w-2/3 lg:w-1/2">
        <h2 class="text-xl font-bold mb-4" id="modalTitle">Importar Série</h2>
        <p class="mb-6" id="modalMessage">Deseja importar todas as temporadas e episódios da série?</p>

        <div class="flex justify-end space-x-3">
            <button id="modalSkip" class="bg-gray-700 hover:bg-gray-600 text-white py-2 px-4 rounded">Fechar</button>
            <button id="modalImportSeasons" class="bg-netflix-red hover:bg-red-800 text-white py-2 px-4 rounded">Importar Série</button>
        </div>
        <div class="mt-4" id="modalSeasonButtons"></div>
    </div>
</div>
<script>
    const searchUrl = "{{ route('admin.tmdb.search') }}";
    const importUrl = "{{ route('admin.tmdb.import') }}";
    const importSerieUrl = "{{ route('admin.tmdb.importSerie') }}";
    const importEpisodesUrl = "{{ route('admin.tmdb.importEpisodes') }}";
    const importAllEpisodesUrl = "{{ route('admin.tmdb.importEpisodesAll') }}";
    const getSeasonsUrl = "{{ route('admin.tmdb.getSeasons') }}";

    let selectedSerie = null;
    let currentSerieId = null;

    // Funções do modal
    function openModal(serie) {
        selectedSerie = serie;
        currentSerieId = null;
        document.getElementById('modalTitle').innerText = `Importar: ${serie.name || serie.title}`;
        document.getElementById('modalMessage').innerText = 'Primeiro, importe a série. Depois, você poderá importar as temporadas e os episódios.';
        document.getElementById('modalSeasonButtons').innerHTML = '';

        document.getElementById('modalImportSeasons').style.display = 'inline-block';
        document.getElementById('modalImportSeasons').innerText = 'Importar Série';
        document.getElementById('modalImportSeasons').classList.remove('bg-green-600', 'bg-blue-600', 'bg-red-500');
        document.getElementById('modalImportSeasons').classList.add('bg-netflix-red');
        document.getElementById('modalImportSeasons').disabled = false;

        document.getElementById('importModal').classList.remove('hidden');
    }

    function closeModal() {
        document.getElementById('importModal').classList.add('hidden');
    }

    document.getElementById('modalSkip').addEventListener('click', () => {
        closeModal();
    });

    // Fluxo principal de importação
    document.getElementById('modalImportSeasons').addEventListener('click', async () => {
        if (!selectedSerie) return;

        const btn = document.getElementById('modalImportSeasons');
        const seasonButtonsContainer = document.getElementById('modalSeasonButtons');

        try {
            // Passo 1: Importar a série
            if (btn.innerText === 'Importar Série') {
                btn.disabled = true;
                btn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i> Importando série...';

                const serieResponse = await fetch(`${importSerieUrl}?tmdb_id=${selectedSerie.id}`);
                const serieData = await serieResponse.json();

                if (!serieResponse.ok) throw new Error(serieData.message || 'Erro ao importar série');

                currentSerieId = serieData.serie_id;

                // Mostrar opções de importação
                seasonButtonsContainer.innerHTML = `
                    <div class="mt-4">
                        <p class="text-gray-300 mb-3">Escolha como importar as temporadas e episódios:</p>
                        <div class="flex flex-wrap gap-3">
                            <button onclick="importAllSeasonsAndEpisodes(${selectedSerie.id}, ${serieData.serie_id}, this)" 
                                class="bg-netflix-red hover:bg-red-700 text-white py-2 px-4 rounded">
                                <i class="fas fa-bolt mr-2"></i>Importar Tudo (Série + Todas Temporadas + Episódios)
                            </button>
                            <button onclick="showSeasonSelection(${selectedSerie.id}, ${serieData.serie_id})" 
                                class="bg-blue-600 hover:bg-blue-700 text-white py-2 px-4 rounded">
                                <i class="fas fa-layer-group mr-2"></i>Escolher Temporadas para Importar
                            </button>
                        </div>
                    </div>
                `;

                btn.style.display = 'none';
            }
        } catch (error) {
            btn.innerHTML = '<i class="fas fa-times mr-2"></i> Erro: ' + error.message;
            btn.classList.remove('bg-netflix-red');
            btn.classList.add('bg-red-500');
            btn.disabled = false;
            console.error('Erro na importação:', error);
        }
    });

    // Mostrar seleção de temporadas
    async function showSeasonSelection(tmdbId, serieId) {
        try {
            const container = document.getElementById('modalSeasonButtons');
            container.innerHTML = '<p class="text-gray-300 mb-2"><i class="fas fa-spinner fa-spin mr-2"></i>Carregando temporadas...</p>';

            const response = await fetch(`${getSeasonsUrl}?tmdb_id=${tmdbId}`);
            const data = await response.json();

            if (!response.ok) throw new Error(data.message || 'Erro ao carregar temporadas');

            if (!data.seasons || data.seasons.length === 0) {
                container.innerHTML = '<p class="text-gray-300">Nenhuma temporada disponível</p>';
                return;
            }

            let html = `
                <div class="mt-4">
                    <p class="text-gray-300 mb-3">Selecione as temporadas para importar:</p>
                    <div class="max-h-96 overflow-y-auto pr-2">
                        <table class="w-full">
                            <thead>
                                <tr class="border-b border-gray-700">
                                    <th class="text-left py-2 px-3">Temporada</th>
                                    <th class="text-left py-2 px-3">Episódios</th>
                                    <th class="text-left py-2 px-3">Ações</th>
                                </tr>
                            </thead>
                            <tbody>
            `;

            data.seasons.forEach(season => {
                if (season.season_number > 0) { // Ignora temporada 0 (especiais)
                    html += `
                        <tr class="border-b border-gray-700">
                            <td class="py-2 px-3">
                                <span class="font-medium">Temporada ${season.season_number}</span>
                                ${season.name ? `<div class="text-sm text-gray-400">${season.name}</div>` : ''}
                            </td>
                            <td class="py-2 px-3 text-gray-400">${season.episode_count || '?'} episódios</td>
                            <td class="py-2 px-3">
                                <button onclick="importSingleSeason(${tmdbId}, ${season.season_number}, ${serieId}, this)"
                                    class="bg-purple-600 hover:bg-purple-700 text-white py-1 px-3 rounded text-sm">
                                    <i class="fas fa-download mr-1"></i>Importar
                                </button>
                            </td>
                        </tr>
                    `;
                }
            });

            html += `
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-4">
                        <button onclick="importAllSeasons(${tmdbId}, ${serieId}, this)"
                            class="bg-blue-600 hover:bg-blue-700 text-white py-2 px-4 rounded">
                            <i class="fas fa-layer-group mr-2"></i>Importar Todas as Temporadas
                        </button>
                    </div>
                </div>
            `;

            container.innerHTML = html;

        } catch (error) {
            document.getElementById('modalSeasonButtons').innerHTML = `
                <div class="text-red-500 mt-4">
                    <i class="fas fa-exclamation-triangle mr-2"></i>
                    Erro: ${error.message}
                </div>
            `;
            console.error('Erro ao carregar temporadas:', error);
        }
    }

    // Importar uma temporada específica com seus episódios
    async function importSingleSeason(tmdbSerieId, seasonNumber, serieId, btn) {
        try {
            const originalHtml = btn.innerHTML;
            btn.disabled = true;
            btn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i> Importando...';

            // Primeiro importa a temporada
            const seasonResponse = await fetch(`${importSerieUrl}?tmdb_id=${tmdbSerieId}&season_number=${seasonNumber}`);
            const seasonData = await seasonResponse.json();

            if (!seasonResponse.ok) throw new Error(seasonData.message || 'Erro ao importar temporada');

            // Depois importa os episódios
            const episodesResponse = await fetch(`${importEpisodesUrl}?serie_tmdb_id=${tmdbSerieId}&season_number=${seasonNumber}`);
            const episodesData = await episodesResponse.json();

            if (!episodesResponse.ok) throw new Error(episodesData.message || 'Erro ao importar episódios');

            btn.innerHTML = '<i class="fas fa-check mr-2"></i> Importado!';
            btn.classList.remove('bg-purple-600', 'hover:bg-purple-700');
            btn.classList.add('bg-green-500');

            // Desabilita o botão após importação bem-sucedida
            setTimeout(() => {
                btn.disabled = true;
            }, 1500);
        } catch (error) {
            btn.innerHTML = originalHtml;
            btn.classList.remove('bg-purple-600', 'hover:bg-purple-700');
            btn.classList.add('bg-red-500');
            btn.innerHTML = '<i class="fas fa-times mr-2"></i> Erro';

            setTimeout(() => {
                btn.innerHTML = originalHtml;
                btn.classList.remove('bg-red-500');
                btn.classList.add('bg-purple-600', 'hover:bg-purple-700');
                btn.disabled = false;
            }, 2000);

            console.error('Erro ao importar temporada:', error);
        }
    }

    // Importar todas as temporadas de uma vez
    async function importAllSeasons(tmdbSerieId, serieId, btn) {
        try {
            const originalHtml = btn.innerHTML;
            btn.disabled = true;
            btn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i> Importando todas as temporadas...';

            const response = await fetch(`${importAllEpisodesUrl}?serie_id=${serieId}`);
            const data = await response.json();

            if (!response.ok) throw new Error(data.message || 'Erro ao importar temporadas');

            btn.innerHTML = '<i class="fas fa-check mr-2"></i> Todas importadas!';
            btn.classList.remove('bg-blue-600', 'hover:bg-blue-700');
            btn.classList.add('bg-green-500');

            // Atualiza a lista de temporadas
            showSeasonSelection(tmdbSerieId, serieId);
        } catch (error) {
            btn.innerHTML = '<i class="fas fa-times mr-2"></i> Erro';
            btn.classList.remove('bg-blue-600', 'hover:bg-blue-700');
            btn.classList.add('bg-red-500');

            setTimeout(() => {
                btn.innerHTML = originalHtml;
                btn.classList.remove('bg-red-500');
                btn.classList.add('bg-blue-600', 'hover:bg-blue-700');
                btn.disabled = false;
            }, 2000);

            console.error('Erro ao importar todas as temporadas:', error);
        }
    }

    // Importar tudo de uma vez (série, temporadas e episódios)
    async function importAllSeasonsAndEpisodes(tmdbSerieId, serieId, btn) {
        try {
            const originalHtml = btn.innerHTML;
            btn.disabled = true;
            btn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i> Importando tudo...';

            // Importa todas as temporadas e episódios
            const response = await fetch(`${importAllEpisodesUrl}?serie_id=${serieId}`);
            const data = await response.json();

            if (!response.ok) throw new Error(data.message || 'Erro ao importar tudo');

            btn.innerHTML = '<i class="fas fa-check mr-2"></i> Tudo importado!';
            btn.classList.remove('bg-netflix-red', 'hover:bg-red-700');
            btn.classList.add('bg-green-500');

            // Fecha o modal após 1.5 segundos
            setTimeout(() => {
                closeModal();
            }, 1500);
        } catch (error) {
            btn.innerHTML = '<i class="fas fa-times mr-2"></i> Erro';
            btn.classList.remove('bg-netflix-red', 'hover:bg-red-700');
            btn.classList.add('bg-red-500');

            setTimeout(() => {
                btn.innerHTML = originalHtml;
                btn.classList.remove('bg-red-500');
                btn.classList.add('bg-netflix-red', 'hover:bg-red-700');
                btn.disabled = false;
            }, 2000);

            console.error('Erro ao importar tudo:', error);
        }
    }

    // Buscar e renderizar resultados
    document.getElementById('searchBtn').addEventListener('click', function() {
        const title = document.getElementById('searchTitle').value.trim();
        const type = document.getElementById('searchType').value;
        const tbody = document.getElementById('tmdbResults');

        if (!title) {
            tbody.innerHTML = '<tr><td colspan="6" class="py-4 text-gray-400 text-center">Digite um título para buscar</td></tr>';
            return;
        }

        tbody.innerHTML = '<tr><td colspan="6" class="py-4 text-gray-400 text-center"><i class="fas fa-spinner fa-spin mr-2"></i>Carregando...</td></tr>';

        fetch(`${searchUrl}?title=${encodeURIComponent(title)}&type=${type}`)
            .then(res => res.json())
            .then(data => {
                if (!data.results || data.results.length === 0) {
                    tbody.innerHTML = '<tr><td colspan="6" class="py-4 text-gray-400 text-center">Nenhum resultado encontrado</td></tr>';
                    return;
                }

                tbody.innerHTML = data.results.map(item => `
                    <tr class="border-b border-gray-700 hover:bg-gray-700">
                        <td class="py-3 px-4">
                            <img src="${item.poster_path ? 'https://image.tmdb.org/t/p/w92'+item.poster_path : 'https://via.placeholder.com/50x75?text=Thumb'}"
                                alt="${item.title || item.name}" class="rounded w-10 h-15">
                        </td>
                        <td class="py-3 px-4 font-medium">${item.title || item.name}</td>
                        <td class="py-3 px-4">
                            <span class="${type === 'movie' ? 'bg-purple-500' : 'bg-netflix-red'} text-white px-2 py-1 rounded-full text-xs">
                                ${type === 'movie' ? 'Filme' : 'Série'}
                            </span>
                        </td>
                        <td class="py-3 px-4">
                            <div class="flex items-center">
                                <i class="fas fa-star text-yellow-400 mr-1"></i>
                                <span>${item.vote_average ? item.vote_average.toFixed(1) : '-'}</span>
                            </div>
                        </td>
                        <td class="py-3 px-4 text-gray-400">${item.release_date || item.first_air_date || '-'}</td>
                        <td class="py-3 px-4">
                            ${type === 'movie'
                                ? `<button class="btn-import bg-netflix-red hover:bg-red-800 text-white py-2 px-4 rounded" data-tmdb-id="${item.id}">
                                    <i class="fas fa-download mr-1"></i>Importar
                                   </button>`
                                : `<button class="btn-import bg-netflix-red hover:bg-red-800 text-white py-2 px-4 rounded" 
                                    onclick="openModal(${JSON.stringify(item).replace(/"/g, '&quot;')})">
                                    <i class="fas fa-download mr-1"></i>Importar
                                   </button>`
                            }
                        </td>
                    </tr>
                `).join('');

                // Configurar botões de importação para filmes
                document.querySelectorAll('.btn-import[data-tmdb-id]').forEach(btn => {
                    btn.addEventListener('click', function() {
                        const tmdbId = this.dataset.tmdbId;
                        const button = this;
                        const originalHtml = button.innerHTML;

                        button.disabled = true;
                        button.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i> Importando...';

                        fetch(importUrl, {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': "{{ csrf_token() }}"
                                },
                                body: JSON.stringify({
                                    tmdb_id: tmdbId
                                })
                            })
                            .then(res => res.json())
                            .then(data => {
                                if (data.error) throw new Error(data.error);

                                button.innerHTML = '<i class="fas fa-check mr-2"></i> Importado!';
                                button.classList.remove('bg-netflix-red', 'hover:bg-red-800');
                                button.classList.add('bg-green-500');
                                button.disabled = true;
                            })
                            .catch(error => {
                                button.innerHTML = '<i class="fas fa-times mr-2"></i> Erro';
                                button.classList.remove('bg-netflix-red', 'hover:bg-red-800');
                                button.classList.add('bg-red-500');

                                setTimeout(() => {
                                    button.innerHTML = originalHtml;
                                    button.classList.remove('bg-red-500');
                                    button.classList.add('bg-netflix-red', 'hover:bg-red-800');
                                    button.disabled = false;
                                }, 2000);

                                console.error('Erro na importação:', error);
                            });
                    });
                });
            })
            .catch(err => {
                tbody.innerHTML = `
                    <tr>
                        <td colspan="6" class="py-4 text-red-500 text-center">
                            <i class="fas fa-exclamation-triangle mr-2"></i>
                            Erro ao buscar dados: ${err.message}
                        </td>
                    </tr>
                `;
                console.error('Erro na busca:', err);
            });
    });
</script>

@endsection