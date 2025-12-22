<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Event;
use Carbon\Carbon;

class EventController extends Controller
{
    public function index()
    {
        $now = Carbon::now('America/Sao_Paulo');

        $events = Event::with('links')
            ->where(function ($q) use ($now) {
                $q->where('status', 'live')
                    ->orWhere(function ($q2) use ($now) {
                        $q2->where('status', 'upcoming')
                            ->where('start_time', '>=', $now);
                    });
            })
            ->orderByRaw("
            CASE 
                WHEN status = 'live' THEN 1
                WHEN status = 'upcoming' THEN 2
                ELSE 3
            END
        ")
            ->orderBy('start_time')
            ->get();

        return response()->json([
            'title' => 'Eventos',
            'items' => $events
        ]);
    }

    public function show($id)
    {
        return Event::with('links')->findOrFail($id);
    }
}
