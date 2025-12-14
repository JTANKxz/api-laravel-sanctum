<?php

namespace App\Http\Controllers;

use App\Models\PremiumCode;
use Illuminate\Http\Request;

class PremiumCodeController extends Controller
{
    public function redeem(Request $request)
    {
        $request->validate([
            'code' => 'required|string'
        ]);

        $user = $request->user();
        $codeInput = strtoupper(trim($request->code));

        $code = PremiumCode::where('code', $codeInput)->first();

        if (!$code) {
            return response()->json([
                'success' => false,
                'message' => 'Código inválido.'
            ], 404);
        }

        if ($code->status !== 'active') {
            return response()->json([
                'success' => false,
                'message' => 'Este código não está ativo.'
            ], 400);
        }

        if ($code->expires_at && $code->expires_at->isPast()) {
            $code->update(['status' => 'expired']);
            return response()->json([
                'success' => false,
                'message' => 'Este código expirou.'
            ], 400);
        }

        if ($code->used_count >= $code->max_uses) {
            $code->update(['status' => 'exhausted']);
            return response()->json([
                'success' => false,
                'message' => 'Este código já atingiu o limite de usos.'
            ], 400);
        }

        // -------------------------------------------------------
        // APLICANDO O PLANO
        // -------------------------------------------------------

        $plan = $code->plan;

        if (!$plan) {
            return response()->json([
                'success' => false,
                'message' => 'Este código não está vinculado a um plano.'
            ], 500);
        }

        // Pegar assinatura existente
        $subscription = $user->subscription()->first();

        // Criar caso não exista (raro, mas seguro)
        if (!$subscription) {
            $subscription = $user->subscription()->create([
                'plan_id'    => null,
                'started_at' => now(),
                'expires_at' => null,
                'status'     => 'expired',
            ]);
        }

        // Aplicar assinatura premium
        // Base de cálculo: hoje às 00:00
        $baseDate = now()->startOfDay();

        // Soma a duração do plano
        $expiresAt = $baseDate->addDays($plan->duration_days);

        $subscription->update([
            'plan_id'    => $plan->id,
            'started_at' => now(),      // continua sendo o horário real
            'expires_at' => $expiresAt, // sempre 00:00
            'status'     => 'active',
        ]);

        // -------------------------------------------------------
        // REGISTRAR USO DO CÓDIGO
        // -------------------------------------------------------

        $code->increment('used_count');

        if ($code->used_count >= $code->max_uses) {
            $code->update(['status' => 'exhausted']);
        }

        return response()->json([
            'success' => true,
            'message' => 'Código resgatado com sucesso! Assinatura premium ativada.',
            'subscription' => $subscription,
            'plan' => $plan
        ]);
    }
}
