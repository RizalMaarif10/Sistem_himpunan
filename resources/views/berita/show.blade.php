@extends('layouts.app')
@section('title', $post->title.' - Berita')

@section('content')
<section class="max-w-5xl mx-auto px-4 py-8">

  {{-- Tombol kembali (pill + hover konsisten) --}}
  <a href="{{ route('berita.index') }}"
     class="group inline-flex items-center gap-2 text-sm rounded-full border border-accent/60 text-accent
            hover:bg-accent hover:text-white transition px-3 py-1.5">
    <svg class="h-4 w-4 transition-transform group-hover:-translate-x-0.5" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
      <path d="M14 7l-5 5 5 5V7z"/>
    </svg>
    Kembali ke Berita
  </a>

  {{-- Judul --}}
  <h1 class="text-2xl md:text-3xl font-extrabold text-ink mt-2">{{ $post->title }}</h1>

  {{-- Meta sebagai chip --}}
  <ul class="mt-2 flex flex-wrap items-center gap-2 text-sm text-gray-600">
    <li class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full bg-gray-100">
      {{ optional($post->published_at)->translatedFormat('d F Y') }}
    </li>
  </ul>

  {{-- Pemisah lembut --}}
  <div class="mt-4 h-px w-full bg-gradient-to-r from-accent/20 to-transparent"></div>

  {{-- Grid: Cover + Konten --}}
  <div class="mt-6 grid gap-6 md:grid-cols-12 items-start">

    {{-- KIRI: Cover (muncul jika ada) --}}
    @if($post->cover_image)
      <figure class="md:col-span-5">
        <div class="rounded-2xl overflow-hidden border bg-white shadow-sm ring-1 ring-black/5">
          <div class="aspect-[4/5]">
            <img src="{{ asset('storage/'.$post->cover_image) }}" alt="Cover {{ $post->title }}"
                 class="w-full h-full object-cover" loading="lazy">
          </div>
        </div>
      </figure>
    @endif

    {{-- KANAN: Isi Berita --}}
    <div class="{{ $post->cover_image ? 'md:col-span-7' : 'md:col-span-12' }} min-w-0">

      <div class="flex items-center gap-3">
        <span class="inline-flex items-center gap-2 text-[11px] font-semibold uppercase tracking-wide
                     px-2.5 py-1 rounded-full bg-accent/10 text-accent">
          <svg class="h-3.5 w-3.5" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
            <path d="M4 4h16v2H4zM4 9h16v2H4zM4 14h10v2H4z"/>
          </svg>
          Isi Berita
        </span>
        <span class="h-[3px] w-16 rounded-full bg-gradient-to-r from-accent to-navy"></span>
      </div>

      @php
        $html = $post->body ?? $post->content ?? $post->description ?? '';
      @endphp

      @if(trim(strip_tags($html)) === '')
        <p class="mt-4 text-sm text-gray-500">Belum ada konten pada berita ini.</p>
      @else
        {{-- Lebar baca ideal + tipografi halus --}}
        <article class="mt-4 max-w-[68ch] text-[15px] text-gray-700 leading-8 space-y-4 break-words
                        [&_h2]:text-xl [&_h2]:font-semibold [&_h2]:text-ink [&_h2]:mt-6
                        [&_h3]:text-lg [&_h3]:font-semibold [&_h3]:text-ink [&_h3]:mt-5
                        [&_ul]:list-disc [&_ul]:pl-6
                        [&_ol]:list-decimal [&_ol]:pl-6
                        [&_a]:text-accent [&_a:hover]:underline
                        [&_img]:max-w-full [&_img]:h-auto">
          {!! $html !!}
        </article>
      @endif
    </div>
  </div>

  {{-- Berita Lainnya --}}
  @if($related->isNotEmpty())
    <hr class="my-10">
    <div class="mb-3 flex items-center gap-3">
      <h2 class="text-lg md:text-xl font-semibold text-ink">Berita Lainnya</h2>
      <span class="hidden sm:inline-block h-[3px] w-12 rounded-full bg-gradient-to-r from-accent to-navy"></span>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5">
      @foreach($related as $r)
        <a href="{{ route('berita.show', $r) }}"
           class="group rounded-2xl border bg-white shadow-sm hover:shadow-md transition overflow-hidden focus:outline-none focus:ring-2 focus:ring-accent/30">
          <div class="relative aspect-[4/5]">
            @if($r->cover_image)
              <img src="{{ asset('storage/'.$r->cover_image) }}" alt="{{ $r->title }}"
                   class="w-full h-full object-cover">
            @else
              <div class="w-full h-full bg-gray-100"></div>
            @endif
          </div>
          <div class="p-4">
            <div class="text-[12px] text-gray-500">{{ optional($r->published_at)->translatedFormat('d F Y') }}</div>
            <div class="mt-1 font-semibold text-navy leading-snug line-clamp-2 group-hover:text-accent">
              {{ $r->title }}
            </div>
          </div>
        </a>
      @endforeach
    </div>
  @endif

</section>
@endsection
