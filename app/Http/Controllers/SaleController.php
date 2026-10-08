<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class SaleController extends Controller
{
    public function show(Sale $sale): View|RedirectResponse
    {
        if (Auth::user()->role !== 'admin' && $sale->user_id !== Auth::id()) {
            abort(403, 'Anda tidak dapat melihat transaksi ini.');
        }

        $sale->load(['cashier', 'items']);

        return view('sales.show', compact('sale'));
    }
}
