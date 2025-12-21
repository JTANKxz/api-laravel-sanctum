<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\EventLink;
use Carbon\Carbon;
use Illuminate\Http\Request;

class EventLinkController extends Controller
{
    public function index(Event $event)
    {
        $links = $event->links()->orderBy('order')->get();
        return view('admin.events.links.index', compact('event', 'links'));
    }

    public function create(Event $event)
    {
        return view('admin.events.links.create', compact('event'));
    }

    public function store(Request $request, Event $event)
    {
        $data = $request->validate([
            'name' => 'nullable|string|max:100',
            'url' => 'required|url',
            'type' => 'required|in:m3u8,mp4,mkv,embed,custom',
            'player_sub' => 'required|in:free,premium',
            'order' => 'nullable|integer',
        ]);

        $data['event_id'] = $event->id;

        EventLink::create($data);

        return redirect()
            ->route('admin.events.links.index', $event)
            ->with('success', 'Transmissão adicionada.');
    }

    public function edit(EventLink $link)
    {
        return view('admin.events.links.edit', compact('link'));
    }

    public function update(Request $request, EventLink $link)
    {
        $data = $request->validate([
            'name' => 'nullable|string|max:100',
            'url' => 'required|url',
            'type' => 'required|in:m3u8,mp4,mkv,embed,custom',
            'player_sub' => 'required|in:free,premium',
            'order' => 'nullable|integer',
        ]);

        $link->update($data);

        return back()->with('success', 'Link atualizado.');
    }

    public function destroy(EventLink $link)
    {
        $link->delete();
        return back()->with('success', 'Link removido.');
    }
}
