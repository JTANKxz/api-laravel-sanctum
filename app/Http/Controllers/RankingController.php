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
            DB::raw('COUNT(*) as total_views')
        )
            ->where('created_at', '>=', now()->subDays(7))
            ->groupBy('content_id', 'content_type')
            ->orderByDesc('total_views')
            ->limit(10)
            ->get();

        // Preencher title e poster de acordo com o tipo
        $top->transform(function ($item) {
            if ($item->content_type === 'movie') {
                $movie = DB::table('movies')->where('id', $item->content_id)->first();
                $item->title = $movie->title ?? 'Sem título';
                $item->poster_url = $movie->poster_url ?? null;
            } elseif ($item->content_type === 'series') {
                $serie = DB::table('series')->where('id', $item->content_id)->first();
                $item->title = $serie->title ?? 'Sem título';
                $item->poster_url = $serie->poster_url ?? null;
            }
            return $item;
        });

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
