<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::with('user.subscription')
            ->orderByDesc('id')
            ->paginate(30);

        return view('admin.orders.index', compact('orders'));
    }

    public function import(Order $order)
    {
        if (! $order->isPending()) {
            return back()->with('error', 'Pedido não pode ser importado.');
        }

        try {
            $tmdb = app(TmdbController::class);

            if ($order->type === 'movie') {
                $tmdb->importMovieByTmdbId($order->tmdb_id);
            }

            if ($order->type === 'tv') {
                $tmdb->importFullSerieByTmdbId($order->tmdb_id);

            }

            $order->update([
                'status' => 'imported'
            ]);

            return back()->with('success', 'Conteúdo importado com sucesso.');
        } catch (\Throwable $e) {

            $order->update([
                'status' => 'failed'
            ]);

            report($e);

            return back()->with('error', 'Erro ao importar conteúdo.');
        }
    }


    public function cancel(Order $order)
    {
        if ($order->status !== 'pending') {
            return back()->with('error', 'Pedido não pode ser cancelado.');
        }

        $order->update([
            'status' => 'cancelled'
        ]);

        return back()->with('success', 'Pedido cancelado.');
    }

    public function destroy(Order $order)
    {
        $order->delete();

        return back()->with('success', 'Pedido apagado.');
    }
}
