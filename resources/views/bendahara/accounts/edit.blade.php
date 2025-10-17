@extends('bendahara.layouts.app')
@section('title','Edit Akun')

@section('content')
<h1 class="text-2xl md:text-3xl font-bold mb-6">Edit Akun</h1>

@if(session('success'))
  <div class="mb-4 rounded-lg border border-green-200 bg-green-50 text-green-700 px-4 py-3">{{ session('success') }}</div>
@endif

<form method="POST" action="{{ route('bendahara.accounts.update',$item) }}" class="bg-white rounded-xl border p-6">
  @method('PUT') @csrf
  @if($errors->any())
    <div class="mb-4 rounded-lg border border-red-200 bg-red-50 text-red-700 px-4 py-3">
      <ul class="list-disc pl-5">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
    </div>
  @endif

  <div class="grid md:grid-cols-2 gap-4">
    <div>
      <label class="block text-sm font-medium mb-1">Nama</label>
      <input type="text" name="name" value="{{ old('name',$item->name) }}" class="w-full border rounded-lg px-3 py-2" required>
    </div>
    <div>
  <label class="block text-sm font-medium mb-1">Kode (opsional)</label>
  <input
    type="text"
    name="code"
    value="{{ old('code', $item->code) }}"
    class="w-full border rounded-lg px-3 py-2 @error('code') border-red-500 ring-1 ring-red-300 @enderror">
  @error('code')
    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
  @enderror
</div>

    <div>
      <label class="block text-sm font-medium mb-1">Tipe</label>
      <select name="type" class="w-full border rounded-lg px-3 py-2">
        <option value="cash"  {{ old('type',$item->type)=='cash'?'selected':'' }}>Cash</option>
        <option value="bank"  {{ old('type',$item->type)=='bank'?'selected':'' }}>Bank</option>
        <option value="other" {{ old('type',$item->type)=='other'?'selected':'' }}>Other</option>
      </select>
    </div>
    <div>
      <label class="block text-sm font-medium mb-1">Saldo Awal (Rp)</label>
      <input type="number" name="opening_balance" min="0" step="1" value="{{ old('opening_balance',$item->opening_balance) }}" class="w-full border rounded-lg px-3 py-2">
    </div>
  </div>

  <div class="mt-5">
    <button class="px-5 py-2 rounded-lg bg-slate-900 text-white hover:bg-blue-600">Simpan</button>
    <a href="{{ route('bendahara.accounts.index') }}" class="px-5 py-2 rounded-lg border">Kembali</a>
  </div>
</form>
@endsection
