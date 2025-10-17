@extends('admin.layouts.app')
@section('title','Kelola Berita')

@section('content')
<div class="mb-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
  <h1 class="text-2xl md:text-3xl font-bold tracking-tight">Kelola Berita</h1>

  <div class="flex items-center gap-2">
    <form method="GET" class="hidden sm:block">
      <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari judul/teks…"
             class="border rounded-lg px-3 py-2 text-sm" />
    </form>
    <a href="{{ route('admin.posts.create') }}" class="btn btn-primary">
      <svg xmlns="http://www.w3.org/2000/svg" class="size-4" viewBox="0 0 24 24" fill="none" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
      </svg>
      Berita Baru
    </a>
  </div>
</div>

@if(session('success'))
  <div class="mb-4 rounded-lg border border-green-200 bg-green-50 text-green-700 px-4 py-3">
    {{ session('success') }}
  </div>
@endif

@if($posts->isEmpty())
  <div class="card p-8 text-center text-gray-500">Belum ada berita.</div>
@else
  {{-- Lebarkan wrapper agar 4 kartu (w-64) muat dalam 1 baris di layar ≥1024px --}}
  <div class="max-w-7xl mx-auto">
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-5 justify-items-center">
      @foreach($posts as $p)
        @php
          $status = $p->status ?? 'draft';
          $statusClass = match($status){
            'published' => 'badge badge-green',
            'archived'  => 'badge badge-amber',
            default     => 'badge badge-gray',
          };
          $statusLabel = ['draft'=>'Draft','published'=>'Published','archived'=>'Diarsipkan'][$status] ?? ucfirst($status);
        @endphp

        <article class="card w-64 p-4 hover:shadow-sm transition text-sm">
          @if($p->cover_image)
            <div class="w-full aspect-[4/5] overflow-hidden rounded-lg mb-3 bg-gray-100">
              <img src="{{ asset('storage/'.$p->cover_image) }}" alt="{{ $p->title }}"
                   class="w-full h-full object-cover object-center" loading="lazy">
            </div>
          @else
            <div class="w-full aspect-[4/5] overflow-hidden rounded-lg mb-3 bg-gray-100 grid place-items-center text-xs text-gray-400">
              Tanpa Cover
            </div>
          @endif

          <div class="mb-2 flex flex-wrap items-center gap-2 text-[11px] text-gray-500">
            <span class="badge badge-gray">BERITA</span>
            <span class="{{ $statusClass }}">{{ $statusLabel }}</span>
          </div>

          <h3 class="font-semibold leading-snug line-clamp-2 text-[15px]">{{ $p->title }}</h3>
          <div class="mt-1 text-xs text-gray-500">
            {{ optional($p->published_at ?? $p->created_at)->translatedFormat('d F Y') }}
          </div>

          <div class="mt-3 flex items-center gap-2">
            <a href="{{ route('admin.posts.edit', $p) }}" class="btn btn-outline btn-sm">Edit</a>
            <form method="POST" action="{{ route('admin.posts.destroy', $p) }}"
                  onsubmit="return confirm('Hapus berita ini?')">
              @csrf @method('DELETE')
              <button class="btn btn-outline btn-sm !text-red-600">Hapus</button>
            </form>
          </div>
        </article>
      @endforeach
    </div>

    <div class="mt-6">{{ $posts->withQueryString()->links() }}</div>
  </div>
@endif
@endsection
