<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CustomHomeSectionItem extends Model
{
    protected $fillable = [
        'section_id',
        'content_id',
        'content_type',
        'order',
    ];

    public function section()
    {
        return $this->belongsTo(CustomHomeSection::class, 'section_id');
    }

    // Substitui o morphTo por um accessor seguro
    public function getContentAttribute()
    {
        $classMap = [
            'movie' => \App\Models\Movie::class,
            'serie' => \App\Models\Serie::class,
        ];

        $class = $classMap[$this->content_type] ?? null;

        if ($class && class_exists($class)) {
            return $class::find($this->content_id);
        }

        return null;
    }
}
