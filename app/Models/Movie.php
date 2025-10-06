<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Movie extends Model
{
    protected $fillable = [
        'tmdb_id',
        'imdb_id',
        'title',
        'slug',
        'year',
        'overview',
        'poster_url',
        'backdrop_url',
        'runtime',
        'rating',
        'content_type',
    ];

    public function genres()
    {
        return $this->morphToMany(Genre::class, 'genreable');
    }

    public function playLinks()
    {
        return $this->hasMany(MoviePlayLink::class);
    }

    public function watchlistedBy()
    {
        return $this->morphToMany(User::class, 'content', 'watchlist')->withTimestamps();
    }

    public function networks()
    {
        return $this->morphToMany(Network::class, 'networkable');
    }


    protected static function boot()
    {
        parent::boot();

        static::creating(function ($movie) {
            $movie->content_type = 'movie';
        });
    }
}
