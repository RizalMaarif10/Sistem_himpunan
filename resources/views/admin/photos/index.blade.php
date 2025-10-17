@extends('admin.layouts.app')
@section('title','Kelola Galeri')

@section('content')
<div class="mb-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
  <h1 class="text-2xl md:text-3xl font-bold tracking-tight">Kelola Galeri</h1>
  <a href="{{ route('admin.photos.create') }}" class="btn btn-primary">
    <svg xmlns="http://www.w3.org/2000/svg" class="size-4" viewBox="0 0 24 24" fill="none" stroke="currentColor">
      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
    </svg>
    Tambah Foto
  </a>
</div>

@if(session('success'))
  <div class="mb-4 rounded-lg border border-green-200 bg-green-50 text-green-700 px-4 py-3">
    {{ session('success') }}
  </div>
@endif

@if($photos->isEmpty())
  <div class="card p-8 text-center text-gray-500">Belum ada foto.</div>
@else
  {{-- WRAPPER lebih lebar + 4 kolom di ≥lg --}}
  <div class="max-w-7xl mx-auto">
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-5 items-stretch">

      @foreach($photos as $p)
        {{-- CARD full width, tinggi konsisten --}}
        <article class="card p-0 w-full overflow-hidden border hover:shadow-md transition group h-full flex flex-col">

          {{-- GAMBAR: stabil & halus saat hover --}}
          <div class="relative aspect-[4/5] bg-gray-100">
            @if($p->image_url)
              <img src="{{ $p->image_url }}" alt="{{ $p->title }}"
                   class="absolute inset-0 w-full h-full object-cover object-center transition-transform duration-300 group-hover:scale-[1.02]"
                   loading="lazy">
            @else
              <div class="absolute inset-0 grid place-items-center text-xs text-gray-400">Tanpa Gambar</div>
            @endif
          </div>

          {{-- BODY --}}
          <div class="p-4 flex flex-col flex-1">
            <h3 class="font-semibold leading-snug text-[15px] text-ink line-clamp-2 group-hover:text-accent transition-colors">
              {{ $p->title }}
            </h3>

            <div class="mt-1 text-xs text-gray-500">
              {{ optional($p->taken_at ?? $p->created_at)->translatedFormat('d F Y') }}
            </div>

            @if($p->caption)
              <p class="mt-2 text-xs text-gray-600 line-clamp-2">{{ $p->caption }}</p>
            @endif

            {{-- ACTIONS: nempel di bawah --}}
            <div class="mt-auto pt-4 flex items-center gap-2">
              <a href="{{ route('admin.photos.edit', $p) }}" class="btn btn-outline btn-sm">Edit</a>
              <form method="POST" action="{{ route('admin.photos.destroy', $p) }}" onsubmit="return confirm('Hapus foto ini?')">
                @csrf @method('DELETE')
                <button class="btn btn-outline btn-sm !text-red-600">Hapus</button>
              </form>
            </div>
          </div>
        </article>
      @endforeach

    </div>

    <div class="mt-6">{{ $photos->links() }}</div>
  </div>
@endif
@endsection
