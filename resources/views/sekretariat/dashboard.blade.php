@extends('sekretariat.layouts.app')
@section('title','Dashboard Sekretariat')

@section('content')
<h1 class="text-2xl md:text-3xl font-bold">Dashboard Sekretariat</h1>
<p class="text-gray-600 mt-1">Halo, {{ auth()->user()->name ?? 'Pengguna' }}.</p>

<div class="grid sm:grid-cols-3 gap-4 mt-6">
  <div class="rounded-xl border bg-white p-5">
    <div class="text-sm text-gray-500">Surat Masuk Belum Dibaca</div>
    <div class="text-2xl font-bold">{{ $unreadIncoming ?? 0 }}</div>
  </div>
  <div class="rounded-xl border bg-white p-5">
    <div class="text-sm text-gray-500">Surat Keluar Bulan Ini</div>
    <div class="text-2xl font-bold">{{ $outgoingThisMonth ?? 0 }}</div>
  </div>
  <div class="rounded-xl border bg-white p-5">
    <div class="text-sm text-gray-500">Pesan Kontak Belum Dibaca</div>
    <div class="text-2xl font-bold">{{ $unreadMessages ?? 0 }}</div>
  </div>
</div>

<div class="mt-8 grid md:grid-cols-2 gap-4">
  <a href="{{ route('sekretariat.letters.create') }}" class="inline-flex items-center justify-center px-5 py-3 rounded-lg bg-slate-900 text-white hover:bg-blue-600">+ Tambah Surat</a>
  <a href="{{ route('sekretariat.minutes.create') }}" class="inline-flex items-center justify-center px-5 py-3 rounded-lg border hover:bg-gray-50">+ Tambah Notulen</a>
</div>
@endsection
