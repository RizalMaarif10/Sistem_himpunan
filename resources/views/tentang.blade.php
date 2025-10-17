@extends('layouts.app')
@section('title','Tentang - HIMATEKNO')

@section('content')

{{-- ===== Hero (logo tanpa box) ===== --}}
{{-- ===== Hero (logo tanpa box, spasi kanan lega) ===== --}}
<section class="relative overflow-hidden bg-gradient-to-b from-white via-white to-soft py-16">
  {{-- dekorasi halus --}}
  <div class="pointer-events-none absolute -top-20 -right-16 h-64 w-64 rounded-full bg-accent/20 blur-3xl"></div>
  <div class="pointer-events-none absolute -bottom-24 -left-24 h-72 w-72 rounded-full bg-navy/10 blur-3xl"></div>

  <div class="max-w-7xl mx-auto px-6 md:px-10">
    <div class="grid lg:grid-cols-12 gap-10 lg:gap-16 xl:gap-20 items-center">
      {{-- teks --}}
      <div class="lg:col-span-7">
        <h1 class="text-3xl md:text-5xl font-extrabold leading-tight text-ink">
          Tentang <span class="text-accent">HIMATEKNO</span>
        </h1>
        <p class="mt-4 text-gray-600 text-base md:text-lg leading-relaxed max-w-2xl">
          Himpunan Mahasiswa Teknologi Informasi Universitas Muhammadiyah Purworejo sebagai wadah
          pengembangan diri, kolaborasi, dan kontribusi mahasiswa.
        </p>
        <div class="mt-6 flex flex-wrap gap-3">
          <a href="{{ route('agenda.index') }}"
             class="group inline-flex items-center gap-2 px-6 py-3 rounded-xl bg-navy text-white hover:bg-accent transition
                    focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-accent/60">
            Lihat Agenda
            <svg class="w-4 h-4 translate-x-0 group-hover:translate-x-0.5 transition" viewBox="0 0 24 24" fill="currentColor"><path d="M13 5l7 7-7 7M5 12h14"/></svg>
          </a>
          <a href="{{ route('berita.index') }}"
             class="inline-flex items-center gap-2 px-6 py-3 rounded-xl border border-navy text-navy hover:bg-gray-50 transition
                    focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-accent/60">
            Berita Terbaru
          </a>
        </div>
      </div>

      {{-- logo: diberi padding kanan responsif --}}
      <div class="lg:col-span-5 flex justify-center xl:justify-end pr-4 sm:pr-8 lg:pr-14 xl:pr-24 2xl:pr-[12vw]">
        <img
          src="{{ asset('images/logo.png') }}"
          alt="Logo HIMATEKNO"
          class="w-44 sm:w-56 md:w-72 xl:w-80 2xl:w-[22rem] h-auto object-contain drop-shadow-md select-none pointer-events-none"
          loading="lazy" decoding="async">
      </div>
    </div>
  </div>
</section>


{{-- ===== Profil Singkat ===== --}}
<section class="relative">
  <div class="max-w-6xl mx-auto px-4 py-16">
    <div class="grid md:grid-cols-12 gap-6">
      <div class="md:col-span-4">
        <h2 class="text-2xl font-bold text-ink">Profil Singkat</h2>
      </div>
      <div class="md:col-span-8">
        <p class="text-gray-700 text-base md:text-lg leading-relaxed">
          HIMATEKNO hadir untuk memfasilitasi minat, bakat, dan pengembangan karir mahasiswa di bidang
          Teknologi Informasi. Melalui program kerja yang terencana, kami berupaya melahirkan karya,
          prestasi, dan ekosistem kolaboratif antara mahasiswa, dosen, dan mitra eksternal.
        </p>
      </div>
    </div>
  </div>
  <div class="absolute inset-x-0 bottom-0 h-px bg-gradient-to-r from-transparent via-gray-200 to-transparent"></div>
</section>

{{-- ===== Visi & Misi ===== --}}
<section class="bg-soft">
  <div class="max-w-6xl mx-auto px-4 py-16">
    <div class="grid md:grid-cols-2 gap-8">
      {{-- Visi --}}
      <div class="relative rounded-2xl border bg-white p-6 shadow-sm">
        <div class="absolute -top-1 left-6 h-1 w-10 rounded-full bg-accent/70"></div>
        <header class="flex items-center gap-3">
          <span class="inline-flex h-10 w-10 items-center justify-center rounded-xl bg-accent/10 text-accent">
            <svg class="w-5 h-5" viewBox="0 0 24 24" fill="currentColor">
              <path d="M12 4l6 4-6 4-6-4 6-4zm0 8l6 4-6 4-6-4 6-4z"/>
            </svg>
          </span>
          <h3 class="text-xl font-bold">Visi</h3>
        </header>
        <p class="mt-3 text-gray-700 leading-relaxed">
          {{ $visi }}
        </p>
      </div>

      {{-- Misi --}}
      <div class="relative rounded-2xl border bg-white p-6 shadow-sm">
        <div class="absolute -top-1 left-6 h-1 w-10 rounded-full bg-navy/70"></div>
        <header class="flex items-center gap-3">
          <span class="inline-flex h-10 w-10 items-center justify-center rounded-xl bg-navy/10 text-navy">
            <svg class="w-5 h-5" viewBox="0 0 24 24" fill="currentColor"><path d="M5 13l4 4L19 7"/></svg>
          </span>
          <h3 class="text-xl font-bold">Misi</h3>
        </header>

        <ul class="mt-4 grid gap-3" role="list">
          @forelse($misi as $item)
            <li class="flex items-start gap-3 rounded-xl border p-3 hover:shadow-sm transition">
              <span class="mt-2 inline-block h-2 w-2 flex-none rounded-full bg-accent"></span>
              <span class="text-gray-700 leading-relaxed">{{ $item }}</span>
            </li>
          @empty
            <li class="text-gray-500">Belum ada misi yang ditambahkan.</li>
          @endforelse
        </ul>
      </div>
    </div>
  </div>
</section>

@endsection
