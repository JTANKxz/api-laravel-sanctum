<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EventLink extends Model
{
    protected $table = 'event_links';

    protected $fillable = [
        'event_id',
        'name',
        'url',
        'type',        // m3u8 | embed
        'player_sub',  // free | premium
        'order'
    ];

    public function event()
    {
        return $this->belongsTo(Event::class);
    }
}
