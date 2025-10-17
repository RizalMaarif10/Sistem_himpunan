@extends('layouts.app')
@section('title', ($photo->title ? $photo->title.' - ' : '').'Galeri')

@section('content')
<section class="section-wrap py-8">

  {{-- Tombol kembali (pill) --}}
  <a href="{{ route('galeri.index') }}"
     class="group inline-flex items-center gap-2 text-sm rounded-full border border-accent/60 text-accent
            hover:bg-accent hover:text-white transition px-3 py-1.5">
    <svg class="h-4 w-4 transition-transform group-hover:-translate-x-0.5" viewBox="0 0 24 24" fill="currentColor">
      <path d="M14 7l-5 5 5 5V7z"/>
    </svg>
    Kembali ke Galeri
  </a>

  {{-- Judul --}}
  <h1 class="text-2xl md:text-3xl font-extrabold text-ink mt-2">
    {{ $photo->title ?: 'Foto Galeri' }}
  </h1>

  {{-- Meta --}}
  <div class="mt-1 text-sm text-gray-500">
    @if($photo->taken_at)
      Diambil: {{ optional($photo->taken_at)->translatedFormat('d F Y') }}
    @endif
  </div>

  {{-- Foto utama: 16:9 + lebar dibatasi per breakpoint --}}
  <figure class="mt-5 mx-auto w-full max-w-[320px] sm:max-w-[480px] md:max-w-[640px]">
    <div class="relative overflow-hidden rounded-xl border bg-white shadow-card aspect-[16/9]">
      <img
        src="{{ asset('storage/'.$photo->image_path) }}"
        alt="{{ $photo->title ?? 'Foto galeri' }}"
        loading="lazy" decoding="async"
        class="absolute inset-0 w-full h-full object-cover">
    </div>
   
  </figure>

  {{-- Aksi --}}
  <div class="mt-6 flex flex-wrap gap-2">
    <a href="{{ asset('storage/'.$photo->image_path) }}" target="_blank" rel="noopener"
       class="ui-btn ui-btn--outline">Lihat Ukuran Penuh</a>
    <a href="{{ asset('storage/'.$photo->image_path) }}" download
       class="ui-btn ui-btn--primary">Unduh</a>
  </div>

  {{-- Foto Lainnya --}}
  @if($more->isNotEmpty())
    <hr class="my-10">
    <div class="mb-3 flex items-center gap-3">
      <h2 class="text-lg md:text-xl font-semibold text-ink">Foto Lainnya</h2>
      <span class="hidden sm:inline-block h-[3px] w-12 rounded-full bg-gradient-to-r from-accent to-navy"></span>
    </div>

    <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-3">
      @foreach($more as $m)
        <a href="{{ route('galeri.show', $m) }}" class="ui-card is-hover p-2">
          <div class="group relative overflow-hidden rounded-xl aspect-[16/9]">
            <img
              src="{{ asset('storage/'.$m->image_path) }}"
              alt="{{ $m->title ?? 'Foto galeri' }}"
              loading="lazy" decoding="async"
              class="absolute inset-0 w-full h-full object-cover transition-transform duration-200 group-hover:scale-[1.02]">
          </div>
          {{-- Tanpa judul agar tetap bersih --}}
        </a>
      @endforeach
    </div>
  @endif

</section>
@endsection
