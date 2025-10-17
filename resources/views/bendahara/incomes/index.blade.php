@extends('bendahara.layouts.app')
@section('title','Pemasukan')
@section('content')
<div class="mb-6 flex items-center justify-between">
  <h1 class="text-2xl md:text-3xl font-bold">Pemasukan</h1>
  <a href="{{ route('bendahara.incomes.create') }}" class="px-4 py-2 rounded-lg bg-slate-900 text-white hover:bg-blue-600 text-sm">+ Tambah</a>
</div>
@if(session('success'))<div class="mb-4 rounded-lg border border-green-200 bg-green-50 text-green-700 px-4 py-3">{{ session('success') }}</div>@endif
@if($items->isEmpty())
  <div class="rounded-xl border bg-white p-6 text-gray-500">Belum ada data.</div>
@else
  <div class="rounded-xl border bg-white overflow-hidden">
  <table class="min-w-full text-sm">
    <thead class="bg-gray-50">
      <tr>
        <th class="px-4 py-2 text-left">Tanggal</th>
        <th class="px-4 py-2 text-left">Kategori</th>
        <th class="px-4 py-2 text-left">Rekening</th>
        <th class="px-4 py-2 text-left">Keterangan</th>   {{-- NEW --}}
        <th class="px-4 py-2 text-right">Jumlah</th>
        <th class="px-4 py-2"></th>
      </tr>
    </thead>
    <tbody>
      @foreach($items as $t)
      <tr class="border-t">
        <td class="px-4 py-2">{{ $t->date->translatedFormat('d M Y') }}</td>
        <td class="px-4 py-2">{{ $t->category->name ?? '-' }}</td>
        <td class="px-4 py-2">{{ $t->account->name ?? '-' }}</td>
        <td class="px-4 py-2">
          {{-- tampilkan deskripsi (singkat + aman saat kosong) --}}
          <div class="text-gray-700">{{ $t->description ?: '-' }}</div>
          @if($t->ref)
            <div class="text-xs text-gray-500">Ref: {{ $t->ref }}</div>
          @endif
        </td>
        <td class="px-4 py-2 text-right">Rp {{ number_format($t->amount,0,',','.') }}</td>
        <td class="px-4 py-2 text-right">
          <a href="{{ route('bendahara.incomes.edit',$t) }}" class="px-3 py-1.5 rounded-lg border text-sm">Edit</a>
          <form method="POST" action="{{ route('bendahara.incomes.destroy',$t) }}" class="inline" onsubmit="return confirm('Hapus data?')">
            @csrf @method('DELETE')
            <button class="px-3 py-1.5 rounded-lg border text-sm text-red-600">Hapus</button>
          </form>
        </td>
      </tr>
      @endforeach
    </tbody>
  </table>
</div>

  <div class="mt-4">{{ $items->links() }}</div>
@endif
@endsection
