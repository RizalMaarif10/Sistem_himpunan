<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>@yield('title','Panel Bendahara')</title>

  {{-- Tailwind CDN --}}
  <script src="https://cdn.tailwindcss.com"></script>

  {{-- utilitas ringan --}}
  <style>
    .bg-soft { background:#f8fafc }
  </style>

  @stack('head')
</head>
<body class="min-h-screen bg-gray-50 text-slate-800">
  @include('bendahara.partials.nav')

  <main class="max-w-7xl mx-auto px-4 py-8">
    @yield('content')
  </main>

  @include('bendahara.partials.footer')
  @stack('scripts')
</body>
</html>
