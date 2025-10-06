<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SectionExplore extends Model
{
    use HasFactory;

    protected $table = 'sections_catalog';

    protected $fillable = [
        'title',
        'type',
        'reference_id',
        'order',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    /**
     * Escopo para pegar apenas seções ativas
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Retorna o item relacionado conforme o tipo da seção.
     */
    public function getReferenceAttribute()
    {
        return match ($this->type) {
            'genre' => $this->belongsTo(Genre::class, 'reference_id')->getResults(),
            'network' => $this->belongsTo(Network::class, 'reference_id')->getResults(),
            'genres_list' => $this->belongsTo(Genre::class, 'reference_id')->getResults(),
            'networks_list' => $this->belongsTo(Network::class, 'reference_id')->getResults(),
            // Os novos tipos 'collections_list', 'networks_list', 'genres_list' cairão aqui:
            // 'collection' => $this->belongsTo(Collection::class, 'reference_id')->getResults(),
            // 'custom' => $this->belongsTo(CustomSection::class, 'reference_id')->getResults(),
            default => null,
        };
    }
}
