<?php

namespace App\Http\Controllers;

use App\Models\AppConfig;
use Illuminate\Http\Request;

class AppConfigController extends Controller
{
    public function getConfig()
    {
        $config = AppConfig::first(); // ou pega por ID se tiver mais de uma
        return response()->json([
            'app_name' => $config->app_name,
            'app_logo' => $config->app_logo,
            'app_version' => $config->app_version,
            'api_key' => $config->api_key
        ]);
    }

    public function getCustomMessage()
    {
        $config = AppConfig::first(); // ou pega por ID se tiver mais de uma
        return response()->json([
            'enabled' => $config->enable_custom_message,
            'message' => $config->custom_message,
            //'type' => $config->custom_message_type
        ]);
    }

    public function getAppUptade()
    {
        $config = AppConfig::first(); // ou pega por ID se tiver mais de uma
        return response()->json([
            'enable_update' => $config->enable_update,
            'update_message' => $config->update_message,
            'force_update' => $config->force_update,
            'update_url' => $config->update_url,
            'update_type' => $config->update_type,
            'min_version' => $config->min_version,
            'app_version' => $config->app_version
        ]);
    }

    public function getAppName()
    {
        $config = AppConfig::first(); // ou pega por ID se tiver mais de uma
        return response()->json([
            'app_name' => $config->app_name
        ]);
    }
}
