@extends('layouts.app')
@section('title','Galeri - HIMATEKNO')

@section('content')
<section class="section-wrap py-10">

  {{-- Header --}}
  <div class="mb-6">
    <span class="inline-flex items-center gap-2 text-[11px] font-semibold uppercase tracking-wide
                 px-2.5 py-1 rounded-full bg-accent/10 text-accent">
      <svg class="h-3.5 w-3.5" viewBox="0 0 24 24" fill="currentColor">
        <path d="M21 19V5a2 2 0 0 0-2-2H5C3.9 3 3 3.9 3 5v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2z"/>
      </svg>
      Galeri
    </span>
    <div class="mt-2 flex items-center gap-3">
      <h1 class="text-2xl md:text-3xl font-extrabold text-ink">Galeri</h1>
      <span class="hidden sm:inline-block h-[3px] w-16 rounded-full bg-gradient-to-r from-accent to-navy"></span>
    </div>
    <p class="mt-1 text-sm text-gray-500">Dokumentasi kegiatan HIMATEKNO.</p>
  </div>

  @if($photos->isEmpty())
  <p class="text-sm text-gray-500">Belum ada foto galeri.</p>
@else
  {{-- Center + 3 kolom di lg. gap-3 = 0.75rem --}}
  {{-- sm: (100% - 0.75rem)/2  -> sm:w-[calc(50%-0.375rem)] --}}
  {{-- lg: (100% - 1.5rem)/3  -> lg:w-[calc(33.333%-0.5rem)] --}}
  <div class="flex flex-wrap gap-3 justify-center">
    @foreach($photos as $ph)
      <a href="{{ route('galeri.show', $ph) }}"
         aria-label="{{ $ph->title ?? 'Foto Galeri' }}"
         class="ui-card is-hover p-2 block w-full sm:w-[calc(50%-0.375rem)] lg:w-[calc(33.333%-0.5rem)]">
        <div class="group relative overflow-hidden rounded-xl aspect-[16/9]">
          <img
            src="{{ asset('storage/'.$ph->image_path) }}"
            alt="{{ $ph->title ?? 'Foto galeri' }}"
            loading="lazy" decoding="async"
            class="absolute inset-0 h-full w-full object-cover object-center transition-transform duration-200 group-hover:scale-[1.02]">
        </div>
      </a>
    @endforeach
  </div>

  {{-- Pagination center --}}
  <div class="mt-8 flex justify-center">
    {{ $photos->links() }}
  </div>
@endif


</section>
@endsection
