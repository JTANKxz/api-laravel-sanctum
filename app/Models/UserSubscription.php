<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserSubscription extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'plan_id', 'started_at', 'expires_at', 'status'];

    protected $casts = [
        'started_at' => 'datetime',
        'expires_at' => 'datetime',
    ];

    public function plan()
    {
        return $this->belongsTo(Plan::class);
    }

    public function isExpired()
    {
        return $this->expires_at && now()->greaterThan($this->expires_at);
    }
}
