<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TVChannelCategory extends Model
{
    protected $table = 'tv_channel_categories';

    protected $fillable = ['name', 'slug'];

    public function channels()
    {
        return $this->belongsToMany(
            TVChannel::class,
            'tv_channel_category',
            'tv_channel_category_id',
            'tv_channel_id'
        );
    }
}



