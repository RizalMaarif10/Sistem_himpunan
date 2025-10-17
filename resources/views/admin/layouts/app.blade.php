<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>@yield('title', 'Panel Pengurus - HIMATEKNO')</title>

  {{-- Tailwind via CDN (tanpa Vite) --}}
  <script src="https://cdn.tailwindcss.com"></script>

  {{-- Konfigurasi ringan untuk font/spacing jika perlu --}}
  <script>
    tailwind.config = {
      theme: {
        extend: {
          fontFamily: {
            sans: ['Inter', 'ui-sans-serif', 'system-ui', 'Segoe UI', 'Roboto', 'Helvetica Neue', 'Arial', 'Noto Sans', 'Apple Color Emoji', 'Segoe UI Emoji']
          }
        }
      }
    }
  </script>

  {{-- Utilitas kecil khusus admin + komponen dasar --}}
  <style>
    :root {
      --admin:#0f172a;   /* navy gelap */
      --accent:#2563eb;  /* biru aksen */
    }
    .bg-admin{ background:var(--admin); }
    .text-admin{ color:var(--admin); }
    .text-accent{ color:var(--accent); }
    .bg-soft{ background:#f8fafc; }

    /* Komponen tombol (tanpa @apply agar aman di CDN) */
    .btn {
      display:inline-flex; align-items:center; gap:.5rem;
      border-radius:.75rem; padding:.5rem .875rem;
      font-weight:600; font-size:.875rem; line-height:1.25rem;
      transition:all .15s ease;
    }
    /* ukuran tombol kecil */
.btn-sm{ padding:.375rem .625rem; font-size:.75rem; border-radius:.5rem; }

    .btn-primary{ background:var(--admin); color:#fff; }
    .btn-primary:hover{ filter:brightness(1.1); }
    .btn-accent{ background:var(--accent); color:#fff; }
    .btn-accent:hover{ filter:brightness(1.1); }
    .btn-outline{
      background:#fff; color:var(--admin);
      border:1px solid #e2e8f0;
    }
    .btn-outline:hover{ background:#f8fafc; }

    /* Badge status */
    .badge{ display:inline-flex; align-items:center; gap:.375rem;
      padding:.25rem .5rem; border-radius:999px; font-size:.75rem; font-weight:600;
      border:1px solid transparent;
    }
    .badge-gray{ background:#f1f5f9; color:#475569; border-color:#e2e8f0; }
    .badge-green{ background:#ecfdf5; color:#047857; border-color:#a7f3d0; }
    .badge-blue{ background:#eff6ff; color:#1d4ed8; border-color:#bfdbfe; }
    .badge-amber{ background:#fffbeb; color:#b45309; border-color:#fde68a; }

    /* Clamp 2 baris (fallback plugin) */
    .line-clamp-2{
      display:-webkit-box; -webkit-line-clamp:2; -webkit-box-orient:vertical; overflow:hidden;
    }

    /* Kartu default */
    .card{ background:#fff; border:1px solid #e5e7eb; border-radius:1rem; }
    <style>
  .ar{ position:relative; overflow:hidden; }
  .ar::before{ content:""; display:block; padding-bottom:125%; } /* 4:5 = 1 / 0.8 = 125% */
  .ar > img{ position:absolute; inset:0; width:100%; height:100%; object-fit:cover; object-position:center; }
</style>

  </style>

  @stack('head')
</head>
<body class="min-h-screen bg-gray-50 text-slate-800">
  {{-- Navbar bawaan proyek --}}
  @include('admin.partials.nav')

  <main class="max-w-7xl mx-auto px-4 py-8">
    @yield('content')
  </main>

  @include('admin.partials.footer')

  @stack('scripts')
</body>
</html>
