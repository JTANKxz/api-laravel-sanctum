<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Plan extends Model
{
    protected $fillable = [
        'name',
        'price',
        'duration_days',
        'benefits',
        'cakto_offer_id', // 👈 ADD
    ];

    protected $casts = [
        'benefits' => 'array',
    ];
}
