<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AppConfig;

class AppConfigController extends Controller
{
    public function index()
    {
        $config = AppConfig::first();

        return view('admin.config.index', compact('config'));
    }

    public function update(Request $request)
    {
        $config = AppConfig::firstOrFail();

        $data = $request->validate([
            'app_name' => 'required|string',
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

        $config->update($data);

        return redirect()
            ->route('admin.config.index')
            ->with('success', 'Configurações atualizadas com sucesso!');
    }
}

