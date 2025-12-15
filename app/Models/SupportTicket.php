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

        // 🔥 ITEM SELECIONADO NO APP
        'item_name',
        'item_type',

        'message',
        'app_version',
        'status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
