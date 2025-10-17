<?php

namespace App\Http\Controllers\Bendahara;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use App\Models\Category;
use App\Models\Account;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ReportController extends Controller
{
    public function index(Request $r)
    {
        $scope       = $r->input('scope', 'monthly');      // 'monthly' | 'yearly'
        $month       = (int) $r->input('month', now()->month);
        $year        = (int) $r->input('year',  now()->year);
        $category_id = $r->input('category_id');           // null = semua kategori
        $q           = trim((string) $r->input('q',''));    // cari nama kategori / deskripsi / rekening

        $categories  = Category::orderBy('name')->get(['id','name']);

        if ($scope === 'yearly') {
            // ===== REKAP 12 BULAN =====
            $perMonth = Transaction::selectRaw("
                    MONTH(date) as m,
                    SUM(CASE WHEN type='income'  THEN amount ELSE 0 END) as income,
                    SUM(CASE WHEN type='expense' THEN amount ELSE 0 END) as expense
                ")
                ->whereYear('date', $year)
                ->when($category_id, fn($q2) => $q2->where('category_id', $category_id))
                ->groupBy('m')
                ->orderBy('m')
                ->get();

            return view('bendahara.reports.index', compact(
                'scope', 'month', 'year', 'categories', 'category_id', 'q', 'perMonth'
            ));
        }

        // ===== BULANAN =====
        $startOfMonth = Carbon::create($year, $month, 1)->startOfDay();
        $endOfMonth   = (clone $startOfMonth)->endOfMonth();

        // BASE (untuk tabel & rekap kategori) → menghormati filter kategori & q
        $base = Transaction::with(['category:id,name,type','account:id,name'])
            ->whereBetween('date', [$startOfMonth, $endOfMonth])
            ->when($category_id, fn($q2) => $q2->where('category_id', $category_id))
            ->when($q !== '', function ($q2) use ($q) {
                $q2->where(function ($qq) use ($q) {
                    $qq->where('description', 'like', "%{$q}%")
                       ->orWhereHas('category', fn($c) => $c->where('name','like',"%{$q}%"))
                       ->orWhereHas('account',  fn($a) => $a->where('name','like',"%{$q}%"));
                });
            });

        // --- METRIK KARTU (TOTAL KAS – tidak terfilter kategori) ---
        // Kenapa total? Agar rumus saldo selalu valid:
        // Saldo Akhir = Saldo Awal + Pemasukan − Pengeluaran
        $openingAll = (int) Account::sum('opening_balance'); // jika tidak ada kolom ini, ganti 0
        $netBefore  = (int) Transaction::where('date', '<', $startOfMonth)->sum(DB::raw("
            CASE WHEN type='income' THEN amount
                 WHEN type='expense' THEN -amount ELSE 0 END
        "));
        $saldo_awal_bulan = $openingAll + $netBefore;

        $monthAll = Transaction::whereBetween('date', [$startOfMonth, $endOfMonth]);
        $income   = (int) (clone $monthAll)->where('type','income')->sum('amount');   // untuk kartu
        $expense  = (int) (clone $monthAll)->where('type','expense')->sum('amount');  // untuk kartu
        $saldo    = $saldo_awal_bulan + $income - $expense;                           // ✅ rumus benar

        // --- REKAP PER KATEGORI (menghormati filter kategori & q) ---
        $byCategory = (clone $base)
            ->selectRaw("
                category_id,
                SUM(CASE WHEN type='income'  THEN amount ELSE 0 END) as pemasukan,
                SUM(CASE WHEN type='expense' THEN amount ELSE 0 END) as pengeluaran
            ")
            ->groupBy('category_id')
            ->with('category:id,name,type')
            ->get();

        // --- RINCIAN TRANSAKSI (untuk tabel bawah; menghormati filter) ---
        $txList = (clone $base)->orderBy('date')->orderBy('id')->get();

        return view('bendahara.reports.index', compact(
            'scope','month','year','categories','category_id','q',
            'income','expense','saldo','saldo_awal_bulan','byCategory','txList'
        ));
    }
}
