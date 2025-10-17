@extends('bendahara.layouts.app')
@section('title','Tambah Kategori')

@section('content')
<h1 class="text-2xl md:text-3xl font-bold mb-6">Tambah Kategori</h1>

<form method="POST" action="{{ route('bendahara.categories.store') }}" class="bg-white rounded-xl border p-6">
  @csrf
  @if($errors->any())
    <div class="mb-4 rounded-lg border border-red-200 bg-red-50 text-red-700 px-4 py-3">
      <ul class="list-disc pl-5">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
    </div>
  @endif

  <div class="grid md:grid-cols-2 gap-4">
    <div>
      <label class="block text-sm font-medium mb-1">Nama</label>
      <input type="text" name="name" value="{{ old('name') }}" class="w-full border rounded-lg px-3 py-2" required>
    </div>
    <div>
      <label class="block text-sm font-medium mb-1">Tipe</label>
      <select name="type" class="w-full border rounded-lg px-3 py-2">
        <option value="income" {{ old('type')=='income'?'selected':'' }}>Income</option>
        <option value="expense" {{ old('type')=='expense'?'selected':'' }}>Expense</option>
      </select>
    </div>
  </div>

  <div class="mt-5">
    <button class="px-5 py-2 rounded-lg bg-slate-900 text-white hover:bg-blue-600">Simpan</button>
    <a href="{{ route('bendahara.categories.index') }}" class="px-5 py-2 rounded-lg border">Batal</a>
  </div>
</form>
@endsection
