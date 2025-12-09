<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * ===========================
     * Relações
     * ===========================
     */

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function watchlistMovies(): MorphToMany
    {
        return $this->morphedByMany(Movie::class, 'content', 'watchlist')->withTimestamps();
    }

    public function watchlistSeries(): MorphToMany
    {
        return $this->morphedByMany(Serie::class, 'content', 'watchlist')->withTimestamps();
    }

    public function subscription()
    {
        return $this->hasOne(UserSubscription::class);
    }

    /**
     * Lista unificada de todos os conteúdos salvos
     */
    public function watchlistItems()
    {
        return collect()
            ->merge($this->watchlistMovies)
            ->merge($this->watchlistSeries)
            ->sortByDesc('pivot.created_at');
    }

    /**
     * ===========================
     * Lógica de Assinatura
     * ===========================
     */

    /**
     * Retorna true se o usuário tiver uma assinatura ativa
     */
    public function hasActiveSubscription(): bool
    {
        $subscription = $this->subscription;

        return $subscription
            && !$subscription->isExpired()
            && $subscription->status === 'active';
    }

    public function checkSubscriptionExpiration(): void
    {
        $subscription = $this->subscription;

        if (!$subscription) {
            return;
        }

        // Se tem expires_at e já passou, e ainda não está 'expired'
        if (
            $subscription->expires_at
            && now()->isAfter($subscription->expires_at)
            && $subscription->status !== 'expired'
        ) {
            $subscription->update([
                'status' => 'expired'
            ]);
        }
    }

    /**
     * Retorna o plano atual do usuário (ou null)
     */
    public function currentPlan()
    {
        return $this->subscription?->plan;
    }

    /**
     * Verifica se o usuário possui um benefício específico
     */
    public function hasBenefit($key): bool
    {
        $subscription = $this->subscription;

        if (!$subscription || $subscription->isExpired()) {
            return false;
        }

        $plan = $subscription->plan;

        if (!$plan || empty($plan->benefits)) {
            return false;
        }

        return in_array($key, $plan->benefits);
    }

    /**
     * Verifica se o usuário é premium
     */
    public function isPremium(): bool
    {
        $subscription = $this->subscription;

        // Se não tem assinatura → não é premium
        if (!$subscription) {
            return false;
        }

        // Considera premium apenas se status é 'active'
        return $subscription->status === 'active';
    }


    /**
     * Retorna um array resumido para o app (usado no /api/me)
     */
    public function toProfileArray(): array
    {
        $subscription = $this->subscription;
        $plan = $subscription?->plan;

        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'is_premium' => $this->isPremium(),
            'subscription' => [
                'plan' => $plan?->name,
                'expires_at' => $subscription?->expires_at,
                'status' => $subscription?->status,
            ],
        ];
    }
}
