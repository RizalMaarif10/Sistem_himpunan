@extends('bendahara.layouts.app')
@section('title','Buku Kas (Tahunan)')

@section('content')
<h1 class="text-3xl font-extrabold mb-1">Buku Kas</h1>
<p class="text-gray-600 mb-4">Periode: <strong>Tahun {{ $year }}</strong></p>

<form method="GET" class="grid md:grid-cols-12 gap-3 mb-6 items-end">
  <div class="md:col-span-2">
    <label class="block text-xs font-medium text-gray-600 mb-1">Tahun</label>
    <input type="number" name="year" value="{{ $year }}" class="w-full border rounded-lg px-3 py-2">
  </div>

  <div class="md:col-span-4">
    <label class="block text-xs font-medium text-gray-600 mb-1">Rekening</label>
    <select name="account_id" class="w-full border rounded-lg px-3 py-2">
      <option value="">Semua Rekening</option>
      @foreach($accounts as $acc)
        <option value="{{ $acc->id }}" {{ (string)$accountId === (string)$acc->id ? 'selected' : '' }}>
          {{ $acc->name }}
        </option>
      @endforeach
    </select>
  </div>

  <div class="md:col-span-6">
    <label class="block text-xs font-medium text-gray-600 mb-1">Kata kunci</label>
    <input type="text" name="q" value="{{ $q }}" placeholder="Deskripsi / kategori / rekening…"
           class="w-full border rounded-lg px-3 py-2">
  </div>

  <div class="md:col-span-3 flex gap-2">
    <button class="px-4 py-2 rounded-lg border bg-white hover:bg-gray-50 w-full">Terapkan</button>
    <a href="{{ route('bendahara.cash.index') }}" class="px-4 py-2 rounded-lg border w-full text-center">Reset</a>
  </div>
</form>

<div class="text-sm text-gray-600 mb-3">
  Saldo awal 1 Jan {{ $year }}:
  <span class="font-semibold text-gray-800">Rp {{ number_format($saldoAwal,0,',','.') }}</span>
</div>

<div class="grid md:grid-cols-3 gap-3 mb-5">
  <div class="rounded-xl border bg-white p-4">
    <div class="text-xs uppercase text-gray-500">Total Pemasukan ({{ $year }})</div>
    <div class="text-xl font-bold">Rp {{ number_format($totalIncome,0,',','.') }}</div>
  </div>
  <div class="rounded-xl border bg-white p-4">
    <div class="text-xs uppercase text-gray-500">Total Pengeluaran ({{ $year }})</div>
    <div class="text-xl font-bold">Rp {{ number_format($totalExpense,0,',','.') }}</div>
  </div>
  <div class="rounded-xl border bg-white p-4">
    <div class="text-xs uppercase text-gray-500">Saldo Akhir Tahun</div>
    <div class="text-xl font-extrabold">Rp {{ number_format($saldoAkhir,0,',','.') }}</div>
  </div>
</div>

<div class="rounded-xl border bg-white overflow-hidden">
  <table class="min-w-full text-sm">
    <thead class="bg-gray-50">
      <tr>
        <th class="px-4 py-2 text-left">Tanggal</th>
        <th class="px-4 py-2 text-left">Keterangan</th>
        <th class="px-4 py-2 text-left">Kategori</th>
        <th class="px-4 py-2 text-left">Rekening</th>
        <th class="px-4 py-2 text-right">Pemasukan</th>
        <th class="px-4 py-2 text-right">Pengeluaran</th>
      </tr>
    </thead>
    <tbody>
      @php $totalRows = 0; @endphp

      @for($m=1; $m<=12; $m++)
        @php
          $rows = $groupedByMonth->get($m, collect());
          $info = $perMonth[$m];
          $totalRows += $rows->count();
        @endphp

        {{-- Header bulan --}}
        <tr class="bg-gray-50 border-t">
          <td colspan="6" class="px-4 py-2 font-semibold">
            {{ \Carbon\Carbon::create()->month($m)->translatedFormat('F') }} {{ $year }}
            <span class="text-gray-500 font-normal text-xs">
              — pemasukan: Rp {{ number_format($info['income'],0,',','.') }},
              pengeluaran: Rp {{ number_format($info['expense'],0,',','.') }},
              netto: Rp {{ number_format($info['net'],0,',','.') }},
              transaksi: {{ $info['count'] }}
            </span>
          </td>
        </tr>

        @forelse($rows as $t)
          <tr class="border-t">
            <td class="px-4 py-2">{{ \Carbon\Carbon::parse($t->date)->translatedFormat('d M Y') }}</td>
            <td class="px-4 py-2">{{ $t->description ?: '-' }}</td>
            <td class="px-4 py-2">{{ $t->category->name ?? '-' }}</td>
            <td class="px-4 py-2">{{ $t->account->name ?? '-' }}</td>
            <td class="px-4 py-2 text-right">
              {{ $t->type==='income' ? 'Rp '.number_format($t->amount,0,',','.') : '-' }}
            </td>
            <td class="px-4 py-2 text-right">
              {{ $t->type==='expense' ? 'Rp '.number_format($t->amount,0,',','.') : '-' }}
            </td>
          </tr>
        @empty
          <tr class="border-t">
            <td colspan="6" class="px-4 py-2 text-gray-500">Tidak ada transaksi.</td>
          </tr>
        @endforelse
      @endfor
    </tbody>
  </table>

  <div class="p-4 text-sm text-gray-600">
    Total baris transaksi tahun ini: {{ $totalRows }}
  </div>
</div>
@endsection
