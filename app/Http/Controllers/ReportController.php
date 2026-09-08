<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $request->validate([
            'dari' => ['nullable', 'date'],
            'sampai' => ['nullable', 'date', 'after_or_equal:dari'],
        ]);

        $dari = $request->dari ?? now()->toDateString();
        $sampai = $request->sampai ?? now()->toDateString();

        $transactions = Transaction::with('user', 'details')
            ->whereBetween('tanggal', [$dari . ' 00:00:00', $sampai . ' 23:59:59'])
            ->latest('tanggal')
            ->get();

        $totalOmzet = $transactions->sum('total_bayar');
        $totalTransaksi = $transactions->count();
        $totalItem = $transactions->flatMap->details->sum('jumlah_beli');

        return view('admin.reports.index', compact(
            'transactions', 'totalOmzet', 'totalTransaksi', 'totalItem', 'dari', 'sampai'
        ));
    }
}
