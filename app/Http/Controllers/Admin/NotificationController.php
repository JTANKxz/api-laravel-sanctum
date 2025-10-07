<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class NotificationController extends Controller
{
    public function create()
    {
        return view('admin.push.index');
    }

    public function send(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'body'  => 'required|string|max:1000',
            'image' => 'nullable|url',
        ]);

        // Busca todos os tokens cadastrados
        $tokens = DB::table('user_devices')->pluck('fcm_token')->toArray();

        if (empty($tokens)) {
            return back()->with('error', 'Nenhum dispositivo registrado.');
        }

        $fcmServerKey = env('FCM_SERVER_KEY'); // Adicione no seu .env

        $payload = [
            'registration_ids' => $tokens,
            'notification' => [
                'title' => $request->title,
                'body' => $request->body,
                'image' => $request->image,
            ],
            'data' => [
                'title' => $request->title,
                'body' => $request->body,
                'imageUrl' => $request->image,
            ],
        ];

        $response = Http::withHeaders([
            'Authorization' => 'key=' . $fcmServerKey,
            'Content-Type' => 'application/json',
        ])->post('https://fcm.googleapis.com/fcm/send', $payload);

        if ($response->successful()) {
            return back()->with('success', 'Notificação enviada com sucesso!');
        }

        return back()->with('error', 'Falha ao enviar notificação.');
    }
}
