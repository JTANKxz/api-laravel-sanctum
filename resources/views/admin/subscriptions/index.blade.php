@extends('layouts.admin')

@section('title', 'Plans')

@section('content')
<div class="mb-8">
    <h1 class="text-2xl font-bold mb-6">List Plans</h1>
    <x-alert />
    <div class="bg-medium-gray rounded-xl shadow-lg p-6 animate-fadeIn w-full">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-xl font-bold">Plans</h2>
            <button
                class="btn-hover bg-netflix-red hover:bg-red-800 text-white py-2 px-4 rounded-lg flex items-center">
                <i class="fas fa-plus mr-2"></i> Adicionar Novo
            </button>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full">
                <thead>
                    <tr class="border-b border-dark-gray">
                        <th class="py-3 px-4 text-left">ID</th>
                        <th class="py-3 px-4 text-left">Name</th>
                        <th class="py-3 px-4 text-left">Price</th>
                        <th class="py-3 px-4 text-left">Duration</th>
                        <th class="py-3 px-4 text-left">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($plans as $plan)
                    <tr class="border-b border-dark-gray hover:bg-dark-gray">
                        <td class="py-3 px-4 text-gray-400">{{ $plan->id }}</td>
                        <td class="py-3 px-4">{{ $plan->name }}</td>
                        <td class="py-3 px-4 text-gray-400">{{ $plan->price }}</td>
                        <td class="py-3 px-4 text-gray-400">{{ $plan->duration_days	 }}</td>
                        <!-- <td class="py-3 px-4">
                            <span class="bg-yellow-500 text-black px-2 py-1 rounded-full text-xs">Premium</span>
                        </td> -->
                        <!-- <td class="py-3 px-4">
                            <span class="bg-green-500 text-white px-2 py-1 rounded-full text-xs">Ativo</span>
                        </td> -->
                        <td class="py-3 px-4">
                            {{-- <a href="{{ route('admin.users.show', $plan->id) }}" class="text-blue-400 hover:text-blue-300 mr-2"><i class="fas fa-eye"></i></a> --}}
                            {{-- <a href="{{ route('admin.users.edit', $plan->id) }}" class="text-gray-400 hover:text-gray-300"><i class="fas fa-edit"></i></a> --}}
                            {{-- Deletar --}}
                            {{-- <form action="{{ route('admin.users.delete', $plan->id) }}" method="POST" onsubmit="return confirm('Tem certeza que deseja excluir este usuário?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-500 hover:text-red-400">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form> --}}
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection