@extends('layouts.admin')

@section('title', 'notify')

@section('content')

<form method="POST" action="{{ route('admin.notifications.send') }}">
    @csrf
    <input type="text" name="title" placeholder="Título" required>
    <textarea name="body" placeholder="Mensagem" required></textarea>
    <input type="text" name="token" placeholder="Token (opcional)">
    <input type="text" name="topic" placeholder="Tópico (opcional)">
    <button type="submit">Enviar Notificação</button>
</form>

@endsection
