<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use Illuminate\Http\Request;

class EventController extends Controller
{
    // 📋 Listagem de eventos
    public function index()
    {
        $events = Event::orderBy('start_time', 'desc')->paginate(20);
        return view('admin.events.index', compact('events'));
    }

    // ➕ Formulário de criação
    public function create()
    {
        return view('admin.events.create');
    }

    // 💾 Salvar evento
    // 💾 Salvar evento
    public function store(Request $request)
    {
        $data = $request->validate([
            'title'         => 'required|string|max:255',
            'subtitle'      => 'nullable|string|max:255',
            'sport'         => 'nullable|string|max:50',
            'home_team'     => 'nullable|string|max:100',
            'away_team'     => 'nullable|string|max:100',
            'start_time'    => 'required|date',
            'end_time'      => 'nullable|date|after:start_time',
            'status'        => 'required',
            'thumbnail_url' => 'nullable|url',
            'is_featured'   => 'boolean',
        ]);

        Event::create($data);

        return redirect()
            ->route('admin.events.index')
            ->with('success', 'Evento criado com sucesso.');
    }


    // ✏️ Editar evento
    public function edit(Event $event)
    {
        return view('admin.events.edit', compact('event'));
    }

    // 🔄 Atualizar evento
    public function update(Request $request, Event $event)
    {
        $data = $request->validate([
            'title'         => 'required|string|max:255',
            'subtitle'      => 'nullable|string|max:255',
            'sport'         => 'nullable|string|max:50',
            'home_team'     => 'nullable|string|max:100',
            'away_team'     => 'nullable|string|max:100',
            'start_time'    => 'required|date',
            'end_time'      => 'nullable|date|after:start_time',
            'thumbnail_url' => 'nullable|url',
            'status'        => 'required|in:scheduled,live,finished',
            'is_featured'   => 'boolean',
        ]);

        $event->update($data);

        return redirect()
            ->route('admin.events.index')
            ->with('success', 'Evento atualizado com sucesso!');
    }

    // 🗑️ Remover evento
    public function destroy(Event $event)
    {
        $event->delete(); // links serão apagados pelo ON DELETE CASCADE

        return redirect()
            ->route('admin.events.index')
            ->with('success', 'Evento removido com sucesso!');
    }
}
