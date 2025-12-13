<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Plan;
use App\Models\PremiumCode;
use Illuminate\Http\Request;

class PremiumCodeControllerr extends Controller
{
    public function index()
    {
        $coupans = PremiumCode::with('plan')->get();
        return view('admin.coupans.index', compact('coupans'));
    }

    public function create()
    {
        $plans = Plan::all();
        return view('admin.coupans.create', compact('plans'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'code'       => 'required|string|unique:premium_codes,code',
            'plan_id'    => 'required|exists:plans,id',
            'max_uses'   => 'required|integer|min:1',
            'status'     => 'required|in:active,inactive',
            'expires_at' => 'nullable|date',
        ]);

        PremiumCode::create([
            'code'       => $validated['code'],
            'plan_id'    => $validated['plan_id'],
            'max_uses'   => $validated['max_uses'],
            'used_count' => 0, // sempre inicia zerado
            'status'     => $validated['status'],
            'expires_at' => $validated['expires_at'] ?? null,
        ]);

        return redirect()
            ->route('admin.coupans.index')
            ->with('success', 'Código premium criado com sucesso!');
    }

    public function edit(PremiumCode $coupan)
    {
        $plans = Plan::all();

        return view('admin.coupans.edit', compact('coupan', 'plans'));
    }

    public function update(Request $request, PremiumCode $coupan)
    {
        $data = $request->validate([
            'code'       => 'required|string|max:255',
            'plan_id'    => 'required|exists:plans,id',
            'max_uses'   => 'required|integer|min:1',
            'status'     => 'required|in:active,inactive',
            'expires_at' => 'nullable|date',
        ]);

        // Atualiza o cupom
        $coupan->update([
            'code'       => $data['code'],
            'plan_id'    => $data['plan_id'],
            'max_uses'   => $data['max_uses'],
            'status'     => $data['status'],
            'expires_at' => $data['expires_at'] ?? null,
        ]);

        return redirect()
            ->route('admin.coupans.index')
            ->with('success', 'Código atualizado com sucesso!');
    }

    public function destroy(PremiumCode $coupan)
    {
        try {
            $coupan->delete();
            return redirect()
                ->route('admin.coupan.index')
                ->with('success', 'Código deletado com sucesso!');
        } catch (\Exception $e) {
            return redirect()
                ->route('admin.coupan.index')
                ->with('error', 'Failed to delete code.');
        }
    }
}
