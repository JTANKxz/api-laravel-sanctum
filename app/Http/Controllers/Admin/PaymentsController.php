<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use Illuminate\Http\Request;

class PaymentsController extends Controller
{
    public function index()
    {
        $payments = Payment::with('user', 'plan')->get();
        return view('admin.payments.index', compact('payments'));
    }

    public function destroy(Payment $payment)
    {
        try {
            $payment->delete();
            return redirect()
                ->route('admin.payments.index')
                ->with('success', 'Status deletado com sucesso!');
        } catch (\Exception $e) {
            return redirect()
                ->route('admin.payments.index')
                ->with('error', 'Failed to delete payment status.');
        }
    }
}