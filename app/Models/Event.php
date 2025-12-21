<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $fillable = [
        'title',
        'subtitle',
        'sport',
        'home_team',
        'away_team',
        'start_time',
        'end_time',
        'status',
        'thumbnail_url',
        'is_featured'
    ];

    protected $casts = [
        'is_featured' => 'boolean',
    ];
    

    public function links()
    {
        return $this->hasMany(EventLink::class)->orderBy('order');
    }
}
