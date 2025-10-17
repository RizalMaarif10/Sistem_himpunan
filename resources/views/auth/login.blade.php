@extends('auth.layouts.app')
@section('title','Masuk - HIMATEKNO')

@section('content')
<div class="w-full max-w-6xl grid gap-8 lg:grid-cols-2 items-stretch">
  {{-- Kartu brand --}}
  <div class="auth-card p-8 flex">
    <div class="m-auto w-full">
      <div class="flex items-center gap-3 mb-6">
        <img src="{{ asset('images/logo.png') }}" class="h-10 w-10 rounded-md object-contain" alt="HIMATEKNO">
        <div>
          <div class="text-lg font-bold text-slate-900 leading-tight">Panel Pengurus</div>
          <div class="text-sm text-slate-500">HIMATEKNO UMP</div>
        </div>
      </div>

      <h2 class="text-[26px] sm:text-3xl font-bold text-slate-900 leading-snug">
        Selamat datang kembali
        <span aria-hidden="true">👋</span>
      </h2>
      <p class="mt-2 text-slate-600">Kelola agenda, berita, dan galeri himpunan dalam satu tempat yang rapi.</p>

      <ul class="mt-6 space-y-3 text-slate-700 text-sm">
        <li class="flex items-center gap-3">
          <span class="h-2.5 w-2.5 rounded-full bg-blue-500/70"></span> Manajemen konten cepat dan konsisten.
        </li>
        <li class="flex items-center gap-3">
          <span class="h-2.5 w-2.5 rounded-full bg-blue-500/70"></span> Desain bersih, fokus pada data penting.
        </li>
        <li class="flex items-center gap-3">
          <span class="h-2.5 w-2.5 rounded-full bg-blue-500/70"></span> Akses aman untuk pengurus terpilih.
        </li>
      </ul>
    </div>
  </div>

  {{-- Kartu form --}}
  <div class="auth-card p-8">
    <h1 class="text-3xl font-bold text-slate-900 mb-6">Masuk</h1>

    @if ($errors->any())
      <div class="mb-5 rounded-lg border border-red-200 bg-red-50 text-red-700 px-4 py-3">
        <ul class="list-disc pl-5">
          @foreach ($errors->all() as $err) <li>{{ $err }}</li> @endforeach
        </ul>
      </div>
    @endif

    <form method="POST" action="{{ route('login.store') }}" class="space-y-4" autocomplete="on">
      @csrf
      <div class="field">
  <label for="email" class="block text-sm font-medium text-slate-700 mb-1.5">Email</label>
  <svg class="icon h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor">
    <path stroke-width="2" stroke-linecap="round" d="M4 7h16v10a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V7zm0 0l8 6 8-6"/>
  </svg>
  <input id="email" type="email" name="email" required class="input">
</div>

<div class="field">
  <label for="password" class="block text-sm font-medium text-slate-700 mb-1.5">Kata Sandi</label>
  <svg class="icon h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor">
    <path stroke-width="2" stroke-linecap="round" d="M6 11V9a6 6 0 1 1 12 0v2"/>
    <rect x="4" y="11" width="16" height="9" rx="2" stroke-width="2"></rect>
  </svg>
  <input id="password" type="password" name="password" required class="input pr-10">
  <button type="button" id="togglePwd" class="trailing hover:text-slate-700">
    <svg id="eye" class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor">
      <path stroke-width="2" d="M2 12s4-7 10-7 10 7 10 7-4 7-10 7S2 12 2 12z"/>
      <circle cx="12" cy="12" r="3" stroke-width="2"/>
    </svg>
    <svg id="eyeOff" class="h-4 w-4 hidden" viewBox="0 0 24 24" fill="none" stroke="currentColor">
      <path stroke-width="2" d="M3 3l18 18M3 12s4 7 9 7c2.4 0 4.3-.7 5.8-1.7M21 12s-4-7-9-7c-1.1 0-2.2.2-3.2.6"/>
    </svg>
  </button>
</div>


      <div class="flex items-center justify-between text-sm">
        <label class="inline-flex items-center gap-2">
          <input type="checkbox" name="remember" value="1" {{ old('remember') ? 'checked' : '' }}>
          Ingat saya
        </label>
        @if (Route::has('password.request'))
          <a href="{{ route('password.request') }}" class="text-blue-600 hover:underline">Lupa sandi?</a>
        @endif
      </div>

      <button class="btn btn-primary w-full">Masuk</button>
    </form>

    <div class="text-center text-sm text-gray-600 mt-4">
      Kembali ke <a href="{{ route('home') }}" class="text-blue-600 hover:underline">Beranda</a>
    </div>
  </div>
</div>

@push('scripts')
<script>
  (function(){
    const btn = document.getElementById('togglePwd');
    const input = document.getElementById('password');
    const eye = document.getElementById('eye');
    const eyeOff = document.getElementById('eyeOff');
    if(!btn || !input) return;
    btn.addEventListener('click', () => {
      const t = input.type === 'password';
      input.type = t ? 'text' : 'password';
      eye.classList.toggle('hidden', !t);
      eyeOff.classList.toggle('hidden', t);
    });
  })();
</script>
@endpush
@endsection
