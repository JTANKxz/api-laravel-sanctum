@extends('layouts.admin')

@section('title', 'Links em Massa - ' . $serie->title)

@section('content')
    <div class="bg-medium-gray rounded-xl shadow-lg p-6 animate-fadeIn">
        <h2 class="text-xl font-bold mb-6">
            Links de Todas as Temporadas - {{ $serie->title }}
        </h2>
        <x-alert />

        <form action="{{ route('admin.links.bulkStore', [$serie->id]) }}" method="POST">
            @csrf

            {{-- 🔹 Campos de Pré-configuração --}}
            <div class="border border-dark-gray rounded-lg p-4 mb-6 bg-dark-gray">
                <h3 class="text-lg font-semibold text-white mb-4">Pré-configuração (aplica em todos os episódios)</h3>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

                    <div>
                        <label class="block text-gray-400 mb-2">Nome</label>
                        <input type="text" id="pre_name" placeholder="SERVIDOR 1"
                            class="w-full bg-gray-800 border border-gray-700 rounded-lg py-2 px-4 text-white">
                    </div>

                    <div>
                        <label class="block text-gray-400 mb-2">URL</label>
                        <input type="text" id="pre_url" placeholder="https://server.com/.../S{season}E{episode}"
                            class="w-full bg-gray-800 border border-gray-700 rounded-lg py-2 px-4 text-white">
                        <p class="text-gray-400 text-sm mt-1">Use <code>{season}</code> e <code>{episode}</code> para
                            substituir automaticamente, com zero à esquerda.</p>
                    </div>

                    <div>
                        <label class="block text-gray-400 mb-2">Qualidade</label>
                        <input type="text" id="pre_quality" placeholder="HD"
                            class="w-full bg-gray-800 border border-gray-700 rounded-lg py-2 px-4 text-white">
                    </div>

                    <div>
                        <label class="block text-gray-400 mb-2">Order</label>
                        <input type="number" id="pre_order" placeholder="1"
                            class="w-full bg-gray-800 border border-gray-700 rounded-lg py-2 px-4 text-white">
                    </div>

                    <div>
                        <label class="block text-gray-400 mb-2">Player Sub</label>
                        <select id="pre_player_sub"
                            class="w-full bg-gray-800 border border-gray-700 rounded-lg py-2 px-4 text-white">
                            <option value="">-- Selecionar --</option>
                            <option value="free">Free</option>
                            <option value="premium">Premium</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-gray-400 mb-2">Type</label>
                        <select id="pre_type"
                            class="w-full bg-gray-800 border border-gray-700 rounded-lg py-2 px-4 text-white">
                            <option value="">-- Selecionar --</option>
                            <option value="embed">Embed</option>
                            <option value="m3u8">M3U8</option>
                            <option value="mp4">MP4</option>
                            <option value="mkv">MKV</option>
                        </select>
                    </div>
                </div>
            </div>

            {{-- 🔹 Lista de temporadas --}}
            @foreach ($serie->seasons as $season)
                <div class="season-container mb-4 border border-dark-gray rounded-lg overflow-hidden bg-gray-900">
                    <div class="season-header cursor-pointer p-4 flex justify-between items-center">
                        <span class="text-white font-bold">Temporada {{ $season->season_number }}</span>
                        <input type="text"
                            class="season_url w-1/2 bg-gray-800 border border-gray-700 rounded-lg py-1 px-3 text-white text-sm"
                            placeholder="URL para toda a temporada (opcional)">
                        <span class="toggle-episodes text-white text-xl ml-2">▼</span>
                    </div>
                    <div class="episodes-container hidden p-4 bg-gray-800">
                        {{-- Aqui os episódios serão carregados --}}
                        @foreach ($season->episodes as $ep)
                            <div class="episode-container border border-dark-gray rounded-lg p-4 mb-4">
                                <h4 class="text-lg font-semibold text-white mb-4">
                                    Episódio {{ $ep->episode_number }} - {{ $ep->name }}
                                </h4>

                                <input type="hidden" class="season_number"
                                    value="{{ str_pad($season->season_number, 2, '0', STR_PAD_LEFT) }}">
                                <input type="hidden" class="episode_number"
                                    value="{{ str_pad($ep->episode_number, 2, '0', STR_PAD_LEFT) }}">

                                @php
                                    $links = $ep->playLinks->count()
                                        ? $ep->playLinks
                                        : [new \App\Models\EpisodePlayLink()];
                                @endphp

                                @foreach ($links as $i => $link)
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-4">
                                        <input type="hidden" name="episodes[{{ $ep->id }}][{{ $i }}][id]"
                                            value="{{ $link->id }}">
                                        <input type="hidden"
                                            name="episodes[{{ $ep->id }}][{{ $i }}][episode_id]"
                                            value="{{ $ep->id }}">

                                        <div>
                                            <label class="block text-gray-400 mb-2">Nome</label>
                                            <input type="text"
                                                class="field_name w-full bg-dark-gray border border-gray-700 rounded-lg py-2 px-4 text-white"
                                                name="episodes[{{ $ep->id }}][{{ $i }}][name]"
                                                value="{{ $link->name }}" placeholder="SERVIDOR 1">
                                        </div>

                                        <div>
                                            <label class="block text-gray-400 mb-2">Url</label>
                                            <input type="text"
                                                class="field_url w-full bg-dark-gray border border-gray-700 rounded-lg py-2 px-4 text-white"
                                                name="episodes[{{ $ep->id }}][{{ $i }}][url]"
                                                value="{{ $link->url }}" placeholder="https://watchmovie.com/movie.mp4">
                                        </div>

                                        <div>
                                            <label class="block text-gray-400 mb-2">Quality</label>
                                            <input type="text"
                                                class="field_quality w-full bg-dark-gray border border-gray-700 rounded-lg py-2 px-4 text-white"
                                                name="episodes[{{ $ep->id }}][{{ $i }}][quality]"
                                                value="{{ $link->quality }}" placeholder="HD">
                                        </div>

                                        <div>
                                            <label class="block text-gray-400 mb-2">Order</label>
                                            <input type="number"
                                                class="field_order w-full bg-dark-gray border border-gray-700 rounded-lg py-2 px-4 text-white"
                                                name="episodes[{{ $ep->id }}][{{ $i }}][order]"
                                                value="{{ $link->order }}" placeholder="1">
                                        </div>

                                        <div>
                                            <label class="block text-gray-400 mb-2">Player Sub</label>
                                            <select
                                                class="field_player_sub w-full bg-dark-gray border border-gray-700 rounded-lg py-2 px-4 text-white"
                                                name="episodes[{{ $ep->id }}][{{ $i }}][player_sub]">
                                                <option value="free" {{ $link->player_sub == 'free' ? 'selected' : '' }}>
                                                    Free</option>
                                                <option value="premium"
                                                    {{ $link->player_sub == 'premium' ? 'selected' : '' }}>Premium</option>
                                            </select>
                                        </div>

                                        <div>
                                            <label class="block text-gray-400 mb-2">Type</label>
                                            <select
                                                class="field_type w-full bg-dark-gray border border-gray-700 rounded-lg py-2 px-4 text-white"
                                                name="episodes[{{ $ep->id }}][{{ $i }}][type]">
                                                <option value="embed" {{ $link->type == 'embed' ? 'selected' : '' }}>Embed
                                                </option>
                                                <option value="m3u8" {{ $link->type == 'm3u8' ? 'selected' : '' }}>M3U8
                                                </option>
                                                <option value="mp4" {{ $link->type == 'mp4' ? 'selected' : '' }}>MP4
                                                </option>
                                                <option value="mkv" {{ $link->type == 'mkv' ? 'selected' : '' }}>MKV
                                                </option>
                                            </select>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endforeach
                    </div>
                </div>
            @endforeach

            <div class="mt-6 flex justify-end space-x-3">
                <a href="{{ url()->previous() }}" class="btn bg-netflix-red text-white py-2 px-4 rounded">Voltar</a>
                <button type="submit" class="bg-netflix-red hover:bg-red-800 text-white py-2 px-6 rounded">Salvar
                    Tudo</button>
            </div>
        </form>
    </div>

    {{-- JS para pré-configuração, URL de temporada e accordion --}}
    <script>
        document.addEventListener("DOMContentLoaded", () => {

            // 🔹 Função de pré-configuração
            function applyPreConfig(id, className) {
                document.getElementById(id).addEventListener("input", function() {
                    let value = this.value;
                    if (!value) return;

                    document.querySelectorAll("." + className).forEach(el => {
                        let container = el.closest(".episode-container");
                        if (!container) return;

                        if (className === "field_url") {
                            let seasonNumber = container.querySelector(".season_number")?.value ||
                                "01";
                            let episodeNumber = container.querySelector(".episode_number")?.value ||
                                "01";
                            el.value = value.replace(/\{season\}/gi, seasonNumber).replace(
                                /\{episode\}/gi, episodeNumber);
                        } else if (className === "field_player_sub" || className === "field_type") {
                            if (!el.value) el.value = value;
                        } else {
                            el.value = value;
                        }
                    });
                });
            }

            applyPreConfig("pre_name", "field_name");
            applyPreConfig("pre_url", "field_url");
            applyPreConfig("pre_quality", "field_quality");
            applyPreConfig("pre_order", "field_order");
            applyPreConfig("pre_player_sub", "field_player_sub");
            applyPreConfig("pre_type", "field_type");

            // 🔹 URL específica da temporada
            document.querySelectorAll(".season_url").forEach(seasonInput => {
                seasonInput.addEventListener("input", function() {
                    let value = this.value;
                    if (!value) return;
                    let seasonContainer = this.closest(".season-container");
                    seasonContainer.querySelectorAll(".episode-container .field_url").forEach(
                        epInput => {
                            let seasonNumber = epInput.closest(".episode-container")
                                .querySelector(".season_number")?.value || "01";
                            let episodeNumber = epInput.closest(".episode-container")
                                .querySelector(".episode_number")?.value || "01";
                            epInput.value = value.replace(/\{season\}/gi, seasonNumber).replace(
                                /\{episode\}/gi, episodeNumber);
                        });
                });
            });

            // 🔹 Accordion para abrir apenas uma temporada por vez
            const seasonHeaders = document.querySelectorAll('.season-header');
            seasonHeaders.forEach(header => {
                header.addEventListener('click', () => {
                    const container = header.nextElementSibling;
                    const isVisible = !container.classList.contains('hidden');

                    // Fecha todos os containers
                    document.querySelectorAll('.episodes-container').forEach(c => c.classList.add(
                        'hidden'));
                    document.querySelectorAll('.toggle-episodes').forEach(t => t.textContent = '▼');

                    // Abre o clicado
                    if (!isVisible) {
                        container.classList.remove('hidden');
                        header.querySelector('.toggle-episodes').textContent = '▲';
                    }
                });
            });
        });
    </script>
@endsection
