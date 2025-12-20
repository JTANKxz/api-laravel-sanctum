<?php

namespace App\Http\Controllers;

use App\Models\TVChannelCategory;

class ChannelsController extends Controller
{
    public function index()
    {
        $categories = TVChannelCategory::with([
            'channels' => function ($query) {
                $query->with('links')->orderBy('name');
            }
        ])
        ->orderBy('name')
        ->get();

        return response()->json($categories);
    }
}
