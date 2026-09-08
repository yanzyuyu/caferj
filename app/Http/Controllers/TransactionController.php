<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function history(Request $request)
    {
        $query = Transaction::with('user')->latest('tanggal');

        if (auth()->user()->role === 'kasir') {
            $query->where('user_id', auth()->id());
        }

        $transactions = $query->paginate(20);
        return view('pos.history', compact('transactions'));
    }

    public function show(Transaction $transaction)
    {
        if (auth()->user()->role === 'kasir' && $transaction->user_id !== auth()->id()) {
            abort(403);
        }
        $transaction->load('details.product', 'user');
        return view('pos.show', compact('transaction'));
    }

    public function receipt(Transaction $transaction)
    {
        if (auth()->user()->role === 'kasir' && $transaction->user_id !== auth()->id()) {
            abort(403);
        }
        $transaction->load('details.product', 'user');
        return view('pos.receipt', compact('transaction'));
    }
}
