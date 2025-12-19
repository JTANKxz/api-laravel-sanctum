<?php

namespace App\Http\Controllers;

use App\Models\ContentView;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;


class RankingController extends Controller
{
    public function topWeek()
    {
        $top = ContentView::select(
            'content_id',
            'content_type',
            'title',
            'poster_url',
            DB::raw('COUNT(*) as total_views')
        )
            ->where('created_at', '>=', now()->subDays(7))
            ->groupBy('content_id', 'content_type', 'title', 'poster_url')
            ->orderByDesc('total_views')
            ->limit(10)
            ->get();

        return response()->json($top);
    }

    public function topMovies()
    {
        return ContentView::select(
            'content_id',
            DB::raw('COUNT(*) as total_views')
        )
            ->where('content_type', 'movie')
            ->where('created_at', '>=', now()->subDays(30))
            ->groupBy('content_id')
            ->orderByDesc('total_views')
            ->limit(10)
            ->get();
    }

    public function topSeries()
    {
        return ContentView::select(
            'content_id',
            DB::raw('COUNT(*) as total_views')
        )
            ->where('content_type', 'series')
            ->where('created_at', '>=', now()->subDays(30))
            ->groupBy('content_id')
            ->orderByDesc('total_views')
            ->limit(10)
            ->get();
    }
}
