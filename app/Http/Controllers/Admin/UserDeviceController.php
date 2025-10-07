<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UserDeviceController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'fcm_token' => 'required|string',
        ]);

        $fcmToken = $request->fcm_token;

        // Salva ou atualiza o token (sem user_id)
        DB::table('user_devices')->updateOrInsert(
            ['fcm_token' => $fcmToken],
            ['updated_at' => now()]
        );

        return response()->json([
            'success' => true,
            'message' => 'Token salvo com sucesso!'
        ]);
    }
}
