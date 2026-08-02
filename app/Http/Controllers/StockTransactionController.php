<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreStockTransactionRequest;
use App\Models\Product;
use App\Models\StockTransaction;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class StockTransactionController extends Controller
{
    /**
     * Display a listing of stock transactions and forms.
     */
    public function index(Request $request): View
    {
        $products = Product::orderBy('name')->get();

        $query = StockTransaction::with(['product', 'user'])->latest();

        if ($type = $request->input('type')) {
            if (in_array($type, ['in', 'out'], true)) {
                $query->where('type', $type);
            }
        }

        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search): void {
                $q->where('reference_no', 'like', "%{$search}%")
                    ->orWhere('notes', 'like', "%{$search}%")
                    ->orWhereHas('product', function ($pq) use ($search): void {
                        $pq->where('name', 'like', "%{$search}%")
                            ->orWhere('sku', 'like', "%{$search}%");
                    });
            });
        }

        $transactions = $query->paginate(10)->withQueryString();

        return view('stock-transactions.index', compact('transactions', 'products'));
    }

    /**
     * Store a newly created stock transaction in storage.
     */
    public function store(StoreStockTransactionRequest $request): RedirectResponse
    {
        $validated = $request->validated();
        $qty = (int) $validated['quantity'];
        $type = $validated['type'];

        try {
            DB::transaction(function () use ($validated, $qty, $type): void {
                $product = Product::where('id', $validated['product_id'])
                    ->lockForUpdate()
                    ->firstOrFail();

                if ($type === 'out' && $product->stock < $qty) {
                    throw new \InvalidArgumentException("Stok tidak mencukupi. Stok saat ini: {$product->stock}, permintaan: {$qty}.");
                }

                $initialStock = $product->stock;
                $finalStock = $type === 'in' ? $initialStock + $qty : $initialStock - $qty;

                $product->update([
                    'stock' => $finalStock,
                ]);

                StockTransaction::create([
                    'product_id' => $product->id,
                    'user_id' => auth()->id(),
                    'type' => $type,
                    'quantity' => $qty,
                    'initial_stock' => $initialStock,
                    'final_stock' => $finalStock,
                    'reference_no' => $validated['reference_no'],
                    'notes' => $validated['notes'] ?? null,
                    'transaction_date' => $validated['transaction_date'] ?? now(),
                ]);
            });
        } catch (\InvalidArgumentException $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', $e->getMessage());
        }

        $msgType = $type === 'in' ? 'masuk' : 'keluar';

        return redirect()->route('stock-transactions.index', ['tab' => 'riwayat'])
            ->with('success', "Transaksi barang {$msgType} berhasil diproses.");
    }
}
