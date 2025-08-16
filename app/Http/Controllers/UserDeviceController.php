<?php

// app/Http/Controllers/Api/UserDeviceController.php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\UserDevice;

class UserDeviceController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'fcm_token' => 'required|string',
        ]);

        $device = UserDevice::updateOrCreate(
            ['user_id' => $request->user()->id],
            ['fcm_token' => $request->fcm_token]
        );

        return response()->json([
            'success' => true,
            'device' => $device
        ]);
    }
}

