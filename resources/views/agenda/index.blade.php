@extends('layouts.app')
@section('title','Agenda & Lomba - HIMATEKNO')

@section('content')
<section class="max-w-6xl mx-auto px-4 py-10">

  {{-- Header --}}
  <div class="mb-6">
    <span class="inline-flex items-center gap-2 text-[11px] font-semibold uppercase tracking-wide px-2.5 py-1 rounded-full bg-accent/10 text-accent">
      <svg class="h-3.5 w-3.5" viewBox="0 0 24 24" fill="currentColor"><path d="M7 2h2v2h6V2h2v2h3a2 2 0 012 2v3H2V6a2 2 0 012-2h3V2zm15 8v10a2 2 0 01-2 2H4a2 2 0 01-2-2V10h20z"/></svg>
      Agenda & Lomba
    </span>
    <div class="mt-2 flex items-center gap-3">
      <h1 class="text-2xl md:text-3xl font-extrabold text-ink">Agenda & Lomba</h1>
      <span class="hidden sm:inline-block h-[3px] w-16 rounded-full bg-gradient-to-r from-accent to-navy"></span>
    </div>
    <p class="mt-1 text-sm text-gray-500">Temukan kegiatan dan kompetisi terbaru HIMATEKNO.</p>
  </div>

  {{-- Tabs waktu --}}
  <div class="mb-4 flex flex-wrap items-center gap-2">
    @php
      $qs = fn($arr) => request()->fullUrlWithQuery($arr + ['page'=>null]);
      $tabs = [
        ['key'=>'all','label'=>'Semua'],
        ['key'=>'upcoming','label'=>'Akan Datang'],
        ['key'=>'past','label'=>'Sudah Lewat'],
      ];
    @endphp
    @foreach($tabs as $t)
      <a href="{{ $qs(['tab'=>$t['key']]) }}"
         class="inline-flex h-8 items-center rounded-full px-3 text-sm border transition
                {{ $tab === $t['key'] ? 'bg-accent text-white border-transparent' : 'border-accent/50 text-accent hover:bg-accent hover:text-white' }}">
        {{ $t['label'] }}
      </a>
    @endforeach
  </div>

  {{-- ===== KONTEN ===== --}}
  @if($events->isEmpty())
    <p class="text-sm text-gray-500">Belum ada data untuk filter tersebut.</p>
  @else
    <style>
      .clamp-2{display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical;overflow:hidden}
      .clamp-3{display:-webkit-box;-webkit-line-clamp:3;-webkit-box-orient:vertical;overflow:hidden}
    </style>

    {{-- FLEX container: baris selalu center, 2 kolom mobile, 4 kolom desktop --}}
    <div class="flex flex-wrap justify-center gap-5">
      @foreach($events as $e)
        <article
          class="group
                 w-[calc(50%-0.625rem)]            {{-- 2 kolom (gap-5 = 1.25rem → 0.625/kartu) --}}
                 lg:w-[calc(25%-0.9375rem)]        {{-- 4 kolom di ≥lg (3 gap/4 kolom) --}}
                 flex flex-col rounded-2xl border border-gray-200/80 bg-white
                 shadow-sm hover:shadow-lg hover:-translate-y-0.5 transition overflow-hidden">

          {{-- Poster 4:5 dengan frame --}}
          <div class="p-2">
            <div class="relative aspect-[4/5] rounded-xl overflow-hidden ring-1 ring-gray-200/70">
              @if($e->cover_image)
                <img src="{{ asset('storage/'.$e->cover_image) }}"
                     class="w-full h-full object-cover object-center" alt="{{ $e->title }}">
              @else
                <div class="w-full h-full bg-gradient-to-br from-navy/10 to-accent/10"></div>
              @endif

              {{-- badges tanggal/tipe --}}
              <div class="absolute top-2 left-2 flex gap-1">
                <span class="px-2 py-0.5 rounded-full text-[11px] font-semibold bg-white/95 text-navy shadow">
                  {{ optional($e->start_at)->translatedFormat('d M Y') ?? 'TBA' }}
                </span>
                @if($e->type)
                  <span class="px-2 py-0.5 rounded-md text-[11px] font-semibold bg-accent/10 text-accent">
                    {{ strtoupper($e->type) }}
                  </span>
                @endif
              </div>
            </div>
          </div>

          {{-- Body: flex kolom + grow supaya tombol nempel bawah --}}
          <div class="px-3.5 pb-3.5 flex flex-col grow">
            <a href="{{ route('agenda.show', $e) }}"
               class="block text-[14px] font-semibold text-navy hover:text-accent leading-snug clamp-2">
              {{ $e->title }}
            </a>

            <div class="mt-1.5 text-[12px] text-gray-500 space-y-0.5">
              @if($e->start_at)
                <div class="inline-flex items-center gap-1">
                  <svg class="h-3.5 w-3.5" viewBox="0 0 24 24" fill="currentColor"><path d="M7 2h2v2h6V2h2v2h3a2 2 0 012 2v3H2V6a2 2 0 012-2h3V2zm15 8v10a2 2 0 01-2 2H4a2 2 0 01-2-2V10h20z"/></svg>
                  {{ $e->start_at->translatedFormat('d F Y, H:i') }}
                </div>
              @endif
              @if($e->location)
                <div class="inline-flex items-center gap-1">
                  <svg class="h-3.5 w-3.5" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2a7 7 0 00-7 7c0 5.25 7 13 7 13s7-7.75 7-13a7 7 0 00-7-7zm0 9.5a2.5 2.5 0 110-5 2.5 2.5 0 010 5z"/></svg>
                  {{ $e->location }}
                </div>
              @endif
            </div>

            <p class="mt-2 text-[12.5px] text-gray-600 clamp-3">
              {{ \Illuminate\Support\Str::limit(strip_tags($e->description), 150) }}
            </p>

            {{-- Actions: selalu sejajar di bawah --}}
            <div class="mt-auto pt-3 flex items-center gap-2">
              <a href="{{ route('agenda.show', $e) }}"
                 class="inline-flex items-center h-8 px-2.5 rounded-lg border border-accent/60 text-accent text-xs
                        hover:bg-accent hover:text-white transition">Detail</a>
              @if($e->registration_link)
                <a href="{{ $e->registration_link }}" target="_blank" rel="noopener"
                   class="inline-flex items-center h-8 px-2.5 rounded-lg bg-accent text-white text-xs
                          hover:bg-accent/90 transition">Daftar</a>
              @endif
            </div>
          </div>
        </article>
      @endforeach
    </div>

    {{-- Pagination --}}
    <div class="mt-8 flex justify-center">
      {{ $events->links() }}
    </div>
  @endif

</section>
@endsection
