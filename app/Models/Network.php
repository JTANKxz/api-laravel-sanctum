<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Network extends Model
{
    protected $fillable = ['name', 'slug', 'logo_url'];

    public function movies()
    {
        return $this->morphedByMany(Movie::class, 'networkable');
    }

    public function series()
    {
        return $this->morphedByMany(Serie::class, 'networkable');
    }
}
