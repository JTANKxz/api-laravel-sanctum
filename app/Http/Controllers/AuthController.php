<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    /**
     * Registro de novo usuário
     */
    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6',
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
        ]);

        // Criar assinatura gratuita SEM precisar existir plano
        $user->subscription()->create([
            'plan_id'    => 0,              // valor fixo para representar "Free"
            'started_at' => now(),
            'expires_at' => null,
            'status'     => 'active',
        ]);

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'user' => $this->formatUser($user),
            'token' => $token,
            'token_type' => 'Bearer',
        ], 201);
    }


    /**
     * Login do usuário
     */
    public function login(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|email|max:255',
            'password' => 'required|string|min:6',
        ]);

        if (!Auth::attempt($validated)) {
            return response()->json(['message' => 'Credenciais inválidas'], 401);
        }

        $user = User::where('email', $validated['email'])->first();

        /**
         * ----------------------------------------
         * CRIA ASSINATURA FREE SE NÃO EXISTIR
         * ----------------------------------------
         */
        if (!$user->subscription) {
            $user->subscription()->create([
                'plan_id' => null,     // plano free
                'status' => 'active',
                'started_at' => now(),
                'expires_at' => null,  // sem expiração
            ]);
        }

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'user' => $this->formatUser($user),
            'token' => $token,
            'token_type' => 'Bearer',
        ]);
    }

    /**
     * Retorna o perfil do usuário logado
     */
    public function me(Request $request)
    {
        return response()->json([
            'user' => $this->formatUser($request->user())
        ]);
    }

    /**
     * Faz logout (revoga todos os tokens do usuário)
     */
    public function logout(Request $request)
    {
        $user = $request->user();
        if ($user) {
            $user->tokens()->delete();
        }

        Auth::logout();

        return response()->json(['message' => 'Logout realizado com sucesso']);
    }

    /**
     * Formata o retorno padrão do usuário
     */
    private function formatUser(User $user)
    {
        $subscription = $user->subscription;

        return [
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'is_premium' => $user->isPremium(),
            'subscription' => $subscription ? [
                'plan' => $subscription->plan_id === null
                    ? 'Free'
                    : ($subscription->plan->name ?? null),
                'expires_at' => $subscription->expires_at,
                'status' => $subscription->status,
            ] : null,
        ];
    }
}
