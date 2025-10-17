{{-- resources/views/partials/footer.blade.php --}}
<footer class="relative mt-16 bg-gradient-to-b from-[#123b73] to-[#0f2f5b] text-white">
  {{-- dekorasi lembut --}}
  <div class="absolute inset-0 pointer-events-none bg-[radial-gradient(80%_60%_at_10%_0%,rgba(255,255,255,0.06),transparent_60%)]"></div>

  {{-- content --}}
  <div class="relative section-wrap py-12">
    <div class="grid gap-10 sm:gap-12 md:grid-cols-12">
      {{-- Brand & alamat --}}
      <div class="md:col-span-5">
        <div class="flex items-center gap-3">
          <img src="{{ asset('images/logo.png') }}" class="h-10 w-10 rounded-full border border-white/20" alt="Logo HIMATEKNO">
          <span class="text-lg font-semibold tracking-wide">HIMATEKNO</span>
        </div>

        <address class="not-italic mt-4 space-y-1 text-white/75">
          <div>Universitas Muhammadiyah Purworejo</div>
          <div>Jl. Tentara Pelajar No.55, Purworejo</div>
        </address>

        <a href="https://maps.app.goo.gl/" target="_blank" rel="noopener"
           class="mt-3 inline-flex items-center gap-1 text-white/80 hover:text-white underline underline-offset-4">
          <svg class="h-4 w-4" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2a7 7 0 00-7 7c0 5.25 7 13 7 13s7-7.75 7-13a7 7 0 00-7-7zm0 9.5a2.5 2.5 0 110-5 2.5 2.5 0 010 5z"/></svg>
          Lihat peta
        </a>
      </div>

      {{-- Navigasi --}}
      <nav aria-label="Navigasi footer" class="md:col-span-2">
        <h4 class="text-sm font-semibold tracking-wide text-white/90">Navigasi</h4>
        <ul class="mt-3 space-y-2 text-white/75">
          <li><a href="{{ url('/') }}" class="hover:text-white">Beranda</a></li>
          <li><a href="{{ route('agenda.index') }}" class="hover:text-white">Agenda</a></li>
          <li><a href="{{ route('berita.index') }}" class="hover:text-white">Berita</a></li>
          <li><a href="{{ route('galeri.index') }}" class="hover:text-white">Galeri</a></li>
          <li><a href="{{ url('/tentang') }}" class="hover:text-white">Tentang</a></li>
          <li><a href="{{ url('/kontak') }}" class="hover:text-white">Kontak</a></li>
        </ul>
      </nav>

      {{-- Kontak --}}
      <div class="md:col-span-3">
        <h4 class="text-sm font-semibold tracking-wide text-white/90">Kontak</h4>
        <ul class="mt-3 space-y-2 text-white/75">
          <li>Email:
            <a href="mailto:himatekno@gmail.com" class="hover:text-white">himatekno@gmail.com</a>
          </li>
          <li>Jam: Senin–Jumat 08.00–16.00</li>
        </ul>
      </div>

      {{-- Media sosial --}}
      {{-- Media sosial --}}
<div class="md:col-span-2">
  <h4 class="text-sm font-semibold tracking-wide text-white/90">Media Sosial</h4>

  <div class="mt-3 flex items-center gap-3">
    {{-- Instagram: @himatekno_umpwr --}}
    <a href="https://instagram.com/himatekno_umpwr" target="_blank" rel="noopener"
       class="inline-flex h-10 w-10 items-center justify-center rounded-full border border-white/15 bg-white/10
              hover:bg-white/20 transition focus:outline-none focus-visible:ring-2 focus-visible:ring-white/60"
       aria-label="Instagram @himatekno_umpwr">
      <svg class="h-5 w-5 text-white/90" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
        <path d="M7 2h10a5 5 0 015 5v10a5 5 0 01-5 5H7a5 5 0 01-5-5V7a5 5 0 015-5zm5 5a5 5 0 100 10 5 5 0 000-10zm6.5-.75a1.25 1.25 0 11-2.5 0 1.25 1.25 0 012.5 0zM12 9a3 3 0 110 6 3 3 0 010-6z"/>
      </svg>
    </a>

    {{-- TikTok: @himatekno.official --}}
    <a href="https://www.tiktok.com/@himatekno.official" target="_blank" rel="noopener"
       class="inline-flex h-10 w-10 items-center justify-center rounded-full border border-white/15 bg-white/10
              hover:bg-white/20 transition focus:outline-none focus-visible:ring-2 focus-visible:ring-white/60"
       aria-label="TikTok @himatekno.official">
      <svg class="h-5 w-5 text-white/90" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
        <path d="M14.5 2h2.2c.2 2.2 1.6 3.8 3.8 4v2.2c-1.6 0-3-.5-4.2-1.3v6.8c0 3.7-3 6.3-6.6 6.3-3.4 0-6.4-2.7-6.4-6.2 0-3.2 2.5-5.8 5.7-6.1.5 0 1 .4 1 .9v2.3c-2 .2-3.4 1.2-3.4 2.9 0 1.7 1.4 3 3.1 3 2 0 3.3-1.4 3.3-3.2V2z"/>
      </svg>
    </a>
  </div>


</div>

    </div>
  </div>

  {{-- bottom bar --}}
  <div class="relative border-t border-white/10">
    <div class="section-wrap py-5 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between text-[13px] text-white/75">
      <p>© {{ date('Y') }} HIMATEKNO. All rights reserved.</p>
      <div class="flex flex-wrap items-center gap-x-4 gap-y-2">
        <a href="{{ route('agenda.index') }}" class="hover:text-white">Agenda</a>
        <a href="{{ route('berita.index') }}" class="hover:text-white">Berita</a>
        <a href="{{ url('/kontak') }}" class="hover:text-white">Kontak</a>
      </div>
    </div>
  </div>
</footer>
