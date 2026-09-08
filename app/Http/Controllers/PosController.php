<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\Transaction;
use App\Models\TransactionDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PosController extends Controller
{
    public function index(Request $request)
    {
        $categories = Category::orderBy('nama_kategori')->get();
        $query = Product::where('stok', '>', 0)->with('category');

        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        $products = $query->orderBy('nama_menu')->get();
        $activeCategory = $request->category_id;

        return view('pos.index', compact('categories', 'products', 'activeCategory'));
    }

    public function checkout(Request $request)
    {
        $request->validate([
            'cart' => ['required', 'array', 'min:1'],
            'cart.*.product_id' => ['required', 'exists:products,id'],
            'cart.*.jumlah' => ['required', 'integer', 'min:1'],
            'jumlah_bayar' => ['required', 'integer', 'min:0'],
            'metode_bayar' => ['required', 'in:Cash,QRIS,Transfer'],
        ]);

        $cart = $request->cart;
        $metodeBayar = $request->metode_bayar;

        $productIds = array_column($cart, 'product_id');
        $products = Product::whereIn('id', $productIds)->lockForUpdate()->get()->keyBy('id');

        foreach ($cart as $item) {
            $product = $products[$item['product_id']] ?? null;
            if (!$product || $product->stok < $item['jumlah']) {
                return back()->with('error', "Stok {$product?->nama_menu} tidak mencukupi.")->withInput();
            }
        }

        $totalBayar = 0;
        foreach ($cart as $item) {
            $totalBayar += $products[$item['product_id']]->harga * $item['jumlah'];
        }

        if ($metodeBayar === 'Cash' && $request->jumlah_bayar < $totalBayar) {
            return back()->with('error', 'Jumlah bayar kurang dari total belanja.')->withInput();
        }

        $jumlahBayar = $metodeBayar === 'Cash' ? $request->jumlah_bayar : $totalBayar;
        $kembalian = $jumlahBayar - $totalBayar;

        $transaction = DB::transaction(function () use ($cart, $products, $totalBayar, $jumlahBayar, $kembalian, $metodeBayar) {
            $noInvoice = $this->generateInvoice();

            $trx = Transaction::create([
                'no_invoice' => $noInvoice,
                'user_id' => auth()->id(),
                'total_bayar' => $totalBayar,
                'jumlah_bayar' => $jumlahBayar,
                'kembalian' => $kembalian,
                'metode_bayar' => $metodeBayar,
                'tanggal' => now(),
            ]);

            foreach ($cart as $item) {
                $product = $products[$item['product_id']];
                TransactionDetail::create([
                    'transaction_id' => $trx->id,
                    'product_id' => $product->id,
                    'jumlah_beli' => $item['jumlah'],
                    'subtotal' => $product->harga * $item['jumlah'],
                ]);
                $product->decrement('stok', $item['jumlah']);
            }

            return $trx;
        });

        return redirect()->route('transactions.receipt', $transaction->id);
    }

    private function generateInvoice(): string
    {
        $date = now()->format('Ymd');
        $prefix = "INV-{$date}-";
        $last = Transaction::where('no_invoice', 'like', $prefix . '%')
            ->orderByDesc('id')
            ->value('no_invoice');

        $seq = $last ? (intval(substr($last, -4)) + 1) : 1;
        return $prefix . str_pad($seq, 4, '0', STR_PAD_LEFT);
    }
}
