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

        // Cria referência interna segura
        $internalRef = Str::uuid()->toString();

        // Cria pagamento pendente
        $payment = Payment::create([
            'user_id' => $user->id,
            'plan_id' => $plan->id,
            'internal_ref' => $internalRef,
            'amount' => $plan->price,
            'status' => 'pending',
        ]);

        // URL da Cakto com refId
        $checkoutUrl = "https://pay.cakto.com.br/kz4bukp_686238/{$plan->id}?refId={$internalRef}";

        return response()->json([
            'success' => true,
            'checkout_url' => $checkoutUrl
        ]);
    }
}
