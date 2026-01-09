<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SupportTicket;
use Illuminate\Http\Request;

class SupportTicketController extends Controller
{
    public function index()
    {
        $tickets = SupportTicket::with('user')
            ->orderByDesc('id')
            ->paginate(20);

        return view('admin.support.index', compact('tickets'));
    }

    public function updateStatus(Request $request, $id)
    {
        $ticket = SupportTicket::findOrFail($id);

        $request->validate([
            'status' => 'required|string'
        ]);

        $ticket->status = $request->status;
        $ticket->save();

        return redirect()
            ->back()
            ->with('success', 'Status do ticket atualizado com sucesso!');
    }
}
