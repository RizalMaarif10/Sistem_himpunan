<?php

namespace App\Http\Controllers\Bendahara;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use App\Models\Account;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class CashbookController extends Controller
{
    public function index(Request $r)
    {
        $year      = (int) $r->input('year', now()->year);
        $accountId = $r->input('account_id');         // null = semua rekening
        $q         = trim((string) $r->input('q', '')); // kata kunci (opsional)

        $startOfYear = Carbon::create($year, 1, 1)->startOfDay();

        // Dropdown rekening
        $accounts = Account::orderBy('name')->get(['id','name']);

        // ===== Base filter: 1 tahun =====
        $baseAll = Transaction::with(['category','account'])
            ->whereYear('date', $year)
            ->when($accountId, fn($q2) => $q2->where('account_id', $accountId))
            ->when($q !== '', function ($q2) use ($q) {
                $q2->where(function ($qq) use ($q) {
                    $qq->where('description', 'like', "%{$q}%")
                       ->orWhereHas('category', fn($c) => $c->where('name','like',"%{$q}%"))
                       ->orWhereHas('account',  fn($a) => $a->where('name','like',"%{$q}%"));
                });
            });

        // Ringkasan tahun berjalan
        $totalIncome  = (int) (clone $baseAll)->where('type','income')->sum('amount');
        $totalExpense = (int) (clone $baseAll)->where('type','expense')->sum('amount');

        // Saldo awal per 1 Jan tahun tsb (bergantung rekening saja)
        $opening = (int) Account::when($accountId, fn($aq) => $aq->where('id', $accountId))
            ->sum('opening_balance');

        $netBefore = (int) Transaction::when($accountId, fn($t) => $t->where('account_id', $accountId))
            ->where('date', '<', $startOfYear)
            ->sum(DB::raw("CASE WHEN type='income' THEN amount
                             WHEN type='expense' THEN -amount ELSE 0 END"));

        $saldoAwal  = $opening + $netBefore;
        $saldoAkhir = $saldoAwal + $totalIncome - $totalExpense;

        // Ambil semua transaksi setahun, urut naik
        $items = (clone $baseAll)->orderBy('date')->orderBy('id')->get();

        // Kelompokkan per bulan (1..12)
        $groupedByMonth = $items->groupBy(function ($t) {
            return (int) Carbon::parse($t->date)->month;
        });

        // Totals per bulan (untuk ditampilkan di header bulan)
        $perMonth = collect(range(1,12))->mapWithKeys(function ($m) use ($groupedByMonth) {
            $rows = $groupedByMonth->get($m, collect());
            $inc  = (int) $rows->where('type','income')->sum('amount');
            $exp  = (int) $rows->where('type','expense')->sum('amount');
            return [$m => ['income'=>$inc, 'expense'=>$exp, 'net'=>$inc-$exp, 'count'=>$rows->count()]];
        });

        return view('bendahara.cash.index', compact(
            'year','accountId','accounts','q',
            'saldoAwal','totalIncome','totalExpense','saldoAkhir',
            'groupedByMonth','perMonth'
        ));
    }
}
