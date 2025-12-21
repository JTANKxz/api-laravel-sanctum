<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Event;
use Carbon\Carbon;

class EventController extends Controller
{
    public function index()
    {
        $today = Carbon::today();

        $events = Event::with('links')
            ->whereDate('start_time', $today)
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
            'title' => 'Jogos de Hoje',
            'items' => $events
        ]);
    }

    public function show($id)
    {
        return Event::with('links')->findOrFail($id);
    }
}
