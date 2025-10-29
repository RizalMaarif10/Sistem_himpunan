@extends('layouts.app')
@section('title', 'Beranda - HIMATEKNO')

@section('content')

  <!-- Hero -->
  <section class="relative overflow-hidden bg-gradient-to-br from-accent/10 via-white to-soft">
    <div class="absolute -top-20 -right-32 h-72 w-72 rounded-full bg-accent/20 blur-3xl"></div>
    <div class="absolute -bottom-20 -left-32 h-72 w-72 rounded-full bg-navy/10 blur-3xl"></div>

    <div class="relative section-wrap py-16 grid md:grid-cols-2 gap-10 items-center">
      <div>
        <h1 class="mt-3 text-3xl md:text-5xl font-extrabold leading-tight text-ink">
          Bersama Membangun <span class="text-accent">Karya & Prestasi</span>
        </h1>
        <p class="mt-3 text-gray-600 md:text-lg">
          Ikuti berita terbaru, agenda kegiatan, dan dokumentasi aktivitas mahasiswa HIMATEKNO UMPWR.
        </p>
        <div class="mt-6 flex flex-wrap gap-3">
          <a href="{{ route('agenda.index') }}"
             class="px-5 py-2.5 rounded-lg bg-navy text-white hover:bg-accent transition shadow-sm hover:shadow">Lihat Agenda</a>
          <a href="{{ route('berita.index') }}"
             class="px-5 py-2.5 rounded-lg border border-navy text-navy hover:bg-gray-100 transition">Berita Terbaru</a>
        </div>
      </div>

      <div class="relative">
        <div class="rounded-2xl bg-white shadow-card border p-4">
          <div class="aspect-[16/10] overflow-hidden rounded-xl">
            <img src="{{ asset('images/hero.jpg') }}" alt="Kegiatan HIMATEKNO"
                 class="h-full w-full object-cover object-center scale-[1.02]" loading="lazy">
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Agenda Terdekat -->
  <section class="section-wrap py-12">
    <div class="mb-6 flex flex-col sm:flex-row items-start justify-between gap-3 sm:gap-4">
      <div>
        <span class="inline-flex items-center gap-2 text-[11px] font-semibold uppercase tracking-wide
                     px-2.5 py-1 rounded-full bg-accent/10 text-accent">
          <svg class="h-3.5 w-3.5" viewBox="0 0 24 24" fill="currentColor">
            <path d="M7 2h2v2h6V2h2v2h3a2 2 0 012 2v3H2V6a2 2 0 012-2h3V2zm15 8v10a2 2 0 01-2 2H4a2 2 0 01-2-2V10h20z"/>
          </svg>
          Agenda
        </span>

        <div class="mt-2 flex items-center gap-3">
          <h2 class="text-2xl font-extrabold text-ink">Agenda Terdekat</h2>
          <span class="hidden sm:inline-block h-[3px] w-16 rounded-full bg-gradient-to-r from-accent to-navy"></span>
        </div>

        <p class="mt-1 text-sm text-gray-500">Jangan lewatkan kegiatan terbaru minggu ini.</p>
      </div>

      <a href="{{ route('agenda.index') }}"
         class="self-start inline-flex items-center gap-1.5 h-8 px-3 text-sm rounded-full
                whitespace-nowrap border border-accent/60 text-accent
                hover:bg-accent hover:text-white transition mt-3 sm:mt-2">
        Lihat semua
        <svg class="h-3.5 w-3.5" viewBox="0 0 24 24" fill="currentColor">
          <path d="M13 5l7 7-7 7-1.4-1.4L16.2 13H4v-2h12.2l-4.6-4.6L13 5z"/>
        </svg>
      </a>
    </div>

    @if($events->isEmpty())
      <p class="text-sm text-gray-500">Belum ada agenda dipublikasikan.</p>
    @else
      {{-- SELALU CENTER: flex-wrap + justify-center
           Lebar kartu kompensasi gap-5 (1.25rem):
           sm => (100% - 1.25rem)/2  => sm:w-[calc(50%-0.625rem)]
           lg => (100% - 2.5rem)/3  => lg:w-[calc(33.333%-0.833rem)] --}}
      {{-- Cards: 2 kolom mobile, 4 kolom desktop, tampilkan 4 terbaru --}}
<div class="flex flex-wrap justify-center gap-5">
  @foreach($events->take(4) as $e)
    <article
      class="ui-card is-hover w-[calc(50%-0.625rem)] lg:w-[calc(25%-0.9375rem)]
             flex flex-col rounded-2xl border border-gray-200/80 bg-white
             shadow-sm hover:shadow-lg hover:-translate-y-0.5 transition overflow-hidden">

      {{-- Poster 4:5 + frame --}}
      <div class="p-2">
        <div class="relative aspect-[4/5] rounded-xl overflow-hidden ring-1 ring-gray-200/70">
          @if($e->cover_image)
            <img src="{{ asset('storage/'.$e->cover_image) }}" alt="{{ $e->title }}"
                 class="w-full h-full object-cover object-center">
          @else
            <div class="w-full h-full bg-gradient-to-br from-navy/10 to-accent/10"></div>
          @endif
          <span class="absolute top-2 left-2 px-2 py-0.5 rounded-full text-[11px] font-semibold bg-white/95 text-navy shadow">
            {{ optional($e->start_at)->translatedFormat('d M Y') ?? 'TBA' }}
          </span>
        </div>
      </div>

      <div class="px-3.5 pb-3.5 flex flex-col grow">
        <a href="{{ route('agenda.show', $e) }}"
           class="block text-[14px] font-semibold text-navy hover:text-accent leading-snug">
          {{ $e->title }}
        </a>

        <div class="mt-1.5 text-[12px] text-gray-500 space-y-0.5">
          <div class="inline-flex items-center gap-1">
            <svg class="h-3.5 w-3.5" viewBox="0 0 24 24" fill="currentColor"><path d="M7 2h2v2h6V2h2v2h3a2 2 0 012 2v3H2V6a2 2 0 012-2h3V2zm15 8v10a2 2 0 01-2 2H4a2 2 0 01-2-2V10h20z"/></svg>
            {{ optional($e->start_at)->translatedFormat('d F Y') ?? 'Jadwal menyusul' }}
          </div>
          @if($e->location)
            <div class="inline-flex items-center gap-1">
              <svg class="h-3.5 w-3.5" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2a7 7 0 00-7 7c0 5.25 7 13 7 13s7-7.75 7-13a7 7 0 00-7-7zm0 9.5a2.5 2.5 0 110-5 2.5 2.5 0 010 5z"/></svg>
              {{ $e->location }}
            </div>
          @endif
        </div>

        <p class="mt-2 text-[12.5px] text-gray-600">
          {{ \Illuminate\Support\Str::limit(strip_tags($e->description), 150) }}
        </p>

        <div class="mt-auto pt-3 flex items-center gap-2">
          <a href="{{ route('agenda.show', $e) }}"
             class="inline-flex items-center h-8 px-2.5 rounded-lg border border-accent/60 text-accent text-xs
                    hover:bg-accent hover:text-white transition">Detail</a>
          @if($e->registration_link)
            <a href="{{ $e->registration_link }}" target="_blank" rel="noopener"
               class="inline-flex items-center h-8 px-2.5 rounded-lg bg-accent text-white text-xs
                      hover:bg-accent/90 transition">Daftar</a>
          @endif
          @if(($e->type ?? null) === 'lomba')
            <span class="ui-chip ms-auto">Lomba</span>
          @endif
        </div>
      </div>
    </article>
  @endforeach
</div>

    @endif
  </section>

  <!-- Berita Terbaru -->
  <section class="bg-soft py-12">
    <div class="section-wrap">
      <div class="mb-6 flex flex-col sm:flex-row items-start justify-between gap-3 sm:gap-4">
        <div>
          <span class="inline-flex items-center gap-2 text-[11px] font-semibold uppercase tracking-wide
                       px-2.5 py-1 rounded-full bg-accent/10 text-accent">
            <svg class="h-3.5 w-3.5" viewBox="0 0 24 24" fill="currentColor">
              <path d="M3 5h18v14H3zM7 3h2v4H7zM15 3h2v4h-2z"/>
            </svg>
            Berita
          </span>

          <div class="mt-2 flex items-center gap-3">
            <h2 class="text-2xl font-extrabold text-ink">Berita Terbaru</h2>
            <span class="hidden sm:inline-block h-[3px] w-16 rounded-full bg-gradient-to-r from-accent to-navy"></span>
          </div>

          <p class="mt-1 text-sm text-gray-500">Kabar & artikel terbaru dari HIMATEKNO.</p>
        </div>

        <a href="{{ route('berita.index') }}"
           class="self-start inline-flex items-center gap-1.5 h-8 px-3 text-sm rounded-full
                  whitespace-nowrap border border-accent/60 text-accent
                  hover:bg-accent hover:text-white transition mt-3 sm:mt-2">
          Lihat semua
          <svg class="h-3.5 w-3.5" viewBox="0 0 24 24" fill="currentColor">
            <path d="M13 5l7 7-7 7-1.4-1.4L16.2 13H4v-2h12.2l-4.6-4.6L13 5z"/>
          </svg>
        </a>
      </div>

      @if($posts->isEmpty())
        <p class="text-sm text-gray-500">Belum ada berita dipublikasikan.</p>
      @else
        {{-- Sama seperti Agenda: center + 3 kolom di lg (kompensasi gap-5) --}}
        {{-- Cards: 2 kolom mobile, 4 kolom desktop, tampilkan 4 terbaru --}}
<div class="flex flex-wrap justify-center gap-5">
  @foreach($posts->take(4) as $p)
    <article
      class="ui-card is-hover w-[calc(50%-0.625rem)] lg:w-[calc(25%-0.9375rem)]
             flex flex-col rounded-2xl border border-gray-200/80 bg-white
             shadow-sm hover:shadow-lg hover:-translate-y-0.5 transition overflow-hidden">

      <div class="p-2">
        <div class="relative aspect-[4/5] rounded-xl overflow-hidden ring-1 ring-gray-200/70">
          @if($p->cover_image)
            <img src="{{ asset('storage/'.$p->cover_image) }}" alt="{{ $p->title }}"
                 class="w-full h-full object-cover object-center">
          @else
            <div class="w-full h-full bg-gradient-to-br from-navy/10 to-accent/10 grid place-content-center text-xs text-gray-600">
              Tanpa gambar
            </div>
          @endif

          @if($p->published_at)
            <span class="absolute top-2 left-2 px-2 py-0.5 rounded-full text-[11px] font-semibold bg-white/95 text-navy shadow">
              {{ $p->published_at->translatedFormat('d M Y') }}
            </span>
          @endif
        </div>
      </div>

      <div class="px-3.5 pb-3.5 flex flex-col grow">
        <a href="{{ route('berita.show', $p) }}"
           class="block text-[14px] font-semibold text-navy hover:text-accent leading-snug">
          {{ $p->title }}
        </a>
        <p class="mt-1 text-[12px] text-gray-500">{{ optional($p->published_at)->translatedFormat('d F Y') }}</p>
        <p class="mt-2 text-[12.5px] text-gray-600">
          {{ $p->excerpt ?? \Illuminate\Support\Str::limit(strip_tags($p->body ?? ''), 150) }}
        </p>

        <div class="mt-auto pt-3">
          <a href="{{ route('berita.show', $p) }}"
             class="inline-flex items-center gap-1 h-10 px-2.5 rounded-lg bg-accent text-white text-xs
                    hover:bg-accent/90 transition">
            Baca Selengkapnya
            <svg class="h-4 w-4" viewBox="0 0 24 24" fill="currentColor"><path d="M13 5l7 7-7 7-1.4-1.4L16.2 13H4v-2h12.2l-4.6-4.6L13 5z"/></svg>
          </a>
        </div>
      </div>
    </article>
  @endforeach
</div>

      @endif
    </div>
  </section>

  <!-- Tentang Singkat -->
  <section id="tentang" class="section-wrap py-14 text-center">
    <h2 class="text-xl font-bold mb-4">Tentang Himpunan</h2>
    <p class="text-gray-600 max-w-2xl mx-auto">
      HIMATEKNO adalah wadah mahasiswa Teknologi Informasi UMPWR untuk mengembangkan diri, berorganisasi, dan berprestasi.
    </p>

    <div class="mt-8 grid sm:grid-cols-3 gap-4">
      <div class="rounded-2xl border bg-white p-6 shadow-card">
        <div class="h-10 w-10 mx-auto rounded-full bg-accent/15 flex items-center justify-center mb-3">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-accent" viewBox="0 0 24 24" fill="currentColor">
            <path d="M12 2l4 7h-8l4-7zm0 20a8 8 0 100-16 8 8 0 000 16z"/>
          </svg>
        </div>
        <p class="font-semibold text-ink">Pengembangan</p>
        <p class="text-sm text-gray-600 mt-1">Kegiatan untuk mengasah hard & soft skills.</p>
      </div>
      <div class="rounded-2xl border bg-white p-6 shadow-card">
        <div class="h-10 w-10 mx-auto rounded-full bg-accent/15 flex items-center justify-center mb-3">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-accent" viewBox="0 0 24 24" fill="currentColor">
            <path d="M12 7l5 3-5 3-5-3 5-3zm0 8l5 3-5 3-5-3 5-3z"/>
          </svg>
        </div>
        <p class="font-semibold text-ink">Kolaborasi</p>
        <p class="text-sm text-gray-600 mt-1">Sinergi dengan komunitas internal & eksternal.</p>
      </div>
      <div class="rounded-2xl border bg-white p-6 shadow-card">
        <div class="h-10 w-10 mx-auto rounded-full bg-accent/15 flex items-center justify-center mb-3">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-accent" viewBox="0 0 24 24" fill="currentColor">
            <path d="M17 3H7v2h10V3zM5 7h14l-1.5 12.5a2 2 0 01-2 1.5H8.5a2 2 0 01-2-1.5L5 7z"/>
          </svg>
        </div>
        <p class="font-semibold text-ink">Prestasi</p>
        <p class="text-sm text-gray-600 mt-1">Fasilitasi lomba & kompetisi untuk berprestasi.</p>
      </div>
    </div>

    <a href="{{ url('/tentang') }}" class="mt-8 inline-block px-6 py-3 bg-navy text-white rounded-lg hover:bg-accent transition">Selengkapnya</a>
  </section>

  <!-- Galeri -->
  <section class="section-wrap py-12">
    <div class="mb-6 flex flex-col sm:flex-row items-start justify-between gap-3 sm:gap-4">
      <div>
        <span class="inline-flex items-center gap-2 text-[11px] font-semibold uppercase tracking-wide
                     px-2.5 py-1 rounded-full bg-accent/10 text-accent">
          <svg class="h-3.5 w-3.5" viewBox="0 0 24 24" fill="currentColor">
            <path d="M21 19V5a2 2 0 0 0-2-2H5C3.9 3 3 3.9 3 5v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2zM8 13l2.5 3.01L13 13l3 4H6l2-4zM8.5 8A1.5 1.5 0 1 1 7 9.5 1.5 1.5 0 0 1 8.5 8z"/>
          </svg>
          Galeri
        </span>
        <div class="mt-2 flex items-center gap-3">
          <h2 class="text-2xl font-extrabold text-ink">Galeri</h2>
          <span class="hidden sm:inline-block h-[3px] w-16 rounded-full bg-gradient-to-r from-accent to-navy"></span>
        </div>
        <p class="mt-1 text-sm text-gray-500">Dokumentasi kegiatan HIMATEKNO terbaru.</p>
      </div>

      <a href="{{ route('galeri.index') }}"
         class="self-start inline-flex items-center gap-1.5 h-8 px-3 text-sm rounded-full
                whitespace-nowrap border border-accent/60 text-accent
                hover:bg-accent hover:text-white transition mt-3 sm:mt-2">
        Lihat semua
        <svg class="h-3.5 w-3.5" viewBox="0 0 24 24" fill="currentColor">
          <path d="M13 5l7 7-7 7-1.4-1.4L16.2 13H4v-2h12.2l-4.6-4.6L13 5z"/>
        </svg>
      </a>
    </div>

    @if($photos->isEmpty())
      <p class="text-sm text-gray-500">Belum ada foto galeri.</p>
    @else
      {{-- Center + 3 kolom di sm, kompensasi gap-3 (0.75rem):
          sm => (100% - 1.5rem)/3  => sm:w-[calc(33.333%-0.5rem)] --}}
      <div class="flex flex-wrap gap-3 justify-center">
        @foreach($photos as $ph)
          <figure class="ui-card is-hover p-2 w-full sm:w-[calc(33.333%-0.5rem)]">
            <div class="group relative overflow-hidden rounded-xl aspect-[16/9]">
              <img src="{{ asset('storage/'.$ph->image_path) }}" alt=""
                   class="h-full w-full object-cover object-center transition-transform duration-200 group-hover:scale-[1.02]" loading="lazy">
            </div>
          </figure>
        @endforeach
      </div>
    @endif
  </section>

  <!-- CTA Banner -->
  <section class="relative overflow-hidden">
    <div class="section-wrap">
      <div class="relative rounded-2xl border bg-gradient-to-r from-navy to-accent text-white p-8 md:p-12">
        <div class="max-w-2xl">
          <h3 class="text-2xl font-extrabold">Punya ide kegiatan atau ingin berkolaborasi?</h3>
          <p class="mt-2 text-white/90">Hubungi kami untuk merancang kegiatan yang berdampak bagi mahasiswa.</p>
          <div class="mt-5 flex flex-wrap gap-3">
            <a href="{{ route('kontak') }}" class="px-6 py-3 rounded-lg bg-white text-navy font-bold hover:opacity-90 transition">Kontak HIMATEKNO</a>

        </div>
      </div>
    </div>
  </section>

@endsection
