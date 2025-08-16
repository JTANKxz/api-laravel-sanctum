<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class NotificationController extends Controller
{
    public function index()
    {
        // Exemplo: retorna view para enviar notificações
        return view('admin.notifications.index');
    }

    public function send(Request $request)
    {
        $request->validate([
            'title'   => 'required|string|max:255',
            'body'    => 'required|string|max:500',
            'token'   => 'nullable|string', // se enviar para 1 device
            'topic'   => 'nullable|string', // se enviar para um tópico
        ]);

        $serverKey = env('FIREBASE_SERVER_KEY'); // guarda no .env
        $url = 'https://fcm.googleapis.com/fcm/send';

        // Monta payload
        $data = [
            "notification" => [
                "title" => $request->title,
                "body"  => $request->body,
                "sound" => "default"
            ],
            "priority" => "high",
        ];

        // Se enviou para token específico
        if ($request->token) {
            $data["to"] = $request->token;
        }

        // Se enviou para tópico (ex: "filmes")
        if ($request->topic) {
            $data["to"] = "/topics/" . $request->topic;
        }

        // Envia para o Firebase
        $response = Http::withHeaders([
            'Authorization' => 'key=' . $serverKey,
            'Content-Type'  => 'application/json',
        ])->post($url, $data);

        if ($response->successful()) {
            return back()->with('success', 'Notificação enviada com sucesso!');
        }

        return back()->with('error', 'Erro ao enviar notificação: ' . $response->body());
    }
}
