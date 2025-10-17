@extends('layouts.app')
@section('title', $event->title.' - Agenda')

@section('content')
<section class="max-w-5xl mx-auto px-4 py-8">

  {{-- Back link (ringkas & jelas) --}}
  <a href="{{ route('agenda.index') }}"
     class="group inline-flex items-center gap-2 text-[13px] rounded-full border border-accent/50 text-accent
            hover:bg-accent hover:text-white transition px-3 py-1.5">
    <svg class="h-4 w-4 transition-transform group-hover:-translate-x-0.5" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
      <path d="M14 7l-5 5 5 5V7z"/>
    </svg>
    Kembali ke Agenda
  </a>

  {{-- Judul --}}
  <h1 class="mt-2 text-2xl md:text-3xl font-extrabold tracking-tight text-ink">
    {{ $event->title }}
  </h1>

  {{-- Meta chips --}}
  <ul class="mt-3 flex flex-wrap items-center gap-2 text-[13px] text-gray-600">
    <li class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full border border-accent/40 text-accent font-semibold">
      {{ strtoupper($event->type ?? 'EVENT') }}
    </li>

    @if($event->start_at)
      <li class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full bg-gray-100">
        <svg class="h-4 w-4" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M7 2h2v2h6V2h2v2h3a2 2 0 012 2v3H2V6a2 2 0 012-2h3V2zm15 8v10a2 2 0 01-2 2H4a2 2 0 01-2-2V10h20z"/></svg>
        {{ $event->start_at->translatedFormat('d F Y, H:i') }}
      </li>
    @endif

    @if($event->end_at)
      <li class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full bg-gray-100">
        <svg class="h-4 w-4" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M7 2h2v2h6V2h2v2h3a2 2 0 012 2v3H2V6a2 2 0 012-2h3V2zm15 8v10a2 2 0 01-2 2H4a2 2 0 01-2-2V10h20z"/></svg>
        s/d {{ $event->end_at->translatedFormat('d F Y, H:i') }}
      </li>
    @endif

    @if($event->location)
      <li class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full bg-gray-100">
        <svg class="h-4 w-4" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M12 2a7 7 0 00-7 7c0 5.25 7 13 7 13s7-7.75 7-13a7 7 0 00-7-7zm0 9.5a2.5 2.5 0 110-5 2.5 2.5 0 010 5z"/></svg>
        {{ $event->location }}
      </li>
    @endif
  </ul>

  {{-- Garis halus sebagai pemisah visual --}}
  <div class="mt-4 h-px w-full bg-gradient-to-r from-accent/20 to-transparent"></div>

  {{-- Media + Deskripsi --}}
  <div class="mt-6 grid gap-6 md:grid-cols-12 items-start">
    {{-- KIRI: Gambar (stabil & proporsional) --}}
    <figure class="md:col-span-5">
      <div class="rounded-2xl overflow-hidden border bg-white shadow-sm ring-1 ring-black/5">
        <div class="aspect-[4/5]">
          @if($event->cover_image)
            <img src="{{ asset('storage/'.$event->cover_image) }}"
                 alt="Poster {{ $event->title }}"
                 class="w-full h-full object-cover" loading="lazy">
          @else
            <div class="w-full h-full grid place-content-center text-xs text-gray-500 bg-gray-100">
              Tidak ada gambar
            </div>
          @endif
        </div>
      </div>
    </figure>

    {{-- KANAN: Deskripsi + CTA --}}
    <div class="md:col-span-7 min-w-0">
      <div class="flex items-center gap-3">
        <span class="inline-flex items-center gap-2 text-[11px] font-semibold uppercase tracking-wide
                     px-2.5 py-1 rounded-full bg-accent/10 text-accent">
          <svg class="h-3.5 w-3.5" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M4 4h16v2H4zM4 9h16v2H4zM4 14h10v2H4z"/></svg>
          Deskripsi
        </span>
        <span class="h-[3px] w-16 rounded-full bg-gradient-to-r from-accent to-navy"></span>
      </div>
      <p class="mt-1 text-sm text-gray-500">
        Di bawah ini berisi detail acara, ketentuan, dan informasi tambahan.
      </p>

      {{-- Lebar baca ideal + tipografi halus --}}
      <article class="mt-4 text-[15px] text-gray-700 leading-8 space-y-4 max-w-[68ch] break-words
                      [&_img]:max-w-full [&_img]:h-auto
                      [&_h2]:text-xl [&_h2]:font-semibold [&_h2]:text-ink [&_h2]:mt-6
                      [&_ul]:list-disc [&_ul]:pl-6 [&_ol]:list-decimal [&_ol]:pl-6">
        {!! $event->description !!}
      </article>

      {{-- CTA konsisten --}}
      <div class="mt-6 flex flex-wrap gap-2">
        @if($event->registration_link)
          <a href="{{ $event->registration_link }}" target="_blank" rel="noopener"
             class="inline-flex items-center h-10 px-4 rounded-lg bg-accent text-white text-sm font-medium hover:bg-accent/90 transition focus:outline-none focus:ring-2 focus:ring-accent/40">
            Daftar / Link Pendaftaran
          </a>
        @endif
        @if($event->location)
          <a href="https://www.google.com/maps/search/?api=1&query={{ urlencode($event->location) }}" target="_blank" rel="noopener"
             class="inline-flex items-center h-10 px-4 rounded-lg border border-accent/60 text-accent text-sm font-medium hover:bg-accent hover:text-white transition focus:outline-none focus:ring-2 focus:ring-accent/30">
            Lihat Lokasi
          </a>
        @endif
      </div>
    </div>
  </div>

  {{-- Agenda terkait (rapi & konsisten) --}}
  @if($related->isNotEmpty())
    <hr class="my-10">
    <h2 class="text-lg font-semibold mb-4 text-ink">Agenda Terkait</h2>
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5">
      @foreach($related as $e)
        <a href="{{ route('agenda.show', $e) }}"
           class="group rounded-2xl border bg-white shadow-sm hover:shadow-md transition overflow-hidden">
          <div class="relative aspect-[4/5]">
            @if($e->cover_image)
              <img src="{{ asset('storage/'.$e->cover_image) }}" alt="{{ $e->title }}" class="w-full h-full object-cover">
            @else
              <div class="w-full h-full bg-gray-100"></div>
            @endif
            @if($e->start_at)
              <span class="absolute top-2 left-2 px-2 py-0.5 rounded-full text-[11px] font-semibold bg-white/95 text-navy shadow">
                {{ $e->start_at->translatedFormat('d M') }}
              </span>
            @endif
          </div>
          <div class="p-4">
            <div class="text-[12px] text-gray-500">{{ optional($e->start_at)->translatedFormat('d F Y') }}</div>
            <div class="mt-1 font-semibold text-navy leading-snug line-clamp-2 group-hover:text-accent">{{ $e->title }}</div>
            @if($e->location)
              <div class="text-[12px] text-gray-500 mt-1 line-clamp-1">{{ $e->location }}</div>
            @endif
          </div>
        </a>
      @endforeach
    </div>
  @endif

</section>
@endsection
