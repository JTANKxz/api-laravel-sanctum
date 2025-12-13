@extends('layouts.admin')

@section('title', 'Redeem Codes')

@section('content')
    <div class="mb-8">
        <h1 class="text-2xl font-bold mb-6">List Coupans</h1>
        <x-alert />
        <div class="bg-medium-gray rounded-xl shadow-lg p-6 animate-fadeIn w-full">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-xl font-bold">Coupans</h2>
                <a href="{{ route('admin.coupans.create') }}"
                    class="btn-hover bg-netflix-red hover:bg-red-800 text-white py-2 px-4 rounded-lg flex items-center">
                    <i class="fas fa-plus mr-2"></i> Adicionar Novo
                </a>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full">
                    <thead>
                        <tr class="border-b border-dark-gray">
                            <th class="py-3 px-4 text-left">ID</th>
                            <th class="py-3 px-4 text-left">CODE</th>
                            <th class="py-3 px-4 text-left">PLANO</th>
                            <th class="py-3 px-4 text-left">MAX USES</th>
                            <th class="py-3 px-4 text-left">USEDS</th>
                            <th class="py-3 px-4 text-left">STATUS</th>
                            <th class="py-3 px-4 text-left">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($coupans as $coupan)
                            <tr class="border-b border-dark-gray hover:bg-dark-gray">
                                <td class="py-3 px-4 text-gray-400">{{ $coupan->id }}</td>
                                <td class="py-3 px-4">{{ $coupan->code }}</td>
                                <td>{{ $coupan->plan->name ?? 'Sem plano' }}</td>
                                <td class="py-3 px-4 text-gray-400">{{ $coupan->max_uses }}</td>
                                <td class="py-3 px-4 text-gray-400">{{ $coupan->used_count }}</td>
                                <td class="py-3 px-4 text-gray-400">{{ $coupan->status }}</td>
                                <td class="py-3 px-4">

                                    <a href="{{ route('admin.coupans.edit', $coupan->id) }}"
                                        class="text-gray-400 hover:text-gray-300"><i class="fas fa-edit"></i></a>
                                    {{-- Deletar --}}
                                    <form action="{{ route('admin.coupans.delete', $coupan->id) }}" method="POST"
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
            </div>
        </div>
    </div>
@endsection
