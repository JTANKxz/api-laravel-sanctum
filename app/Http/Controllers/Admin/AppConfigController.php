<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AppConfig;


class AppConfigController extends Controller
{

    public function index(AppConfig $config)
    {
        return view('admin.config.index', compact('config'));
    }

    public function uptate(AppConfig $config)
    {
        $data = request()->validate([
            'app_name' => 'required',
            'app_logo' => 'nullable|string',
            'app_version' => 'required|string',
            'api_key' => 'required|string',
            'force_update' => 'required|boolean',
            'update_url' => 'nullable|string',
            'update_message' => 'nullable|string',
            'enable_custom_message' => 'required|boolean',
            'custom_message' => 'nullable|string',
            'tmdb_key' => 'required|string',
        ]);

        $config->update([
            'app_name' => $data['app_name'],
            'app_logo' => $data['app_logo'],
            'app_version' => $data['app_version'],
            'api_key' => $data['api_key'],
            'force_update' => $data['force_update'],
            'update_url' => $data['update_url'],
            'update_message' => $data['update_message'],
            'enable_custom_message' => $data['enable_custom_message'],
            'custom_message' => $data['custom_message'],
            'tmdb_key' => $data['tmdb_key'],
        ]);

        return redirect()
            ->route('admin.config.index')
            ->with('success', 'Configurações atualizadas com sucesso!');
    }
}
