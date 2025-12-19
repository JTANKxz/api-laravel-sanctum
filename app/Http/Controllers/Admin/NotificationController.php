<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Google\Auth\Credentials\ServiceAccountCredentials;


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
            'body'  => 'required|string',
            'image' => 'nullable|url',
        ]);

        // ⚠️ Corrige aqui também: use FIREBASE_PROJECT_ID, não FCM_SERVER_KEY
        $projectId = env('FIREBASE_PROJECT_ID');
        $url = "https://fcm.googleapis.com/v1/projects/{$projectId}/messages:send";

        // Caminho do arquivo JSON da conta de serviço
        $keyFile = storage_path('app/private/auth.json');

        // Cria credenciais e obtém token OAuth2
        $scopes = ['https://www.googleapis.com/auth/firebase.messaging'];
        $credentials = new ServiceAccountCredentials($scopes, $keyFile);
        $accessToken = $credentials->fetchAuthToken()['access_token'];

        // Monta o payload
        $payload = [
            'message' => [
                'topic' => 'all',
                'notification' => [            // ✅ adiciona esta seção
                    'title' => $request->title,
                    'body'  => $request->body,
                ],
                'data' => [
                    'title'   => $request->title,
                    'message' => $request->body,
                    'image'   => $request->image,
                ],
            ],
        ];
        

        // Envia ao FCM
        $response = Http::withToken($accessToken)->post($url, $payload);

        if ($response->successful()) {
            return redirect()->back()->with('success', '✅ Notificação enviada com sucesso!');
        }

        return redirect()->back()->with('error', '❌ Erro ao enviar: ' . $response->body());
    }
}
