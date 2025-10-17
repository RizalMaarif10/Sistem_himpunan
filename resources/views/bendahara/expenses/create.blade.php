@extends('bendahara.layouts.app')
@section('title','Tambah Pengeluaran')

@section('content')
<h1 class="text-2xl md:text-3xl font-bold mb-6">Tambah Pengeluaran</h1>

<form method="POST" action="{{ route('bendahara.expenses.store') }}" class="bg-white rounded-xl border p-6">
  @include('bendahara.transactions._form', ['tx' => $tx])
</form>
@endsection
