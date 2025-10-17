<?php

namespace App\Http\Controllers\Bendahara;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use App\Models\Transaction;
use App\Models\Account;

class DashboardController extends Controller
{
    public function index()
    {
        $saldoSaatIni     = 0;
        $totalPemasukan   = 0;
        $totalPengeluaran = 0;
        $latest           = collect();

        $hasTrans = Schema::hasTable('transactions');
        $hasAcc   = Schema::hasTable('accounts');

        if ($hasTrans) {
            $month = now()->month;
            $year  = now()->year;

            // Bulan berjalan
            $totalPemasukan = (int) DB::table('transactions')
                ->where('type', 'income')
                ->whereMonth('date', $month)
                ->whereYear('date', $year)
                ->sum('amount');

            $totalPengeluaran = (int) DB::table('transactions')
                ->where('type', 'expense')
                ->whereMonth('date', $month)
                ->whereYear('date', $year)
                ->sum('amount');

            // Saldo semua waktu = opening balance seluruh akun + net transaksi
            $opening = $hasAcc ? (int) DB::table('accounts')->sum('opening_balance') : 0;

            $netAll = (int) DB::table('transactions')->selectRaw("
                SUM(CASE WHEN type='income'  THEN amount
                         WHEN type='expense' THEN -amount
                         ELSE 0 END) as net")
                ->value('net');

            $saldoSaatIni = $opening + $netAll;

            // Transaksi terbaru
            $latest = Transaction::with(['category:id,name', 'account:id,name'])
                ->orderByDesc('date')
                ->orderByDesc('id')
                ->limit(8)
                ->get();
        }

        return view('bendahara.dashboard', compact(
            'saldoSaatIni', 'totalPemasukan', 'totalPengeluaran', 'latest'
        ));
    }
}
