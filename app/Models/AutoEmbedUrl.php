<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AutoEmbedUrl extends Model
{
    protected $table = 'auto_embed_urls';

    protected $fillable = [
        'name',
        'url',
        'id_type',
        'type',
        'player_sub',
        'quality',
        'active',
        'order',
        'content_type',
    ];

    protected $casts = [
        'active' => 'boolean',
        'order'  => 'integer',
    ];
}
