<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PremiumCode extends Model
{
    protected $table = 'premium_codes';

    protected $fillable = [
        'code',
        'plan_id',
        'max_uses',
        'used_count',
        'status',
    ];

    protected $casts = [
        'max_uses' => 'integer',
        'used_count' => 'integer',
    ];

    public function plan()
    {
        return $this->belongsTo(Plan::class);
    }
}
