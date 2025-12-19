<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContentView extends Model
{
    protected $fillable = [
        'content_id',
        'content_type',
        'device_id',
        'viewed_date',
    ];
}
