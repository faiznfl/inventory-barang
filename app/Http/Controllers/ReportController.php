<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\StockTransaction;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ReportController extends Controller
{
    /**
     * Display a listing of reports and summary statistics.
     */
    public function index(Request $request): View
    {
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
        $type = $request->input('type');
        $categoryId = $request->input('category_id');

        $query = StockTransaction::with(['product.category', 'user'])->latest();

        if ($startDate) {
            $query->whereDate('transaction_date', '>=', $startDate);
        }

        if ($endDate) {
            $query->whereDate('transaction_date', '<=', $endDate);
        }

        if ($type && in_array($type, ['in', 'out'], true)) {
            $query->where('type', $type);
        }

        if ($categoryId) {
            $query->whereHas('product', function ($q) use ($categoryId): void {
                $q->where('category_id', $categoryId);
            });
        }

        $totalInQty = (int) (clone $query)->where('type', 'in')->sum('quantity');
        $totalOutQty = (int) (clone $query)->where('type', 'out')->sum('quantity');

        $reports = $query->paginate(15)->withQueryString();
        $categories = Category::orderBy('name')->get();

        return view('reports.index', compact(
            'reports',
            'categories',
            'totalInQty',
            'totalOutQty',
            'startDate',
            'endDate',
            'type',
            'categoryId'
        ));
    }

    /**
     * Export report to CSV format.
     */
    public function exportCsv(Request $request): StreamedResponse
    {
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
        $type = $request->input('type');
        $categoryId = $request->input('category_id');

        $query = StockTransaction::with(['product.category', 'user'])->latest();

        if ($startDate) {
            $query->whereDate('transaction_date', '>=', $startDate);
        }

        if ($endDate) {
            $query->whereDate('transaction_date', '<=', $endDate);
        }

        if ($type && in_array($type, ['in', 'out'], true)) {
            $query->where('type', $type);
        }

        if ($categoryId) {
            $query->whereHas('product', function ($q) use ($categoryId): void {
                $q->where('category_id', $categoryId);
            });
        }

        $fileName = 'laporan_mutasi_stok_'.now()->format('Y-m-d_His').'.csv';

        $headers = [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => "attachment; filename=\"{$fileName}\"",
            'Pragma' => 'no-cache',
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Expires' => '0',
        ];

        $callback = function () use ($query): void {
            $file = fopen('php://output', 'w');
            fwrite($file, "\xEF\xBB\xBF");

            fputcsv($file, [
                'No',
                'Tanggal',
                'SKU',
                'Nama Barang',
                'Kategori',
                'Jenis Transaksi',
                'Qty',
                'User Input',
                'Keterangan',
            ]);

            $no = 1;
            $query->chunk(100, function ($transactions) use ($file, &$no): void {
                foreach ($transactions as $transaction) {
                    $formattedDate = $transaction->transaction_date
                        ? $transaction->transaction_date->format('d/m/Y H:i')
                        : ($transaction->created_at ? $transaction->created_at->format('d/m/Y H:i') : '-');

                    fputcsv($file, [
                        $no++,
                        $formattedDate,
                        $transaction->product->sku ?? '-',
                        $transaction->product->name ?? '-',
                        $transaction->product->category->name ?? '-',
                        $transaction->type === 'in' ? 'Barang Masuk' : 'Barang Keluar',
                        $transaction->quantity,
                        $transaction->user->name ?? '-',
                        $transaction->notes ?? '-',
                    ]);
                }
            });

            fclose($file);
        };

        return response()->streamDownload($callback, $fileName, $headers);
    }

    /**
     * Export report to printable PDF view.
     */
    public function exportPdf(Request $request): View
    {
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
        $type = $request->input('type');
        $categoryId = $request->input('category_id');

        $query = StockTransaction::with(['product.category', 'user'])->latest();

        if ($startDate) {
            $query->whereDate('transaction_date', '>=', $startDate);
        }

        if ($endDate) {
            $query->whereDate('transaction_date', '<=', $endDate);
        }

        if ($type && in_array($type, ['in', 'out'], true)) {
            $query->where('type', $type);
        }

        if ($categoryId) {
            $query->whereHas('product', function ($q) use ($categoryId): void {
                $q->where('category_id', $categoryId);
            });
        }

        $reports = $query->get();

        $totalInQty = (int) $reports->where('type', 'in')->sum('quantity');
        $totalOutQty = (int) $reports->where('type', 'out')->sum('quantity');

        $selectedCategory = $categoryId ? Category::find($categoryId)?->name : null;

        return view('reports.pdf', compact(
            'reports',
            'totalInQty',
            'totalOutQty',
            'startDate',
            'endDate',
            'type',
            'selectedCategory'
        ));
    }
}
