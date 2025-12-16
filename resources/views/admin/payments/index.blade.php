@extends('layouts.admin')

@section('title', 'Payments Status')

@section('content')
    <div class="mb-8">
        <h1 class="text-2xl font-bold mb-6">List Payments</h1>
        <x-alert />
        <div class="bg-medium-gray rounded-xl shadow-lg p-6 animate-fadeIn w-full">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-xl font-bold">Payments</h2>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full">
                    <thead>
                        <tr class="border-b border-dark-gray">
                            <th class="py-3 px-4 text-left">ID</th>
                            <th class="py-3 px-4 text-left">Plano</th>
                            <th class="py-3 px-4 text-left">User</th>
                            <th class="py-3 px-4 text-left">Metodo</th>
                            <th class="py-3 px-4 text-left">Status</th>
                            <th class="py-3 px-4 text-left">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($payments as $payment)
                            <tr class="border-b border-dark-gray hover:bg-dark-gray">
                                <td class="py-3 px-4 text-gray-400">{{ $payment->id }}</td>
                                <td>{{ $payment->plan->name ?? 'Sem plano' }}</td>
                                <td class="py-3 px-4">{{ $payment->user->name }}</td>
                                <td class="py-3 px-4 text-gray-400">{{ $payment->payment_method }}</td>
                                <td class="py-3 px-4 text-gray-400">{{ $payment->status }}</td>
                                <td class="py-3 px-4">
                                    {{-- Deletar --}}
                                    <form action="{{ route('admin.payments.delete', $payment->id) }}" method="POST"
                                        onsubmit="return confirm('Tem certeza que deseja excluir este pagamento?');">
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
