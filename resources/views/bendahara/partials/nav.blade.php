<header class="bg-white border-b">
  <div class="max-w-7xl mx-auto px-4 h-16 flex items-center justify-between">

    {{-- Brand --}}
    <a href="{{ route('bendahara.dashboard') }}" class="flex items-center gap-2">
      <img src="{{ asset('images/logo.png') }}" alt="HIMATEKNO" class="h-8 w-8 object-contain">
      <span class="font-semibold">Bendahara</span>
      <span class="text-xs px-2 py-0.5 rounded-full bg-slate-100 text-slate-700">Panel</span>
    </a>

    {{-- Menu utama (hanya link yang ada routenya) --}}
    <nav class="hidden md:flex items-center gap-1 text-sm">
  <a href="{{ route('bendahara.dashboard') }}" class="px-3 py-2 rounded-lg {{ request()->routeIs('bendahara.dashboard') ? 'bg-gray-100 font-medium' : 'hover:bg-gray-100' }}">Dashboard</a>
  <a href="{{ route('bendahara.cash.index') }}" class="px-3 py-2 rounded-lg {{ request()->routeIs('bendahara.cash.*') ? 'bg-gray-100 font-medium' : 'hover:bg-gray-100' }}">Riwayat Transaksi</a>
  <a href="{{ route('bendahara.incomes.index') }}" class="px-3 py-2 rounded-lg {{ request()->routeIs('bendahara.incomes.*') ? 'bg-gray-100 font-medium' : 'hover:bg-gray-100' }}">Pemasukan</a>
  <a href="{{ route('bendahara.expenses.index') }}" class="px-3 py-2 rounded-lg {{ request()->routeIs('bendahara.expenses.*') ? 'bg-gray-100 font-medium' : 'hover:bg-gray-100' }}">Pengeluaran</a>
  <a href="{{ route('bendahara.categories.index') }}" class="px-3 py-2 rounded-lg {{ request()->routeIs('bendahara.categories.*') ? 'bg-gray-100 font-medium' : 'hover:bg-gray-100' }}">Kategori</a>
  <a href="{{ route('bendahara.accounts.index') }}" class="px-3 py-2 rounded-lg {{ request()->routeIs('bendahara.accounts.*') ? 'bg-gray-100 font-medium' : 'hover:bg-gray-100' }}">Rekening</a>
  <a href="{{ route('bendahara.reports.index') }}" class="px-3 py-2 rounded-lg {{ request()->routeIs('bendahara.reports.*') ? 'bg-gray-100 font-medium' : 'hover:bg-gray-100' }}">Laporan</a>

</nav>


    {{-- User & Logout --}}
    <div class="flex items-center gap-3">
      @auth
        <div class="hidden sm:flex items-center gap-2 text-sm text-gray-600">

          <span class="px-2 py-0.5 rounded-full bg-gray-100 text-gray-700">Bendahara</span>
        </div>

        <form method="POST" action="{{ route('logout') }}">
          @csrf
          <button class="px-3 py-2 rounded-lg border hover:bg-gray-50 text-sm">Keluar</button>
        </form>
      @endauth
    </div>
  </div>
</header>
