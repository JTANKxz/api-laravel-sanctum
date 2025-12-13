<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Plan;

class SubscriptionController extends Controller
{
    public function index()
    {
        $plans = Plan::all();

        //make compact 
        return view('admin.subscriptions.index', compact('plans'));
    }

    public function create()
    {
        return view('admin.subscriptions.create');
    }

    public function store()
    {
        $data = request()->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric',
            'duration_days' => 'required|integer',
            'benefits' => 'required|string',
        ]);

        // Converte JSON string → array
        $data['benefits'] = json_decode($data['benefits'], true);

        // Salva direto; cast faz o resto
        Plan::create($data);

        return redirect()
            ->route('admin.subscriptions.index')
            ->with('success', 'Plano criado com sucesso!');
    }

    public function edit(Plan $plan)
    {
        return view('admin.subscriptions.edit', compact('plan'));
    }

    public function update(Plan $plan)
    {
        $data = request()->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric',
            'duration_days' => 'required|integer',
            'benefits' => 'required|string', // JSON string vindo do front
        ]);

        // Converte JSON string → array
        $data['benefits'] = json_decode($data['benefits'], true);

        // Atualiza (cast converte array para JSON puro)
        $plan->update($data);

        return redirect()
            ->route('admin.subscriptions.index')
            ->with('success', 'Plano atualizado com sucesso!');
    }

    public function destroy(Plan $plan)
    {
        try {
            $plan->delete();
            return redirect()
                ->route('admin.subscriptions.index')
                ->with('success', 'Plano deletado com sucesso!');
        } catch (\Exception $e) {
            return redirect()
                ->route('admin.subscriptions.index')
                ->with('error', 'Failed to delete plan.');
        }
    }
}
