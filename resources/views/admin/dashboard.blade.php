@extends('admin.layouts.app')
@section('title', 'Dashboard Pengurus')

@section('content')
  <div class="mb-6">
    <h1 class="text-2xl md:text-3xl font-bold">Dashboard Pengurus</h1>
    <p class="text-gray-600 mt-1">
      Selamat datang, <span class="font-semibold">{{ auth()->user()->name }}</span>.
    </p>
  </div>

  <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-4">
    <div class="rounded-xl border bg-white p-5">
      <div class="text-sm text-gray-500">Total Agenda</div>
      <div class="text-2xl font-bold">{{ $eventsCount ?? '—' }}</div>
    </div>
    <div class="rounded-xl border bg-white p-5">
      <div class="text-sm text-gray-500">Agenda Mendatang</div>
      <div class="text-2xl font-bold">{{ $upcomingEvents ?? '—' }}</div>
    </div>
    <div class="rounded-xl border bg-white p-5">
      <div class="text-sm text-gray-500">Berita Publikasi</div>
      <div class="text-2xl font-bold">{{ $postsCount ?? '—' }}</div>
    </div>
    <div class="rounded-xl border bg-white p-5">
      <div class="text-sm text-gray-500">Foto Galeri</div>
      <div class="text-2xl font-bold">{{ $photosCount ?? '—' }}</div>
    </div>
  </div>

  <div class="mt-8 grid md:grid-cols-3 gap-4">
    <div class="rounded-2xl border bg-soft p-5">
      <h3 class="font-semibold text-navy">Agenda</h3>
      <p class="text-sm text-gray-600 mt-1">Kelola event/lomba dan jadwal.</p>
      <div class="mt-3 flex gap-2">
        <a href="{{ route('admin.events.index') }}" class="px-4 py-2 rounded-lg border">Lihat</a>
        <a href="{{ route('admin.events.create') }}" class="px-4 py-2 rounded-lg bg-navy text-white">Tambah</a>
      </div>
    </div>

    <div class="rounded-2xl border bg-soft p-5">
      <h3 class="font-semibold text-navy">Berita</h3>
      <p class="text-sm text-gray-600 mt-1">Publikasi kabar terbaru.</p>
      <div class="mt-3 flex gap-2">
        <a href="{{ route('admin.posts.index') }}" class="px-4 py-2 rounded-lg border">Lihat</a>
        <a href="{{ route('admin.posts.create') }}" class="px-4 py-2 rounded-lg bg-navy text-white">Tambah</a>
      </div>
    </div>

    <div class="rounded-2xl border bg-soft p-5">
      <h3 class="font-semibold text-navy">Galeri</h3>
      <p class="text-sm text-gray-600 mt-1">Dokumentasi foto.</p>
      <div class="mt-3 flex gap-2">
        <a href="{{ route('admin.photos.index') }}" class="px-4 py-2 rounded-lg border">Lihat</a>
        <a href="{{ route('admin.photos.create') }}" class="px-4 py-2 rounded-lg bg-navy text-white">Unggah</a>
      </div>
    </div>
  </div>
@endsection
