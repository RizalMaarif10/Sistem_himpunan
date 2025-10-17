<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>@yield('title','HIMATEKNO')</title>

<!-- Favicon -->
<link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}">
<link rel="shortcut icon" href="{{ asset('images/logo.png') }}">
<link rel="apple-touch-icon" href="{{ asset('images/logo.png') }}">
<meta name="theme-color" content="#123c73">

  <script src="https://cdn.tailwindcss.com"></script>
  <script>
    tailwind.config = {
      theme: {
        extend: {
          colors: {
            navy:  '#123c73',
            ink:   '#0a2a5e',
            accent:'#3b82f6',
            soft:  '#f5f8ff', // dipakai di bg-soft
          },
          boxShadow: {
            card: '0 6px 18px rgba(18,60,115,0.08)',
          }
        }
      }
    }
  </script>

  <style>
    :root{
      --navy:#123c73; --ink:#0a2a5e; --accent:#3b82f6; --soft:#f5f8ff;
      --radius:14px; --shadow:0 6px 18px rgba(18,60,115,.08);
    }

    /* ============ GLOBAL UI ============ */
    .ui-card{background:#fff;border:1px solid #e5e7eb;border-radius:var(--radius);box-shadow:var(--shadow);overflow:hidden}
    .ui-card.is-hover:hover{box-shadow:0 10px 28px rgba(18,60,115,.12);transform:translateY(-2px);transition:.15s}

    .ui-title{color:var(--navy);font-weight:600;line-height:1.25}
    .ui-title:hover{color:var(--accent)}

    .ui-meta{font-size:12px;color:#6b7280}

    .ui-badge{font-size:11px;padding:.25rem .5rem;border-radius:9999px;font-weight:600}
    .ui-badge--date{background:#fff;color:var(--navy);box-shadow:0 2px 8px rgba(2,8,23,.08)}

    .ui-chip{font-size:11px;padding:.25rem .5rem;border-radius:.5rem;background:rgba(59,130,246,.1);color:var(--accent);font-weight:600}

    .ui-btn{display:inline-flex;align-items:center;gap:.5rem;padding:.375rem .75rem;border-radius:.65rem;font-size:.875rem;transition:.15s}
    .ui-btn:focus-visible{outline:2px solid rgba(59,130,246,.5);outline-offset:2px}
    .ui-btn--primary{background:var(--accent);color:#fff}
    .ui-btn--primary:hover{background:#306fe0}
    .ui-btn--outline{border:1px solid rgba(59,130,246,.6);color:var(--accent)}
    .ui-btn--outline:hover{background:var(--accent);color:#fff}

    /* size variants */
    .ui-btn--xs{padding:.25rem .5rem;border-radius:.5rem;font-size:.8125rem} /* 13px */
    .ui-cta--xs{padding:.25rem .625rem;border-radius:9999px;font-size:.8125rem}
    .ui-icon-xs{width:.875rem;height:.875rem} /* 14px */

    /* util kecil */
    .section-wrap{max-width:72rem;margin-inline:auto;padding-inline:1rem}
    .card-narrow{max-width:300px}

    /* ============ RESPONSIVE FIXES ============ */
    /* 1) media (img/video/iframe) tidak pernah overflow */
    img, video, canvas, iframe{max-width:100%;height:auto;display:block}

    /* 2) clip underline/anim kecil di header supaya tak bikin scroll horizontal */
    #siteHeader{overflow-x:clip}

    /* 3) amankan tabel dalam konten panjang */
    article table{width:100%;border-collapse:collapse}
    article table td, article table th{padding:.5rem;border:1px solid #e5e7eb}
  </style>
</head>

<body class="bg-gray-50 text-gray-800 antialiased overflow-x-hidden">
  @include('partials.navbar')

  <main>
    @yield('content')
  </main>

  @include('partials.footer')
</body>
</html>
