<?php

namespace App\Http\Controllers;

use App\Models\AppConfig;
use App\Models\Plan;
use Illuminate\Http\Request;
use App\Models\Payment;
use Illuminate\Support\Str;

class CheckoutController extends Controller
{
    public function create(Request $request)
    {
        $user = $request->user();

        $request->validate([
            'plan_id' => 'required|exists:plans,id',
        ]);

        $plan = Plan::findOrFail($request->plan_id);

        if (!$plan->cakto_offer_id) {
            return response()->json([
                'success' => false,
                'message' => 'Plano não configurado para pagamento'
            ], 400);
        }

        $internalRef = Str::uuid()->toString();

        Payment::create([
            'user_id' => $user->id,
            'plan_id' => $plan->id,
            'internal_ref' => $internalRef,
            'amount' => $plan->price,
            'status' => 'pending',
        ]);

        // ✅ URL CORRETA
        $checkoutUrl = "https://pay.cakto.com.br/{$plan->cakto_offer_id}?refId={$internalRef}";

        return response()->json([
            'success' => true,
            'checkout_url' => $checkoutUrl
        ]);
    }
}
