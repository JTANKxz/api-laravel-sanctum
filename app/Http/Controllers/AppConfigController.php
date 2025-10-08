<?php

namespace App\Http\Controllers;

use App\Models\AppConfig;
use Illuminate\Http\Request;

class AppConfigController extends Controller
{
    public function getCustomMessage()
    {
        $config = AppConfig::first(); // ou pega por ID se tiver mais de uma
        return response()->json([
            'enabled' => $config->enable_custom_message,
            'message' => $config->custom_message,
            //'type' => $config->custom_message_type
        ]);
    }
}
