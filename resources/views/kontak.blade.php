@extends('layouts.app')
@section('title', 'Kontak - HIMATEKNO')

@section('content')
    <section class="relative overflow-hidden bg-gradient-to-b from-white via-white to-soft py-16">
        {{-- dekorasi lembut --}}
        <div class="pointer-events-none absolute -top-16 -right-20 h-64 w-64 rounded-full bg-accent/20 blur-3xl"></div>
        <div class="pointer-events-none absolute -bottom-24 -left-24 h-72 w-72 rounded-full bg-navy/10 blur-3xl"></div>

        <div class="max-w-7xl mx-auto px-6 md:px-10 grid lg:grid-cols-2 gap-12 items-start">
            {{-- ===== Info Kontak ===== --}}
            <div>

                <h1 class="mt-3 text-3xl md:text-5xl font-extrabold leading-tight text-ink">Kontak</h1>
                <p class="mt-3 text-gray-600 text-base md:text-lg leading-relaxed max-w-2xl">
                    Ada pertanyaan, kritik, saran, atau ajakan kolaborasi? Kirim pesan lewat formulir,
                    atau hubungi kami via info berikut.
                </p>

                @php $i = $info ?? []; @endphp
                <div class="mt-8 grid sm:grid-cols-2 gap-4">
                    <div class="rounded-2xl border bg-white p-4 shadow-sm">
                        <div class="flex items-start gap-3">
                            <svg class="w-5 h-5 text-accent mt-0.5" viewBox="0 0 24 24" fill="currentColor">
                                <path
                                    d="M12 2C8.1 2 5 5.1 5 9c0 5.2 7 13 7 13s7-7.8 7-13c0-3.9-3.1-7-7-7zm0 9.5c-1.4 0-2.5-1.1-2.5-2.5S10.6 6.5 12 6.5s2.5 1.1 2.5 2.5S13.4 11.5 12 11.5z" />
                            </svg>
                            <div>
                                <div class="text-sm text-gray-500">Alamat</div>
                                <div class="font-medium text-ink">{{ data_get($i, 'address', '-') }}</div>
                            </div>
                        </div>
                    </div>

                    <div class="rounded-2xl border bg-white p-4 shadow-sm">
                        <div class="flex items-start gap-3">
                            <svg class="w-5 h-5 text-accent mt-0.5" viewBox="0 0 24 24" fill="currentColor">
                                <path
                                    d="M20 4H4a2 2 0 00-2 2v.5l10 6.25L22 6.5V6a2 2 0 00-2-2zm0 4.75l-8 5-8-5V18a2 2 0 002 2h12a2 2 0 002-2V8.75z" />
                            </svg>
                            <div>
                                <div class="text-sm text-gray-500">Email</div>
                                <a href="mailto:{{ data_get($i, 'email', '-') }}"
                                    class="font-medium text-accent hover:underline break-all">
                                    {{ data_get($i, 'email', '-') }}
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="rounded-2xl border bg-white p-4 shadow-sm">
                        <div class="flex items-start gap-3">
                            <svg class="w-5 h-5 text-accent mt-0.5" viewBox="0 0 24 24" fill="currentColor">
                                <path
                                    d="M12 7a1 1 0 011 1v3.3l2.4 1.4a1 1 0 11-1 1.7l-2.9-1.7A1 1 0 0111 12V8a1 1 0 011-1zm0-5a10 10 0 100 20 10 10 0 000-20z" />
                            </svg>
                            <div>
                                <div class="text-sm text-gray-500">Jam Layanan</div>
                                <div class="font-medium text-ink">{{ data_get($i, 'hours', '-') }}</div>
                            </div>
                        </div>
                    </div>

                   {{-- Kartu Instagram (perbaikan ikon) --}}
<div class="rounded-2xl border bg-white p-4 shadow-sm">
  <div class="flex items-start gap-3">
    {{-- IG icon --}}
    <svg class="w-5 h-5 text-accent mt-0.5" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
      <!-- bingkai kotak membulat -->
      <rect x="3" y="3" width="18" height="18" rx="5"></rect>
      <!-- lensa kamera -->
      <circle cx="12" cy="12" r="4.2" fill="white"></circle>
      <circle cx="12" cy="12" r="2.6"></circle>
      <!-- flash titik -->
      <circle cx="17.3" cy="6.7" r="1.3"></circle>
    </svg>

    <div>
      <div class="text-sm text-gray-500">Instagram</div>
      <a href="{{ data_get($i,'instagram','#') }}" target="_blank" rel="noopener"
         class="font-medium text-accent hover:underline">Kunjungi profil</a>
    </div>
  </div>
</div>

                </div>
            </div>

            {{-- ===== Form Kontak ===== --}}
            <div class="rounded-2xl border bg-white/80 backdrop-blur p-6 md:p-7 shadow-sm">
                {{-- Alert --}}
                @if (session('success'))
                    <div
                        class="mb-4 flex items-start gap-2 rounded-xl border border-green-200 bg-green-50 px-4 py-3 text-green-700">
                        <svg class="w-5 h-5 mt-0.5" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M9 16.2l-3.5-3.5L4 14.2l5 5 11-11-1.5-1.5z" />
                        </svg>
                        <div>{{ session('success') }}</div>
                    </div>
                @endif
                @if (session('error'))
                    <div
                        class="mb-4 flex items-start gap-2 rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-red-700">
                        <svg class="w-5 h-5 mt-0.5" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M11 7h2v6h-2zm0 8h2v2h-2z" />
                            <path d="M1 21h22L12 2 1 21z" />
                        </svg>
                        <div>{{ session('error') }}</div>
                    </div>
                @endif
                @if ($errors->any())
                    <div class="mb-4 rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-red-700">
                        <ul class="list-disc pl-5 space-y-1">
                            @foreach ($errors->all() as $err)
                                <li>{{ $err }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('kontak.store') }}" class="space-y-5" novalidate>
                    @csrf

                    <div class="grid md:grid-cols-2 gap-4">
                        <div>
                            <label for="name" class="block text-sm font-medium mb-1">Nama <span
                                    class="text-red-500">*</span></label>
                            <input id="name" type="text" name="name" value="{{ old('name') }}" required
                                autocomplete="name"
                                class="w-full rounded-xl border px-3 py-2.5 placeholder:text-gray-400
                     @error('name') border-red-400 ring-1 ring-red-300 @else border-gray-300 @enderror
                     focus:outline-none focus:ring-2 focus:ring-accent/60 focus:border-accent/60 transition" />
                            @error('name')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="email" class="block text-sm font-medium mb-1">Email <span
                                    class="text-red-500">*</span></label>
                            <input id="email" type="email" name="email" value="{{ old('email') }}" required
                                autocomplete="email"
                                class="w-full rounded-xl border px-3 py-2.5 placeholder:text-gray-400
                     @error('email') border-red-400 ring-1 ring-red-300 @else border-gray-300 @enderror
                     focus:outline-none focus:ring-2 focus:ring-accent/60 focus:border-accent/60 transition" />
                            @error('email')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="grid md:grid-cols-2 gap-4">
                        <div>
                            <label for="phone" class="block text-sm font-medium mb-1">Telepon/WA <span
                                    class="text-gray-400">(opsional)</span></label>
                            <input id="phone" type="text" name="phone" value="{{ old('phone') }}"
                                autocomplete="tel"
                                class="w-full rounded-xl border px-3 py-2.5 placeholder:text-gray-400
                     @error('phone') border-red-400 ring-1 ring-red-300 @else border-gray-300 @enderror
                     focus:outline-none focus:ring-2 focus:ring-accent/60 focus:border-accent/60 transition" />
                            @error('phone')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="subject" class="block text-sm font-medium mb-1">Subjek <span
                                    class="text-gray-400">(opsional)</span></label>
                            <input id="subject" type="text" name="subject" value="{{ old('subject') }}"
                                autocomplete="on"
                                class="w-full rounded-xl border px-3 py-2.5 placeholder:text-gray-400
                     @error('subject') border-red-400 ring-1 ring-red-300 @else border-gray-300 @enderror
                     focus:outline-none focus:ring-2 focus:ring-accent/60 focus:border-accent/60 transition" />
                            @error('subject')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div>
                        <label for="message" class="block text-sm font-medium mb-1">Pesan <span
                                class="text-red-500">*</span></label>
                        <textarea id="message" name="message" rows="5" required
                            class="w-full rounded-xl border px-3 py-2.5 placeholder:text-gray-400 min-h-[140px]
                   @error('message') border-red-400 ring-1 ring-red-300 @else border-gray-300 @enderror
                   focus:outline-none focus:ring-2 focus:ring-accent/60 focus:border-accent/60 transition">{{ old('message') }}</textarea>
                        @error('message')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Honeypot anti-bot --}}
                    <input type="text" name="website" value="" class="hidden" tabindex="-1"
                        autocomplete="off" aria-hidden="true">

                    <div class="flex flex-col sm:flex-row sm:items-center gap-3">
                        <button type="submit"
                            class="inline-flex items-center justify-center gap-2 w-full sm:w-auto px-6 py-3 rounded-xl bg-navy text-white hover:bg-accent transition
                   focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-accent/60">
                            Kirim Pesan
                            <svg class="w-4 h-4" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M4 12l16-8-6 16-2-6-8-2z" />
                            </svg>
                        </button>
                        <p class="text-xs text-gray-500">Kami membalas pada jam layanan yang tercantum.</p>
                    </div>
                </form>
            </div>
        </div>
    </section>
@endsection
