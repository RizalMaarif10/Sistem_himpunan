{{-- resources/views/partials/navbar.blade.php --}}
@php
  $isHome    = url()->current() === url('/');
  $isAgenda  = request()->is('agenda*');
  $isBerita  = request()->is('berita*');
  $isGaleri  = request()->is('galeri*');
  $isTentang = request()->is('tentang*');
  $isKontak  = request()->is('kontak*');
@endphp

<header id="siteHeader"
  class="sticky top-0 z-50 bg-gradient-to-b from-navy to-[#1e467f] text-white border-b border-white/10 backdrop-blur supports-[backdrop-filter]:bg-navy/90 transition-shadow">
  <div id="navInner" class="max-w-6xl mx-auto px-4 py-3">
    <div class="flex items-center justify-between gap-4">
      <!-- Brand -->
      <a href="{{ url('/') }}" class="flex items-center gap-2 font-bold text-lg shrink-0 focus:outline-none focus:ring-2 focus:ring-white/40 rounded-lg px-1">
        <img src="{{ asset('images/logo.png') }}" class="h-9 w-9 rounded-full ring-2 ring-white/20" alt="Logo">
        <span class="tracking-wide">HIMATEKNO</span>
      </a>

      <!-- Desktop nav -->
      <nav class="hidden md:flex items-center gap-1 text-sm">
        @php
          $links = [
            ['label'=>'Beranda','href'=>url('/'),                 'active'=>$isHome],
            ['label'=>'Agenda', 'href'=>route('agenda.index'),    'active'=>$isAgenda],
            ['label'=>'Berita', 'href'=>route('berita.index'),    'active'=>$isBerita],
            ['label'=>'Galeri', 'href'=>route('galeri.index'),    'active'=>$isGaleri],
            ['label'=>'Tentang','href'=>url('/tentang'),          'active'=>$isTentang],
          ];
        @endphp

        @foreach($links as $l)
          <a href="{{ $l['href'] }}" aria-current="{{ $l['active'] ? 'page' : 'false' }}"
             class="group relative px-3 py-2 rounded-lg
                    text-white/100 hover:text-white focus:outline-none focus-visible:ring-2 focus-visible:ring-white/50 font-bold">
            <span>{{ $l['label'] }}</span>
            <span class="pointer-events-none absolute left-3 right-3 -bottom-[6px] h-[2px] origin-left transition-transform duration-200
                         {{ $l['active'] ? 'bg-accent scale-x-100' : 'bg-white/100 scale-x-0 group-hover:scale-x-100' }}"></span>
          </a>
        @endforeach

        <!-- CTA: Hubungi Kami (desktop only) -->
        <a href="{{ url('/kontak') }}" aria-current="{{ $isKontak ? 'page' : 'false' }}"
           class="ml-2 inline-flex items-center rounded-full border px-3 py-1.5 text-[13px]
                  focus:outline-none focus-visible:ring-2 focus-visible:ring-white/50
                  {{ $isKontak
                      ? 'bg-white text-accent border-transparent font-bold'
                      : 'border-white/60 text-white/100 hover:text-white hover:border-white/90 hover:bg-white/10 font-bold' }}">
          Hubungi Kami
        </a>
      </nav>

      <!-- Mobile toggle -->
      <button id="navToggle" type="button"
              class="md:hidden inline-flex items-center justify-center rounded-lg p-2 ring-1 ring-white/20 hover:ring-white/40 focus:outline-none"
              aria-controls="mobileMenu" aria-expanded="false" aria-label="Toggle navigation">
        <svg id="iconOpen" xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
             viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"/></svg>
        <svg id="iconClose" xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 hidden" fill="none"
             viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
      </button>
    </div>

    <!-- Mobile menu -->
    <div id="mobileMenu" class="md:hidden hidden">
      <div class="pt-3 pb-2">
        <nav class="grid gap-1 text-sm">
          <a href="{{ url('/') }}"              class="px-3 py-2 rounded-lg {{ $isHome ? 'bg-white text-navy'   : 'text-white/90 hover:bg-white/10' }}">Beranda</a>
          <a href="{{ route('agenda.index') }}" class="px-3 py-2 rounded-lg {{ $isAgenda ? 'bg-white text-navy' : 'text-white/90 hover:bg-white/10' }}">Agenda</a>
          <a href="{{ route('berita.index') }}" class="px-3 py-2 rounded-lg {{ $isBerita ? 'bg-white text-navy' : 'text-white/90 hover:bg-white/10' }}">Berita</a>
          <a href="{{ route('galeri.index') }}" class="px-3 py-2 rounded-lg {{ $isGaleri ? 'bg-white text-navy' : 'text-white/90 hover:bg-white/10' }}">Galeri</a>
          <a href="{{ url('/tentang') }}"       class="px-3 py-2 rounded-lg {{ $isTentang ? 'bg-white text-navy': 'text-white/90 hover:bg-white/10' }}">Tentang</a>
        </nav>

        <div class="mt-3 px-1">
          <a href="{{ url('/kontak') }}" class="w-full inline-flex items-center justify-center rounded-full px-4 py-2 bg-accent text-white">
            Hubungi Kami
          </a>
        </div>
      </div>
    </div>
  </div>
</header>

<script>
  // Hanya tambah/hapus shadow saat scroll — TIDAK mengubah ukuran/padding
  const header = document.getElementById('siteHeader');
  document.addEventListener('scroll', () => {
    if (window.scrollY > 8) header.classList.add('shadow-md');
    else header.classList.remove('shadow-md');
  });

  // Toggle mobile menu
  const btn = document.getElementById('navToggle');
  const menu = document.getElementById('mobileMenu');
  const icoOpen = document.getElementById('iconOpen');
  const icoClose = document.getElementById('iconClose');
  if (btn) btn.addEventListener('click', () => {
    const expanded = btn.getAttribute('aria-expanded') === 'true';
    btn.setAttribute('aria-expanded', String(!expanded));
    menu.classList.toggle('hidden');
    icoOpen.classList.toggle('hidden');
    icoClose.classList.toggle('hidden');
  });
</script>
