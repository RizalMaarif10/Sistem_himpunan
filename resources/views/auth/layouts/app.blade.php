<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>@yield('title','Masuk - HIMATEKNO')</title>

  <script src="https://cdn.tailwindcss.com"></script>
  <script>
    tailwind.config = {
      theme: { extend: { fontFamily: { sans: ['Inter','ui-sans-serif','system-ui','Segoe UI','Roboto','Arial'] } } }
    }
  </script>

  <style>
    :root{
      --admin:#0f172a; --accent:#2563eb;
      --surface:#fff; --border:#e5e7eb; --radius:16px;
    }
    .bg-mesh{
      background:
        radial-gradient(60rem 30rem at -10% -10%, #dbeafe55 8%, transparent 60%),
        radial-gradient(40rem 25rem at 110% -10%, #e0e7ff55 8%, transparent 60%),
        radial-gradient(30rem 22rem at 50% 120%, #fef3c755 8%, transparent 60%),
        linear-gradient(#f8fafc, #ffffff);
    }
    .auth-card{
      background:var(--surface); border:1px solid var(--border); border-radius:var(--radius);
      box-shadow:0 2px 12px rgba(2,6,23,.06);
    }
    .btn{
      display:inline-flex; align-items:center; justify-content:center; gap:.5rem;
      padding:.625rem 1rem; border-radius:12px; font-weight:600; transition:.15s;
    }
    .btn-primary{ background:var(--admin); color:#fff; }
    .btn-primary:hover{ filter:brightness(1.07); }
    .input{
      width:100%; height:44px; border:1px solid var(--border); border-radius:12px;
      padding:.625rem .875rem; background:#fff; outline:0; transition:.15s;
    }
    .field { position:relative; }
.field .icon{
  position:absolute; left:12px; top:70%;
  transform:translateY(-50%);
  width:16px; height:16px; color:#64748b;
  pointer-events:none;
}
.field .input{ padding-left:2.5rem; }
.field .trailing{
  position:absolute; right:12px; top:70%;
  transform:translateY(-50%);
  width:18px; height:18px; color:#64748b;
}

    }
  </style>
  @stack('head')
</head>
<body class="min-h-screen bg-mesh">
  <div class="min-h-screen flex items-center justify-center px-4 py-10">
    @yield('content')
  </div>
  @stack('scripts')
</body>
</html>
