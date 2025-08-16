<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AppConfig extends Model
{
    protected $table = 'app_config';

    protected $fillable = [
        'app_name',
        'app_logo',
        'app_version',
        'api_key',
        'force_update',
        'update_url',
        'update_message',
        'enable_custom_message',
        'custom_message',
        'tmdb_key'
    ];
}
