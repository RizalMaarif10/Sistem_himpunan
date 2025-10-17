@extends('bendahara.layouts.app')
@section('title','Akun')

@section('content')
<div class="mb-6 flex items-center justify-between">
  <h1 class="text-2xl md:text-3xl font-bold">Akun</h1>
  <a href="{{ route('bendahara.accounts.create') }}" class="px-4 py-2 rounded-lg bg-slate-900 text-white hover:bg-blue-600 text-sm">+ Tambah</a>
</div>

@if(session('success'))
  <div class="mb-4 rounded-lg border border-green-200 bg-green-50 text-green-700 px-4 py-3">{{ session('success') }}</div>
@endif

@if($items->isEmpty())
  <div class="rounded-xl border bg-white p-6 text-gray-500">Belum ada data.</div>
@else
  <div class="rounded-xl border bg-white overflow-hidden">
    <table class="min-w-full text-sm">
      <thead class="bg-gray-50">
        <tr>
          <th class="px-4 py-2 text-left">Nama</th>
          <th class="px-4 py-2 text-left">Kode</th>
          <th class="px-4 py-2 text-left">Tipe</th>
          <th class="px-4 py-2 text-right">Saldo Awal</th>
          <th class="px-4 py-2"></th>
        </tr>
      </thead>
      <tbody>
        @foreach($items as $a)
        <tr class="border-t">
          <td class="px-4 py-2">{{ $a->name }}</td>
          <td class="px-4 py-2">{{ $a->code ?? '-' }}</td>
          <td class="px-4 py-2">{{ ucfirst($a->type) }}</td>
          <td class="px-4 py-2 text-right">Rp {{ number_format($a->opening_balance,0,',','.') }}</td>
          <td class="px-4 py-2 text-right">
            <a href="{{ route('bendahara.accounts.edit',$a) }}" class="px-3 py-1.5 rounded-lg border text-sm">Edit</a>
            <form method="POST" action="{{ route('bendahara.accounts.destroy',$a) }}" class="inline" onsubmit="return confirm('Hapus akun?')">
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
