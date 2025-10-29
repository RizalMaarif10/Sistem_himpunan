@extends('layouts.app')
@section('title','Berita - HIMATEKNO')

@section('content')
<section class="section-wrap py-10">

  {{-- Header --}}
  <div class="mb-6 flex flex-col sm:flex-row items-start justify-between gap-3 sm:gap-4">
    <div>
      <span
        class="inline-flex items-center gap-2 text-[11px] font-semibold uppercase tracking-wide
               px-2.5 py-1 rounded-full bg-accent/10 text-accent">
        <svg class="h-3.5 w-3.5" viewBox="0 0 24 24" fill="currentColor">
          <path d="M3 5h18v14H3zM7 3h2v4H7zM15 3h2v4h-2z"/>
        </svg>
        Berita
      </span>

      <div class="mt-2 flex items-center gap-3">
        <h1 class="text-2xl md:text-3xl font-extrabold text-ink">Berita Terbaru</h1>
        <span class="hidden sm:inline-block h-[3px] w-16 rounded-full bg-gradient-to-r from-accent to-navy"></span>
      </div>
      <p class="mt-1 text-sm text-gray-500">Kabar & artikel terbaru dari HIMATEKNO.</p>
    </div>
  </div>

  {{-- Grid Berita --}}
  @if($posts->isEmpty())
    <p class="text-sm text-gray-500">Belum ada berita.</p>
  @else
    <style>
      .clamp-2{display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical;overflow:hidden}
      .clamp-3{display:-webkit-box;-webkit-line-clamp:3;-webkit-box-orient:vertical;overflow:hidden}
    </style>

    <div class="flex flex-wrap justify-center gap-5">
      @foreach($posts as $p)
        <article
          class="group
                 w-[calc(50%-0.625rem)]          {{-- 2 kolom di mobile (gap-5 = 1.25rem) --}}
                 lg:w-[calc(25%-0.9375rem)]      {{-- 4 kolom di ≥lg --}}
                 flex flex-col rounded-2xl border border-gray-200/80 bg-white
                 shadow-sm hover:shadow-lg hover:-translate-y-0.5 transition overflow-hidden">

          {{-- Poster 4:5 + frame seperti Agenda --}}
          <div class="p-2">
            <div class="relative aspect-[4/5] rounded-xl overflow-hidden ring-1 ring-gray-200/70">
              @if($p->cover_image)
                <img src="{{ asset('storage/'.$p->cover_image) }}" alt="{{ $p->title }}"
                     class="w-full h-full object-cover object-center">
              @else
                <div class="w-full h-full bg-gradient-to-br from-navy/10 to-accent/10"></div>
              @endif

              {{-- overlay halus saat hover --}}
              <div class="absolute inset-0 bg-gradient-to-t from-black/35 via-black/10 to-transparent
                          opacity-0 group-hover:opacity-100 transition"></div>

              {{-- badge tanggal (mirip Agenda) --}}
              @if($p->published_at)
                <span class="absolute top-2 left-2 px-2 py-0.5 rounded-full text-[11px] font-semibold bg-white/95 text-navy shadow">
                  {{ $p->published_at->translatedFormat('d M Y') }}
                </span>
              @endif
            </div>
          </div>

          {{-- Body: tipografi & clamp disamakan --}}
          <div class="px-3.5 pb-3.5 flex flex-col grow">
            <a href="{{ route('berita.show', $p) }}"
               class="block text-[14px] font-semibold text-navy hover:text-accent leading-snug clamp-2">
              {{ $p->title }}
            </a>

            <div class="mt-1.5 text-[12px] text-gray-500 space-y-0.5">
              @if($p->published_at)
                <div class="inline-flex items-center gap-1">
                  <svg class="h-3.5 w-3.5" viewBox="0 0 24 24" fill="currentColor"><path d="M7 2h2v2h6V2h2v2h3a2 2 0 012 2v3H2V6a2 2 0 012-2h3V2zm15 8v10a2 2 0 01-2 2H4a2 2 0 01-2-2V10h20z"/></svg>
                  {{ $p->published_at->translatedFormat('d F Y') }}
                </div>
              @endif
            </div>

            <p class="mt-2 text-[12.5px] text-gray-600 clamp-3">
              {{ $p->excerpt ?? \Illuminate\Support\Str::limit(strip_tags($p->body ?? ''), 150) }}
            </p>

            {{-- Actions: sejajar di bawah --}}
            <div class="mt-auto pt-3">
          <a href="{{ route('berita.show', $p) }}"
             class="inline-flex items-center gap-1 h-10 px-2.5 rounded-lg bg-accent text-white text-xs font-bold
                    hover:bg-accent/90 transition">
            Baca Selengkapnya
            <svg class="h-4 w-4" viewBox="0 0 24 24" fill="currentColor"><path d="M13 5l7 7-7 7-1.4-1.4L16.2 13H4v-2h12.2l-4.6-4.6L13 5z"/></svg>
          </a>
        </div>
          </div>
        </article>
      @endforeach
    </div>

    {{-- Pagination center --}}
    <div class="mt-8 flex justify-center">
      {{ $posts->links() }}
    </div>
  @endif

</section>
@endsection
