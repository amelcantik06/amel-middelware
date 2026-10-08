<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\StockReceipt;
use App\Models\Supplier;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class StockReceiptController extends Controller
{
    public function index(): View
    {
        $products = Product::orderBy('name')->get();
        $suppliers = Supplier::orderBy('name')->get();
        $receipts = StockReceipt::with(['supplier', 'receiver', 'items'])
            ->withCount('items')
            ->latest()
            ->paginate(15);

        return view('admin.stock', compact('products', 'suppliers', 'receipts'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'supplier_id' => ['nullable', 'integer', 'exists:suppliers,id'],
            'notes' => ['nullable', 'string', 'max:2000'],
            'items' => ['required', 'array', 'min:1'],
            'items.*.product_id' => ['required', 'integer', 'distinct', 'exists:products,id'],
            'items.*.quantity' => ['required', 'integer', 'min:1', 'max:1000000'],
            'items.*.unit_cost' => ['required', 'integer', 'min:0'],
        ]);

        DB::transaction(function () use ($validated) {
            $quantities = collect($validated['items'])
                ->mapWithKeys(fn (array $item) => [(int) $item['product_id'] => (int) $item['quantity']]);
            $products = Product::whereIn('id', $quantities->keys())
                ->orderBy('id')
                ->lockForUpdate()
                ->get()
                ->keyBy('id');

            if ($products->count() !== $quantities->count()) {
                throw ValidationException::withMessages(['items' => 'Salah satu produk tidak lagi tersedia.']);
            }

            $totalCost = 0;
            foreach ($validated['items'] as $item) {
                $totalCost += (int) $item['quantity'] * (int) $item['unit_cost'];
            }

            $receipt = StockReceipt::create([
                'receipt_number' => 'STK-'.now()->format('Ymd-His').'-'.Str::upper(Str::random(4)),
                'supplier_id' => $validated['supplier_id'] ?? null,
                'received_by' => auth()->id(),
                'total_cost' => $totalCost,
                'notes' => $validated['notes'] ?? null,
            ]);

            foreach ($validated['items'] as $item) {
                $product = $products->get((int) $item['product_id']);
                $quantity = (int) $item['quantity'];
                $unitCost = (int) $item['unit_cost'];
                $receipt->items()->create([
                    'product_id' => $product->id,
                    'product_name' => $product->name,
                    'unit_cost' => $unitCost,
                    'quantity' => $quantity,
                    'subtotal' => $quantity * $unitCost,
                ]);
                $product->stock += $quantity;
                $product->cost_price = $unitCost;
                $product->save();
            }
        });

        return redirect()->route('admin.stock')->with('success', 'Stok masuk berhasil dicatat dan inventaris diperbarui.');
    }
}
