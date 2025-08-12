<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\TVChannel;

class ChannelsController extends Controller {
    public function index() 
    {
        $channels = TVChannel::with('links')->orderBy('name')->get();
        return response()->json($channels);
    }

    // public function show($id) 
    // {
    //     $channel = TVChannel::findOrFail($id);
    //     return response()->json($channel);
    // }

}