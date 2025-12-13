<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Plan;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $query = User::query()->with('subscription.plan');

        // Buscar por nome ou email
        if ($request->search) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'LIKE', "%{$request->search}%")
                    ->orWhere('email', 'LIKE', "%{$request->search}%");
            });
        }

        // Filtros
        if ($request->filter == 'with_plan') {
            $query->whereHas('subscription');
        }

        if ($request->filter == 'without_plan') {
            $query->whereDoesntHave('subscription');
        }

        if ($request->filter == 'active') {
            $query->whereHas('subscription', function ($q) {
                $q->where('status', 'active')
                    ->where('expires_at', '>', now());
            });
        }

        if ($request->filter == 'expired') {
            $query->whereHas('subscription', function ($q) {
                $q->where('status', 'expired')
                    ->orWhere('expires_at', '<', now());
            });
        }

        if ($request->filter == 'admin') {
            $query->where('is_admin', 1);
        }

        if ($request->filter == 'user') {
            $query->where('is_admin', 0);
        }

        $users = $query->orderByDesc('id')->paginate(20);

        return view("admin.users.index", compact('users'));
    }

    public function show($id)
    {
        $user = User::find($id);
        return view("admin.users.show", ['user' => $user]);
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        $plans = Plan::all();

        return view("admin.users.edit", compact('user', 'plans'));
    }


    public function update($id, Request $request)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'name'      => 'required|string|max:255',
            'email'     => 'required|email|max:255|unique:users,email,' . $user->id,
            'is_admin'  => 'required|in:0,1',
            'plan_id'   => 'nullable|exists:plans,id',
        ]);

        // Atualiza dados base do usuário
        $user->update([
            'name'     => $request->name,
            'email'    => $request->email,
            'is_admin' => $request->is_admin,
        ]);

        /**
         * =======================
         * LÓGICA DA ASSINATURA
         * =======================
         */

        if ($request->plan_id) {

            $plan = Plan::findOrFail($request->plan_id);

            $expiresAt = now()->addDays($plan->duration_days);

            // Se já tem assinatura → atualiza
            if ($user->subscription) {
                $user->subscription->update([
                    'plan_id'    => $plan->id,
                    'started_at' => now(),
                    'expires_at' => $expiresAt,
                    'status'     => 'active',
                ]);
            } else {
                // Cria uma nova assinatura
                $user->subscription()->create([
                    'plan_id'    => $plan->id,
                    'started_at' => now(),
                    'expires_at' => $expiresAt,
                    'status'     => 'active',
                ]);
            }
        } else {
            // Se selecionar "Sem plano", remove a assinatura do usuário
            if ($user->subscription) {
                $user->subscription->delete();
            }
        }

        return redirect()
            ->route('admin.users.index')
            ->with('success', 'Usuário atualizado com sucesso!');
    }


    public function destroy($id)
    {
        // Recupera o usuário pelo ID
        $user = User::findOrFail($id);

        // Deleta o usuário
        $user->delete();
        return redirect()->route('admin.users.index')
            ->with('success', 'Usuário deletado com sucesso!');
    }
}
