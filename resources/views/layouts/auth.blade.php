<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="theme-color" content="#102a75">
    <title>@yield('title') &middot; Absensi NOK</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <style>
        :root { --nok-navy:#102a75; --nok-blue:#1674d1; --ink:#17243e; }
        * { box-sizing:border-box; }
        body { background:#0b2671; color:var(--ink); min-height:100vh; }
        .auth-shell { background-image:linear-gradient(135deg,rgba(9,25,78,.62),rgba(18,59,145,.56)),url('{{ asset('images/nok-background.jpg') }}'); background-position:center; background-attachment:fixed; background-size:cover; min-height:100vh; overflow:hidden; position:relative; }
        .auth-shell::before,.auth-shell::after { border:1px solid rgba(255,255,255,.12); border-radius:50%; content:''; height:28rem; pointer-events:none; position:absolute; width:28rem; }
        .auth-shell::before { right:-8rem; top:-15rem; } .auth-shell::after { bottom:-18rem; left:-10rem; }
        .auth-card { animation:cardIn .65s cubic-bezier(.2,.8,.2,1) both; backdrop-filter:blur(12px); border:1px solid rgba(255,255,255,.7); border-radius:1.5rem; box-shadow:0 1.5rem 4rem rgba(0,0,0,.25); max-width:470px; position:relative; z-index:1; }
        .auth-brand { align-items:center; display:inline-flex; flex-direction:column; margin-bottom:1.5rem; } .brand-logo { align-items:center; display:inline-flex; gap:.6rem; } .brand-logo__image { display:block; height:auto; width:112px; } .brand-logo__tagline { color:#5b6b84; font-size:.66rem; font-weight:800; letter-spacing:.14em; text-transform:uppercase; }
        .form-control,.form-select { border:1px solid #dce3ef; border-radius:.78rem; min-height:2.85rem; transition:border-color .2s ease,box-shadow .2s ease; } .form-control:focus,.form-select:focus { border-color:var(--nok-blue); box-shadow:0 0 0 .25rem rgba(22,116,209,.14); }
        .btn { border-radius:.78rem; font-weight:700; padding:.68rem 1rem; transition:transform .2s ease,box-shadow .2s ease; } .btn:hover { transform:translateY(-2px); } .btn-primary { background:linear-gradient(125deg,var(--nok-navy),var(--nok-blue),#258fd4); background-size:160%; border:0; box-shadow:0 .6rem 1rem rgba(16,42,117,.18); } .btn-primary:hover { background-position:100%; }
        a { color:var(--nok-blue); font-weight:650; text-decoration:none; } a:hover { color:var(--nok-navy); }
        .auth-footer { color:rgba(255,255,255,.72); font-size:.82rem; position:relative; z-index:1; }
        @keyframes cardIn { from { opacity:0; transform:translateY(20px) scale(.98); } to { opacity:1; transform:none; } }
        @media (prefers-reduced-motion:reduce) { *,*::before,*::after { animation-duration:.01ms!important; transition-duration:.01ms!important; } }
    </style>
</head>
<body>
    <div class="auth-shell d-flex align-items-center py-4 py-md-5">
        <main class="container"><div class="card auth-card mx-auto border-0"><div class="card-body p-4 p-md-5"><div class="text-center"><a href="{{ route('login') }}" class="text-decoration-none"><x-brand-logo class="auth-brand" tagline /></a></div>@yield('content')</div></div></main>
        <footer class="auth-footer position-absolute bottom-0 start-0 end-0 text-center pb-3">&copy; {{ now()->year }} NOK &middot; Sistem Kehadiran Terpadu</footer>
    </div>
</body>
</html>
