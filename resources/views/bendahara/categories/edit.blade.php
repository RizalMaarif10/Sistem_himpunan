@extends('bendahara.layouts.app')
@section('title','Edit Kategori')

@section('content')
<h1 class="text-2xl md:text-3xl font-bold mb-6">Edit Kategori</h1>

@if(session('success'))
  <div class="mb-4 rounded-lg border border-green-200 bg-green-50 text-green-700 px-4 py-3">{{ session('success') }}</div>
@endif

<form method="POST" action="{{ route('bendahara.categories.update',$item) }}" class="bg-white rounded-xl border p-6">
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
      <label class="block text-sm font-medium mb-1">Tipe</label>
      <select name="type" class="w-full border rounded-lg px-3 py-2">
        <option value="income" {{ old('type',$item->type)=='income'?'selected':'' }}>Income</option>
        <option value="expense" {{ old('type',$item->type)=='expense'?'selected':'' }}>Expense</option>
      </select>
    </div>
  </div>

  <div class="mt-5">
    <button class="px-5 py-2 rounded-lg bg-slate-900 text-white hover:bg-blue-600">Simpan</button>
    <a href="{{ route('bendahara.categories.index') }}" class="px-5 py-2 rounded-lg border">Kembali</a>
  </div>
</form>
@endsection
