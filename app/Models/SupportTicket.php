<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SupportTicket extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'category',
        'problem',
        'item_id',
        'item_type',
        'message',
        'app_version',
        'status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Retorna o item relacionado (movie, series ou tv)
     */
    public function item()
    {
        return match ($this->item_type) {
            'movie' => \App\Models\Movie::find($this->item_id),
            'series' => \App\Models\Serie::find($this->item_id),
            'tv' => \App\Models\TvChannel::find($this->item_id),
            default => null,
        };
    }
}
