@extends('bendahara.layouts.app')
@section('title','Dashboard')

@section('content')
<h1 class="text-3xl font-extrabold mb-1">Dashboard Bendahara</h1>
<p class="text-gray-600 mb-6">Halo, Bendahara HIMATEKNO — ringkasan kas & transaksi.</p>

<div class="grid md:grid-cols-3 gap-4 mb-6">
  <div class="rounded-2xl border bg-white p-5">
    <div class="text-xs uppercase tracking-wide text-gray-500">Saldo Saat Ini</div>
    <div class="mt-1 text-3xl font-extrabold">
      Rp {{ number_format($saldoSaatIni,0,',','.') }}
    </div>
  </div>

  <div class="rounded-2xl border bg-white p-5">
    <div class="text-xs uppercase tracking-wide text-gray-500">Pemasukan Bulan Ini</div>
    <div class="mt-1 text-3xl font-extrabold">
      Rp {{ number_format($totalPemasukan,0,',','.') }}
    </div>
  </div>

  <div class="rounded-2xl border bg-white p-5">
    <div class="text-xs uppercase tracking-wide text-gray-500">Pengeluaran Bulan Ini</div>
    <div class="mt-1 text-3xl font-extrabold">
      Rp {{ number_format($totalPengeluaran,0,',','.') }}
    </div>
  </div>
</div>

<div class="grid md:grid-cols-2 gap-4 mb-6">
  <a href="{{ route('bendahara.incomes.create') }}"
     class="rounded-2xl border bg-slate-900 text-white text-center px-5 py-4 hover:bg-slate-800">
     + Tambah Pemasukan
  </a>
  <a href="{{ route('bendahara.expenses.create') }}"
     class="rounded-2xl border bg-white text-center px-5 py-4 hover:bg-gray-50">
     + Tambah Pengeluaran
  </a>
</div>

<div class="rounded-2xl border bg-white overflow-hidden">
  <div class="px-5 py-4 border-b bg-gray-50 font-semibold">Transaksi Terbaru</div>

  @if($latest->isEmpty())
    <div class="px-5 py-6 text-gray-500">Belum ada data transaksi.</div>
  @else
    <table class="min-w-full text-sm">
      <thead class="bg-gray-50">
        <tr>
          <th class="px-4 py-2 text-left">Tanggal</th>
          <th class="px-4 py-2 text-left">Kategori</th>
          <th class="px-4 py-2 text-left">Rekening</th>
          <th class="px-4 py-2 text-right">Pemasukan</th>
          <th class="px-4 py-2 text-right">Pengeluaran</th>
        </tr>
      </thead>
      <tbody>
        @foreach($latest as $t)
          <tr class="border-t">
            <td class="px-4 py-2">{{ \Carbon\Carbon::parse($t->date)->translatedFormat('d M Y') }}</td>
            <td class="px-4 py-2">{{ $t->category->name ?? '-' }}</td>
            <td class="px-4 py-2">{{ $t->account->name ?? '-' }}</td>
            <td class="px-4 py-2 text-right">
              {{ $t->type==='income' ? 'Rp '.number_format($t->amount,0,',','.') : '-' }}
            </td>
            <td class="px-4 py-2 text-right">
              {{ $t->type==='expense' ? 'Rp '.number_format($t->amount,0,',','.') : '-' }}
            </td>
          </tr>
        @endforeach
      </tbody>
    </table>
  @endif
</div>
@endsection
