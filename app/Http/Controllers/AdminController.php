<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Sale;
use App\Models\Category;
use App\Models\Supplier;
use App\Models\User;
use Illuminate\View\View;

class AdminController extends Controller
{
    public function index(): View
    {
        return view('admin.dashboard', [
            'productCount' => Product::count(),
            'inventoryValue' => Product::selectRaw('COALESCE(SUM(price * stock), 0) as value')->value('value'),
            'costValue' => Product::whereNotNull('cost_price')->selectRaw('COALESCE(SUM(cost_price * stock), 0) as value')->value('value'),
            'categoryCount' => Category::count(),
            'supplierCount' => Supplier::count(),
            'userCount' => User::count(),
            'uncostedProducts' => Product::whereNull('cost_price')->count(),
            'lowStockProducts' => Product::where('stock', '<=', 10)->orderBy('stock')->orderBy('name')->limit(6)->get(),
            'todaySales' => Sale::whereDate('created_at', today())->count(),
            'todayRevenue' => Sale::whereDate('created_at', today())->sum('total'),
            'recentSales' => Sale::with('cashier')->latest()->limit(6)->get(),
        ]);
    }

    public function transactions(): View
    {
        $sales = Sale::with('cashier')->withCount('items')->latest()->paginate(15);

        return view('admin.transactions', compact('sales'));
    }
}
