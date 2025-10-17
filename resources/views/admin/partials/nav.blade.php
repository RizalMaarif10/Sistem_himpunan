@php
  $is = fn($pattern) => request()->routeIs($pattern);

  // hitung roles sekali saja untuk dipakai di desktop & mobile
  $roles = '';
  if (auth()->check()) {
    $roles = auth()->user()->loadMissing('roles')->roles->pluck('display_name')->implode(', ');
  }

  $menu = [
    ['label'=>'Dashboard',        'route'=>'admin.dashboard',           'active'=>$is('admin.dashboard')],
    ['label'=>'Agenda',           'route'=>'admin.events.index',        'active'=>$is('admin.events.*')],
    ['label'=>'Berita',           'route'=>'admin.posts.index',         'active'=>$is('admin.posts.*')],
    ['label'=>'Galeri',           'route'=>'admin.photos.index',        'active'=>$is('admin.photos.*')],

    // Tambahan: admin bisa melihat Notulen & Laporan Keuangan
    ['label'=>'Notulen',          'route'=>'sekretariat.minutes.index', 'active'=>$is('sekretariat.minutes.*')],
    ['label'=>'Laporan Keuangan', 'route'=>'bendahara.reports.index',   'active'=>$is('bendahara.reports.*')],
  ];

  $userName = auth()->user()->name ?? '';
  $parts = preg_split('/\s+/', trim($userName), -1, PREG_SPLIT_NO_EMPTY);
  $initials = mb_substr($parts[0] ?? '',0,1) . mb_substr($parts[1] ?? '',0,1);
@endphp


<header class="sticky top-0 z-40 bg-white/80 backdrop-blur border-b">
  {{-- Skip link untuk aksesibilitas (pastikan <main id="main"> pada layout) --}}
  <a href="#main" class="sr-only focus:not-sr-only focus:absolute focus:left-4 focus:top-4 focus:z-50 bg-white px-3 py-2 rounded-lg border text-sm">
    Lewati ke konten utama
  </a>

  <div class="max-w-7xl mx-auto px-4 h-16 flex items-center justify-between">
    {{-- Brand --}}
    <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-2 group">
      <img src="{{ asset('images/logo.png') }}" alt="HIMATEKNO" class="h-8 w-8 object-contain rounded-md">
      <span class="font-semibold tracking-tight group-hover:text-slate-900">Panel Pengurus</span>
    </a>

    {{-- Menu desktop --}}
    <nav class="hidden md:flex items-center gap-1 text-sm">
      @foreach ($menu as $m)
        <a href="{{ route($m['route']) }}"
           class="px-3 py-2 rounded-lg transition
                  {{ $m['active'] ? 'bg-gray-100 text-slate-900 font-semibold' : 'text-slate-600 hover:bg-gray-100' }}">
          {{ $m['label'] }}
        </a>
      @endforeach
    </nav>

    {{-- User + Toggle --}}
    <div class="flex items-center gap-2">
      @auth
        <div class="hidden sm:flex items-center gap-3">
          <div class="h-9 w-9 rounded-full bg-gray-200 grid place-items-center text-sm font-semibold text-gray-700">
            {{ strtoupper($initials ?: 'PG') }}
          </div>
          <div class="hidden md:block leading-tight">
            <div class="font-medium text-sm">{{ $userName }}</div>
            @php
              $roles = auth()->user()->loadMissing('roles')->roles->pluck('display_name')->implode(', ');
            @endphp
            <div class="text-xs text-gray-500">{{ $roles ?: 'Pengurus' }}</div>
          </div>
        </div>
        <form method="POST" action="{{ route('logout') }}" class="hidden md:block">
          @csrf
          <button class="btn btn-outline">Keluar</button>
        </form>
      @endauth

      {{-- Toggle mobile --}}
      <button id="navToggle"
              class="md:hidden inline-flex items-center justify-center h-9 w-9 rounded-lg border hover:bg-gray-50"
              aria-label="Buka menu" aria-expanded="false">
        <svg id="iconBars" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor">
          <path stroke-linecap="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
        </svg>
        <svg id="iconX" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 hidden" viewBox="0 0 24 24" fill="none" stroke="currentColor">
          <path stroke-linecap="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
        </svg>
      </button>
    </div>
  </div>

  {{-- Menu mobile --}}
  <div id="mobileMenu" class="md:hidden hidden border-t">
    <nav class="px-4 py-3 flex flex-col gap-1 text-sm">
      @foreach ($menu as $m)
        <a href="{{ route($m['route']) }}"
           class="px-3 py-2 rounded-lg {{ $m['active'] ? 'bg-gray-100 font-semibold' : 'hover:bg-gray-100' }}">
          {{ $m['label'] }}
        </a>
      @endforeach

      @auth
        <div class="pt-2">
          <div class="px-3 py-2 text-xs text-gray-500">{{ $userName }} {{ $roles ? '— '.$roles : '' }}</div>
          <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button class="w-full btn btn-outline">Keluar</button>
          </form>
        </div>
      @endauth
    </nav>
  </div>
</header>

{{-- Toggle script ringan --}}
<script>
  (function () {
    const btn  = document.getElementById('navToggle');
    const menu = document.getElementById('mobileMenu');
    const bars = document.getElementById('iconBars');
    const x    = document.getElementById('iconX');
    if (!btn || !menu) return;

    btn.addEventListener('click', () => {
      const open = !menu.classList.contains('hidden');
      menu.classList.toggle('hidden');
      bars.classList.toggle('hidden');
      x.classList.toggle('hidden');
      btn.setAttribute('aria-expanded', String(!open));
    });
  })();
</script>
