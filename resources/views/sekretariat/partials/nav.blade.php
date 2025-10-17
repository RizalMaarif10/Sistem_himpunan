<header class="bg-white border-b">
  <div class="max-w-7xl mx-auto px-4 h-16 flex items-center justify-between">
    <a href="{{ route('sekretariat.dashboard') }}" class="flex items-center gap-2">
      <img src="{{ asset('images/logo.png') }}" class="h-8 w-8 object-contain" alt="HIMATEKNO">
      <span class="font-semibold">Sekretariat</span>
      <span class="text-xs px-2 py-0.5 rounded-full bg-slate-100 text-slate-700">Panel</span>
    </a>

    <nav class="hidden md:flex items-center gap-1 text-sm">
      <a href="{{ route('sekretariat.dashboard') }}" class="px-3 py-2 rounded-lg {{ request()->routeIs('sekretariat.dashboard') ? 'bg-gray-100 font-medium' : 'hover:bg-gray-100' }}">Dashboard</a>
      <a href="{{ route('sekretariat.letters.index') }}" class="px-3 py-2 rounded-lg {{ request()->routeIs('sekretariat.letters.*') ? 'bg-gray-100 font-medium' : 'hover:bg-gray-100' }}">Surat</a>
      <a href="{{ route('sekretariat.minutes.index') }}" class="px-3 py-2 rounded-lg {{ request()->routeIs('sekretariat.minutes.*') ? 'bg-gray-100 font-medium' : 'hover:bg-gray-100' }}">Notulen</a>
      <a href="{{ route('sekretariat.messages.index') }}" class="px-3 py-2 rounded-lg {{ request()->routeIs('sekretariat.messages.*') ? 'bg-gray-100 font-medium' : 'hover:bg-gray-100' }}">Pesan</a>

    </nav>

    <div class="flex items-center gap-3">
      @auth
        <div class="hidden sm:flex items-center gap-2 text-sm text-gray-600">

          <span class="px-2 py-0.5 rounded-full bg-gray-100 text-gray-700">Sekretaris</span>
        </div>
        <form method="POST" action="{{ route('logout') }}">@csrf
          <button class="px-3 py-2 rounded-lg border hover:bg-gray-50 text-sm">Keluar</button>
        </form>
      @endauth
    </div>
  </div>
</header>
