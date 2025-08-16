<?php

// app/Models/UserDevice.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserDevice extends Model
{
    protected $fillable = ['user_id', 'fcm_token'];
}
