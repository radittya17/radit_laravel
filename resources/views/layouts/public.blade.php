<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="theme-color" content="#102a75">
    <title>NOK &middot; @yield('title')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <style>
        :root { --navy:#0b2468; --blue:#1769c2; --ink:#17243e; --canvas:#f4f7fb; }
        body { background-color:var(--canvas); background-image:linear-gradient(rgba(244,247,251,.8),rgba(244,247,251,.8)),url('{{ asset('images/nok-background.jpg') }}'); background-position:center; background-attachment:fixed; background-size:cover; color:var(--ink); font-family:Inter,ui-sans-serif,system-ui,-apple-system,"Segoe UI",sans-serif; }
        .public-nav { background:rgba(255,255,255,.9); backdrop-filter:blur(16px); box-shadow:0 .25rem 1.2rem rgba(20,45,86,.07); }
        .brand-link { background:transparent; border:0; border-radius:.85rem; display:inline-flex; padding:.2rem; transition:transform .24s ease,filter .24s ease; }
        .brand-link:hover { filter:drop-shadow(0 .35rem .55rem rgba(16,42,117,.2)); transform:translateY(-2px); }
        .brand-logo__image { display:block; width:108px; }
        .hero { background-image:radial-gradient(circle at 82% 15%,rgba(32,185,232,.2),transparent 20rem),linear-gradient(120deg,rgba(8,27,85,.9),rgba(22,67,147,.82)),url('{{ asset('images/nok-background.jpg') }}'); background-position:center; background-size:cover; color:#fff; overflow:hidden; position:relative; }
        .hero::after { border:1px solid rgba(255,255,255,.12); border-radius:50%; content:''; height:25rem; position:absolute; right:-8rem; top:-14rem; width:25rem; }
        .eyebrow { color:#54d2f0; font-size:.75rem; font-weight:800; letter-spacing:.12em; text-transform:uppercase; }
        .feature-card { background:#fff; border:1px solid #e3eaf3; border-radius:1.1rem; box-shadow:0 .8rem 2rem rgba(20,45,86,.07); height:100%; padding:1.6rem; transition:transform .3s ease,box-shadow .3s ease; }
        .feature-card:hover { box-shadow:0 1.2rem 2.5rem rgba(20,45,86,.12); transform:translateY(-5px); }
        .feature-icon { align-items:center; background:linear-gradient(145deg,#e5f3ff,#e5faff); border-radius:.85rem; color:var(--blue); display:inline-flex; font-size:1.25rem; height:2.9rem; justify-content:center; width:2.9rem; }
        .btn { border-radius:.75rem; font-weight:700; transition:transform .2s ease,box-shadow .2s ease; } .btn:hover { transform:translateY(-2px); }
        .btn-primary { background:linear-gradient(125deg,var(--navy),var(--blue),#2796d7); background-size:160%; border:0; }
        .fade-up { animation:fadeUp .65s cubic-bezier(.2,.8,.2,1) both; } @keyframes fadeUp { from { opacity:0; transform:translateY(18px); } to { opacity:1; transform:none; } }
        @media (prefers-reduced-motion:reduce) { *,*::before,*::after { animation-duration:.01ms!important; transition-duration:.01ms!important; } }
    </style>
</head>
<body>
    <nav class="navbar public-nav"><div class="container py-2"><a href="{{ route('about') }}" class="brand-link" aria-label="Tentang NOK"><x-brand-logo /></a><a class="btn btn-outline-primary" href="{{ auth()->check() ? (auth()->user()->isAdmin() ? route('admin.dashboard') : route('karyawan.dashboard')) : route('login') }}">{{ auth()->check() ? 'Dashboard' : 'Masuk' }}</a></div></nav>
    @yield('content')
    <footer class="py-4 text-center text-secondary small">&copy; {{ now()->year }} NOK &middot; Sistem Kehadiran Terpadu</footer>
</body>
</html>
