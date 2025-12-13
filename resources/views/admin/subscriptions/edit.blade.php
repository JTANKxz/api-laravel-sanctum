@extends('layouts.admin')

@section('title', 'Editar Plano')

@section('content')

    <div class="bg-medium-gray rounded-xl shadow-lg p-6 animate-fadeIn">
        <h2 class="text-xl font-bold mb-6">Editar Plano</h2>

        <form action="{{ route('admin.subscriptions.update', $plan->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                {{-- Nome --}}
                <div>
                    <label class="block text-gray-400 mb-2">Nome</label>
                    <input type="text" name="name" value="{{ $plan->name }}"
                        class="w-full bg-dark-gray border border-gray-700 rounded-lg py-2 px-4 text-white focus:outline-none focus:ring-2 focus:ring-netflix-red">
                </div>

                {{-- Preço --}}
                <div>
                    <label class="block text-gray-400 mb-2">Preço</label>
                    <input type="text" name="price" value="{{ $plan->price }}"
                        class="w-full bg-dark-gray border border-gray-700 rounded-lg py-2 px-4 text-white focus:outline-none focus:ring-2 focus:ring-netflix-red">
                </div>

                {{-- Duration --}}
                <div>
                    <label class="block text-gray-400 mb-2">Duration days</label>
                    <input type="number" name="duration_days" value="{{ $plan->duration_days }}"
                        class="w-full bg-dark-gray border border-gray-700 rounded-lg py-2 px-4 text-white focus:outline-none focus:ring-2 focus:ring-netflix-red">
                </div>

                {{-- Benefícios --}}
                <div>
                    <label class="block text-gray-400 mb-2">Benefícios</label>

                    <div id="benefits-list" class="space-y-2"></div>

                    <button type="button" onclick="addBenefit()"
                        class="bg-gray-700 hover:bg-gray-600 text-white py-1 px-4 rounded mt-2">
                        + Adicionar benefício
                    </button>

                    <input type="hidden" name="benefits" id="benefits-json">
                </div>

            </div>

            {{-- Botões --}}
            <div class="mt-6 flex justify-end space-x-3">
                <a href="{{ route('admin.subscriptions.index') }}"
                    class="bg-gray-700 hover:bg-gray-600 text-white py-2 px-6 rounded">
                    Cancelar
                </a>
                <button type="submit" class="bg-netflix-red hover:bg-red-800 text-white py-2 px-6 rounded">
                    Atualizar
                </button>
            </div>
        </form>
    </div>

    <script>
        // Carregar benefícios já existentes
        const existingBenefits = {!! json_encode($plan->benefits) !!};

        window.onload = () => {
            if (existingBenefits && Array.isArray(existingBenefits)) {
                existingBenefits.forEach(b => addBenefit(b));
            }
            updateBenefitsJSON();
        }

        function addBenefit(value = '') {
            const container = document.getElementById('benefits-list');

            const input = document.createElement('input');
            input.type = 'text';
            input.className = 'w-full bg-dark-gray border border-gray-700 rounded-lg py-2 px-4 text-white';
            input.placeholder = 'Digite um benefício';
            input.value = value;
            input.oninput = updateBenefitsJSON;

            container.appendChild(input);
            updateBenefitsJSON();
        }

        function updateBenefitsJSON() {
            const values = [...document.querySelectorAll('#benefits-list input')]
                .map(i => i.value)
                .filter(v => v.trim() !== '');

            document.getElementById('benefits-json').value = JSON.stringify(values);
        }
    </script>

@endsection
