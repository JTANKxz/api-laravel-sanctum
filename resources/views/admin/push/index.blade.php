@extends('layouts.admin')

@section('title', 'notify')

@section('content')

<div class="container mx-auto p-4">
    <h1 class="text-2xl font-bold mb-4">Enviar Notificação</h1>

    @if(session('success'))
        <div class="bg-green-200 text-green-800 p-2 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="bg-red-200 text-red-800 p-2 rounded mb-4">
            {{ session('error') }}
        </div>
    @endif

    <form action="{{ route('admin.notifications.send') }}" method="POST">
        @csrf
        <div class="mb-4">
            <label class="block mb-1 font-semibold">Título:</label>
            <input type="text" name="title" class="w-full border p-2 rounded" required>
        </div>

        <div class="mb-4">
            <label class="block mb-1 font-semibold">Mensagem:</label>
            <textarea name="body" class="w-full border p-2 rounded" rows="4" required></textarea>
        </div>

        <div class="mb-4">
            <label class="block mb-1 font-semibold">URL da Imagem (opcional):</label>
            <input type="url" name="image" class="w-full border p-2 rounded">
        </div>

        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
            Enviar Notificação
        </button>
    </form>
</div>
@endsection
