<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use App\Models\SaleItem;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ReportController extends Controller
{
    public function index(Request $request): View
    {
        [$from, $to] = $this->dateRange($request);
        $sales = $this->salesQuery($from, $to);
        $items = SaleItem::whereHas('sale', fn ($query) => $query->whereBetween('created_at', [$from->startOfDay(), $to->endOfDay()]));

        $summary = [
            'count' => (clone $sales)->count(),
            'revenue' => (clone $sales)->sum('total'),
            'cost' => (clone $items)->whereNotNull('unit_cost')->selectRaw('COALESCE(SUM(unit_cost * quantity), 0) as aggregate')->value('aggregate'),
            'uncosted' => (clone $items)->whereNull('unit_cost')->count(),
        ];
        $summary['profit'] = $summary['uncosted'] > 0 ? null : $summary['revenue'] - $summary['cost'];
        $daily = (clone $sales)
            ->selectRaw('DATE(created_at) as sale_date, COUNT(*) as transactions, SUM(total) as revenue')
            ->groupByRaw('DATE(created_at)')
            ->orderByDesc('sale_date')
            ->get();
        $sales = $sales->with('cashier')->withCount('items')->latest()->paginate(15)->withQueryString();

        return view('admin.reports', compact('from', 'to', 'summary', 'daily', 'sales'));
    }

    public function export(Request $request): StreamedResponse
    {
        [$from, $to] = $this->dateRange($request);
        $filename = 'laporan-penjualan-'.$from->format('Ymd').'-'.$to->format('Ymd').'.csv';

        return response()->streamDownload(function () use ($from, $to) {
            $output = fopen('php://output', 'w');
            if ($output === false) {
                throw new \RuntimeException('Tidak dapat membuka output ekspor laporan.');
            }

            fwrite($output, "\xEF\xBB\xBF");
            fputcsv($output, ['No. Transaksi', 'Tanggal', 'Kasir', 'Produk', 'Harga Jual', 'Harga Modal', 'Jumlah', 'Subtotal', 'Laba Kotor']);

            Sale::with(['cashier', 'items'])
                ->whereBetween('created_at', [$from->startOfDay(), $to->endOfDay()])
                ->orderBy('created_at')
                ->chunk(100, function ($sales) use ($output) {
                    foreach ($sales as $sale) {
                        foreach ($sale->items as $item) {
                            $profit = $item->unit_cost === null
                                ? 'Harga modal belum dicatat'
                                : (string) ($item->subtotal - ($item->unit_cost * $item->quantity));
                            fputcsv($output, [
                                $this->safeCsv($sale->invoice_number),
                                $sale->created_at->format('Y-m-d H:i:s'),
                                $this->safeCsv($sale->cashier->name),
                                $this->safeCsv($item->product_name),
                                $item->unit_price,
                                $item->unit_cost ?? '',
                                $item->quantity,
                                $item->subtotal,
                                $profit,
                            ]);
                        }
                    }
                });

            fclose($output);
        }, $filename, ['Content-Type' => 'text/csv; charset=UTF-8']);
    }

    /**
     * @return array{Carbon, Carbon}
     */
    private function dateRange(Request $request): array
    {
        $validated = $request->validate([
            'from' => ['nullable', 'date_format:Y-m-d'],
            'to' => ['nullable', 'date_format:Y-m-d', 'after_or_equal:from'],
        ]);

        return [
            Carbon::parse($validated['from'] ?? now()->startOfMonth()->toDateString())->startOfDay(),
            Carbon::parse($validated['to'] ?? now()->toDateString())->endOfDay(),
        ];
    }

    private function salesQuery(Carbon $from, Carbon $to)
    {
        return Sale::whereBetween('created_at', [$from->copy()->startOfDay(), $to->copy()->endOfDay()]);
    }

    private function safeCsv(string $value): string
    {
        return preg_match('/^[\s]*[=+\-@]/', $value) ? "'".$value : $value;
    }
}
