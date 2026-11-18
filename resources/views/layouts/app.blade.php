<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="theme-color" content="#102a75">
    <title>{{ config('app.name', 'Absensi NOK') }} &middot; @yield('title', 'Dashboard')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <style>
        :root { --nok-navy:#0b2468; --nok-blue:#1769c2; --nok-cyan:#20b9e8; --ink:#17243e; --muted:#68758a; --surface:#fff; --canvas:#f3f6fb; --border:#e3eaf3; --shadow:0 1rem 2.5rem rgba(20,45,86,.07); }
        [data-theme="dark"] { --ink:#e7eefb; --muted:#a9b7cc; --surface:#17243a; --canvas:#0e1728; --border:#2b3c57; --shadow:0 1rem 2.5rem rgba(0,0,0,.2); }
        * { box-sizing:border-box; }
        html { height:100%; overflow-x:hidden; scroll-behavior:smooth; }
        body { height:100%; min-height:100vh; overflow:hidden; overflow-x:hidden; color:var(--ink); background:var(--canvas); font-family:Inter,ui-sans-serif,system-ui,-apple-system,"Segoe UI",sans-serif; }
        .brand-link { display:inline-flex; align-items:center; border:0; border-radius:.85rem; padding:.25rem; transition:transform .2s ease,filter .2s ease; }
        .brand-link:hover { transform:translateY(-2px); filter:drop-shadow(0 .35rem .55rem rgba(0,0,0,.22)); }
        .brand-logo__image { display:block; width:112px; height:auto; }
        .avatar { align-items:center; background:linear-gradient(135deg,#21b7e7,#315bc2); border:2px solid rgba(255,255,255,.7); border-radius:50%; color:#fff; display:inline-flex; flex:0 0 auto; font-size:.75rem; font-weight:800; height:2.35rem; justify-content:center; overflow:hidden; position:relative; width:2.35rem; }
        .avatar img { height:100%; inset:0; object-fit:cover; position:absolute; width:100%; }
        .avatar [data-avatar-fallback] { align-items:center; display:flex; height:100%; justify-content:center; width:100%; }
        .avatar [hidden] { display:none!important; }
        .employee-profile-trigger { align-items:center; background:transparent; border:0; border-radius:.85rem; color:inherit; display:inline-flex; gap:.7rem; max-width:100%; padding:.2rem .35rem; text-align:left; transition:background .2s ease,transform .24s cubic-bezier(.22,1,.36,1); }
        .employee-profile-trigger:hover,.employee-profile-trigger:focus-visible { background:rgba(23,105,194,.09); color:var(--nok-blue); transform:translateX(2px); }
        .employee-profile-trigger > span:last-child { min-width:0; }
        .employee-profile-modal.fade .modal-dialog { opacity:0; transform:translateY(1rem) scale(.98); transition:opacity .22s ease,transform .32s cubic-bezier(.22,1,.36,1); }
        .employee-profile-modal.show .modal-dialog { opacity:1; transform:translateY(0) scale(1); }
        .employee-profile-summary { align-items:center; background:linear-gradient(135deg,rgba(23,105,194,.11),rgba(32,185,232,.07)); border:1px solid var(--border); border-radius:1rem; display:flex; gap:1rem; min-width:0; padding:1.1rem; }
        .employee-profile-avatar { border:3px solid var(--surface); box-shadow:0 0 0 2px rgba(32,185,232,.45); height:5rem; width:5rem; font-size:1.35rem; }
        .employee-profile-summary > div:last-child { min-width:0; }
        .employee-profile-details { display:grid; gap:0; }
        .employee-profile-details > div { align-items:flex-start; border-bottom:1px solid var(--border); display:flex; gap:1rem; justify-content:space-between; padding:.8rem .15rem; }
        .employee-profile-details > div:last-child { border-bottom:0; }
        .employee-profile-details span { color:var(--muted); flex:0 0 8rem; font-size:.87rem; }
        .employee-profile-details strong { color:var(--ink); font-size:.9rem; overflow-wrap:anywhere; text-align:right; }
        .card { background:var(--surface); border:1px solid var(--border); border-radius:1.15rem; box-shadow:var(--shadow); transition:box-shadow .22s ease,border-color .22s ease,transform .22s ease; }
        .card:hover { border-color:rgba(23,105,194,.2); box-shadow:0 1rem 2.5rem rgba(20,45,86,.1); }
        .card-body { color:var(--ink); }
        .text-muted { color:var(--muted)!important; }
        .table { --bs-table-bg:transparent; --bs-table-color:var(--ink); --bs-table-hover-bg:rgba(23,105,194,.045); --bs-table-border-color:var(--border); }
        .table thead th { color:var(--muted); font-size:.74rem; font-weight:800; letter-spacing:.06em; text-transform:uppercase; white-space:nowrap; }
        .table > :not(caption) > * > * { padding:.88rem .75rem; }
        .form-control,.form-select { background:var(--surface); border-color:var(--border); border-radius:.75rem; color:var(--ink); min-height:2.8rem; }
        .form-control:focus,.form-select:focus { background:var(--surface); border-color:var(--nok-blue); box-shadow:0 0 0 .25rem rgba(23,105,194,.13); color:var(--ink); }
        .btn { border-radius:.72rem; font-weight:700; transition:transform .18s ease,box-shadow .18s ease; }
        .btn:hover { transform:translateY(-1px); }
        .btn-primary { background:linear-gradient(120deg,var(--nok-navy),var(--nok-blue),#258fd4); background-size:160% 160%; border:0; box-shadow:0 .45rem .9rem rgba(16,42,117,.18); }
        .btn-primary:hover { background-position:100% 0; box-shadow:0 .6rem 1.2rem rgba(16,42,117,.24); }
        .modal { z-index:1090; }
        .modal-backdrop { z-index:1080; }
        .modal-content { background:var(--surface); border:1px solid var(--border); border-radius:1.1rem; box-shadow:0 1.5rem 4rem rgba(4,17,45,.26); color:var(--ink); }
        .modal-header,.modal-footer { border-color:var(--border); }
        [data-theme="dark"] .modal .btn-close { filter:invert(1) grayscale(100%) brightness(200%); }
        .badge { font-weight:750; letter-spacing:.01em; padding:.5em .72em; }
        .stat-number { font-size:2rem; font-weight:800; letter-spacing:-.055em; }
        .alert { border:1px solid rgba(255,255,255,.55); border-radius:1rem; box-shadow:var(--shadow); }
        .page-enter { animation:pageEnter .45s cubic-bezier(.2,.8,.2,1) both; }
        .reveal { animation:reveal .55s cubic-bezier(.2,.8,.2,1) both; }
        @keyframes pageEnter { from { opacity:0; transform:translateY(10px); } to { opacity:1; transform:none; } }
        @keyframes reveal { from { opacity:0; transform:translateY(14px); } to { opacity:1; transform:none; } }
        .app-shell { display:flex; height:100vh; min-height:0; overflow:hidden; }
        .app-sidebar { background:linear-gradient(165deg,#091d59,#103b8c 68%,#105895); box-shadow:.35rem 0 1.5rem rgba(12,29,70,.12); color:#dce8ff; display:flex; flex:0 0 17rem; flex-direction:column; height:100vh; min-height:0; overflow-x:hidden; overflow-y:auto; overscroll-behavior:contain; padding:1.1rem .85rem; position:sticky; scrollbar-color:rgba(220,232,255,.28) transparent; scrollbar-width:thin; top:0; transition:flex-basis .42s cubic-bezier(.22,1,.36,1),padding .42s cubic-bezier(.22,1,.36,1),transform .35s cubic-bezier(.22,1,.36,1); z-index:1045; }
        .sidebar-brand { margin:0 .35rem 1.65rem; min-height:3rem; white-space:nowrap; }
        .app-sidebar .brand-link { justify-content:flex-start; min-height:3rem; overflow:hidden; padding:.28rem .4rem; position:relative; width:100%; }
        .sidebar-brand-full { display:block; max-width:112px; opacity:1; overflow:hidden; transform:translateX(0) scale(1); transition:max-width .38s cubic-bezier(.22,1,.36,1),opacity .22s ease,transform .38s cubic-bezier(.22,1,.36,1); }
        .sidebar-brand-mark { align-items:center; background:transparent; border:0; border-radius:0; display:flex; height:auto; justify-content:center; left:50%; opacity:0; padding:0; position:absolute; top:50%; transform:translate(-50%,-50%) scale(.9); transition:opacity .2s ease,transform .38s cubic-bezier(.22,1,.36,1); width:3.9rem; }
        .sidebar-brand-mark .brand-logo__image { width:100%; }
        .sidebar-nav { display:grid; gap:.28rem; }
        .sidebar-label { color:rgba(220,232,255,.56); font-size:.67rem; font-weight:800; letter-spacing:.12em; margin:.15rem .7rem .55rem; max-height:1rem; overflow:hidden; text-transform:uppercase; transition:max-height .3s ease,margin .3s ease,opacity .2s ease; white-space:nowrap; }
        .sidebar-link { align-items:center; border-radius:.8rem; color:rgba(235,242,255,.78); display:flex; font-size:.91rem; font-weight:700; gap:.85rem; min-height:2.9rem; padding:.65rem .75rem; text-decoration:none; transition:background .24s ease,color .24s ease,box-shadow .3s ease,transform .3s cubic-bezier(.22,1,.36,1); white-space:nowrap; }
        .sidebar-link span { display:inline-block; max-width:13rem; opacity:1; overflow:hidden; transform:translateX(0); transition:max-width .38s cubic-bezier(.22,1,.36,1),opacity .2s ease,transform .38s cubic-bezier(.22,1,.36,1); }
        .sidebar-link i { flex:0 0 1.25rem; font-size:1.1rem; text-align:center; transition:transform .3s cubic-bezier(.22,1,.36,1); }
        .sidebar-link:hover,.sidebar-link.active { background:rgba(255,255,255,.14); color:#fff; transform:translateX(2px); }
        .sidebar-link:hover i { transform:scale(1.12); }
        .sidebar-link.active { box-shadow:inset .18rem 0 0 #35c5ed,0 .45rem 1rem rgba(0,0,0,.07); }
        .sidebar-bottom { border-top:1px solid rgba(255,255,255,.14); margin-top:auto; padding-top:1rem; }
        .sidebar-bottom .small { transition:opacity .2s ease,transform .3s ease; }
        .sidebar-edge-toggle { align-items:center; background:#fff; border:3px solid #e8f5ff; border-radius:50%; box-shadow:0 .4rem 1rem rgba(4,17,45,.24); color:var(--nok-navy); display:flex; height:2.55rem; justify-content:center; left:calc(17rem - .6rem); padding:0; position:fixed; top:50%; transform:translateY(-50%); transition:background .24s ease,box-shadow .3s ease,left .42s cubic-bezier(.22,1,.36,1),transform .3s cubic-bezier(.22,1,.36,1); width:2.55rem; z-index:1060; }
        .sidebar-edge-toggle:hover { background:#eaf7ff; box-shadow:0 .65rem 1.3rem rgba(4,17,45,.28); transform:translateY(-50%) scale(1.1); }
        .sidebar-edge-toggle:active { transform:translateY(-50%) scale(.94); }
        .sidebar-edge-toggle i { font-size:1.45rem; line-height:1; transition:transform .42s cubic-bezier(.22,1,.36,1); }
        body.sidebar-collapsed .sidebar-edge-toggle i { transform:rotate(180deg); }
        body.sidebar-collapsed .sidebar-edge-toggle { left:calc(5.25rem - .6rem); }
        .admin-workspace { display:flex; flex-direction:column; height:100vh; min-height:0; min-width:0; overflow:hidden; width:100%; }
        .app-topbar { align-items:center; background:color-mix(in srgb,var(--surface) 92%,transparent); backdrop-filter:blur(14px); border-bottom:1px solid var(--border); display:flex; justify-content:space-between; min-height:4.65rem; padding:0 2rem; position:sticky; top:0; z-index:1030; }
        .topbar-date { align-items:center; color:var(--ink); display:flex; gap:.75rem; }
        .topbar-date-icon { align-items:center; background:rgba(23,105,194,.1); border-radius:.75rem; color:var(--nok-blue); display:flex; height:2.45rem; justify-content:center; width:2.45rem; }
        .sidebar-toggle,.mobile-sidebar-toggle { border:1px solid var(--border); color:var(--nok-navy); }
        .mobile-sidebar-toggle { align-items:center; display:inline-flex; justify-content:center; }
        .admin-main { flex:1; min-height:0; overflow-x:hidden; overflow-y:auto; overscroll-behavior:contain; padding:1.75rem 2rem; scrollbar-color:rgba(23,105,194,.3) transparent; scrollbar-width:thin; scroll-behavior:smooth; }
        .admin-main [id] { scroll-margin-top:1rem; }
        .admin-footer { flex:0 0 auto; padding:1.1rem 2rem; }
        .sidebar-overlay { background:rgba(4,14,42,.5); inset:0; opacity:0; pointer-events:none; position:fixed; transition:opacity .25s ease; z-index:1040; }
        body.sidebar-collapsed .app-sidebar { flex-basis:5.25rem; padding-left:.62rem; padding-right:.62rem; }
        body.sidebar-collapsed .sidebar-brand { margin-left:0; margin-right:0; }
        body.sidebar-collapsed .app-sidebar .brand-link { justify-content:center; padding-left:0; padding-right:0; }
        body.sidebar-collapsed .sidebar-brand-full { max-width:0; opacity:0; transform:translateX(-.4rem) scale(.9); }
        body.sidebar-collapsed .sidebar-brand-mark { opacity:1; transform:translate(-50%,-50%) scale(1); }
        body.sidebar-collapsed .sidebar-label { max-height:0; margin-bottom:0; margin-top:0; opacity:0; overflow:hidden; }
        body.sidebar-collapsed .sidebar-link span { max-width:0; opacity:0; transform:translateX(-.4rem); }
        body.sidebar-collapsed .sidebar-bottom .small { opacity:0; transform:translateY(.3rem); }
        body.sidebar-collapsed .sidebar-link { gap:0; justify-content:center; padding-left:.4rem; padding-right:.4rem; }
        body.sidebar-collapsed .sidebar-link.active { box-shadow:inset 0 -.18rem 0 #35c5ed; }
        .profile-dropdown { position:relative; }
        .profile-dropdown .dropdown-toggle { align-items:center; appearance:none; background:rgba(23,105,194,.06); border:1px solid var(--border); border-radius:.85rem; color:var(--ink); display:flex; font:inherit; gap:.6rem; padding:.32rem .48rem; transition:background .2s ease,border-color .2s ease,box-shadow .2s ease; }
        .profile-dropdown .dropdown-toggle:hover,.profile-dropdown.show .dropdown-toggle { background:rgba(23,105,194,.1); border-color:rgba(23,105,194,.18); }
        .profile-dropdown .dropdown-toggle .avatar { height:2.55rem; width:2.55rem; }
        .profile-dropdown .dropdown-toggle::after { display:none; }
        .profile-dropdown .dropdown-menu { --bs-dropdown-bg:var(--surface); --bs-dropdown-border-color:var(--border); --bs-dropdown-color:var(--ink); background:var(--surface); border:1px solid var(--border); border-radius:1rem; box-shadow:0 1rem 2.4rem rgba(12,29,70,.18); display:block; left:auto!important; max-width:calc(100vw - 1.5rem); min-width:min(17rem,calc(100vw - 1.5rem)); opacity:0; overflow:hidden; padding:.5rem; pointer-events:none; right:0!important; scale:.98; translate:0 -.4rem; transition:opacity .18s ease,scale .22s cubic-bezier(.22,1,.36,1),translate .22s cubic-bezier(.22,1,.36,1),visibility 0s linear .2s; transform-origin:top right; visibility:hidden; width:min(18rem,calc(100vw - 1.5rem)); z-index:1050; }
        .profile-dropdown .dropdown-menu.show { opacity:1; pointer-events:auto; scale:1; translate:0 0; transition-delay:0s; visibility:visible; }
        .profile-dropdown .dropdown-item { align-items:center; border-radius:.7rem; color:var(--ink); display:flex; font-size:.92rem; font-weight:700; gap:.25rem; padding:.7rem .8rem; }
        .profile-dropdown .dropdown-item:hover,.profile-dropdown .dropdown-item:focus { background:rgba(23,105,194,.1); color:var(--nok-navy); }
        .profile-dropdown .dropdown-divider { border-color:var(--border); }
        .profile-card { min-width:0; padding:.75rem .8rem .9rem; }
        .profile-card > .text-truncate { flex:1 1 0%; min-width:0; }
        .page-heading { align-items:flex-end; background:radial-gradient(ellipse at 88% 0,rgba(32,185,232,.13),transparent 24rem),linear-gradient(115deg,rgba(23,105,194,.065),transparent); border:1px solid var(--border); border-radius:1.2rem; display:flex; justify-content:space-between; margin-bottom:1.35rem; padding:1.4rem 1.55rem; }
        .page-heading h1 { letter-spacing:-.04em; }
        .page-eyebrow { color:var(--nok-blue); font-size:.72rem; font-weight:850; letter-spacing:.13em; text-transform:uppercase; }
        .stat-card { overflow:hidden; position:relative; }
        .stat-card::after { background:linear-gradient(135deg,rgba(32,185,232,.13),rgba(23,105,194,.035)); border-radius:50%; content:''; height:7rem; position:absolute; right:-3rem; top:-3.8rem; transition:transform .35s ease; width:7rem; }
        .stat-card:hover::after { transform:scale(1.15); }
        .app-footer { border-top:1px solid var(--border); color:var(--muted); font-size:.82rem; }
        @media (max-width:991.98px) {
            .app-sidebar { box-shadow:.8rem 0 2rem rgba(0,0,0,.22); height:100vh; left:0; position:fixed; transform:translateX(-100%); width:17rem; }
            body.sidebar-open .app-sidebar { transform:none; }
            body.sidebar-open .sidebar-overlay { opacity:1; pointer-events:auto; }
            .sidebar-edge-toggle { display:none; }
            body.sidebar-collapsed .app-sidebar { flex-basis:17rem; padding-left:.85rem; padding-right:.85rem; }
            body.sidebar-collapsed .sidebar-label { max-height:1rem; margin:.15rem .7rem .55rem; opacity:1; }
            body.sidebar-collapsed .sidebar-link span { max-width:13rem; opacity:1; transform:none; }
            body.sidebar-collapsed .sidebar-bottom .small { opacity:1; transform:none; }
            body.sidebar-collapsed .sidebar-link { justify-content:flex-start; padding-left:.75rem; padding-right:.75rem; }
            .app-topbar,.admin-main { padding-left:1rem; padding-right:1rem; }
            .admin-footer { padding-left:1rem; padding-right:1rem; }
            .page-heading { align-items:flex-start; flex-direction:column; gap:1rem; }
        }
        @media (max-width:575.98px) { .topbar-date-icon { display:none; } .topbar-date { gap:0; } .topbar-date-copy { display:block; } .topbar-date-copy > span { font-size:.7rem!important; white-space:nowrap; } .topbar-date-copy > small { display:none; } .page-heading { padding:1.2rem; } .admin-main { padding-top:1.2rem; } }
        @supports (height:100dvh) { .app-shell,.app-sidebar,.admin-workspace { height:100dvh; } }
        @media (prefers-reduced-motion:reduce) { *,*::before,*::after { animation-duration:.01ms!important; scroll-behavior:auto!important; transition-duration:.01ms!important; } }
    </style>
    @stack('styles')
</head>
<body>
@php($isAdmin = auth()->user()->isAdmin())
<div class="app-shell">
    <div class="sidebar-overlay" data-sidebar-close></div>
    <aside class="app-sidebar" id="appSidebar" aria-label="Navigasi utama">
        <div class="sidebar-brand"><a class="brand-link" href="{{ $isAdmin ? route('admin.dashboard') : route('karyawan.dashboard') }}" aria-label="Dashboard Absensi NOK"><span class="sidebar-brand-full"><x-brand-logo /></span><span class="sidebar-brand-mark" aria-hidden="true"><x-brand-logo /></span></a></div>
        <nav class="sidebar-nav">
            <span class="sidebar-label">Menu utama</span>
            @if ($isAdmin)
                <a class="sidebar-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" href="{{ route('admin.dashboard') }}" title="Dashboard"><i class="bi bi-grid-1x2-fill"></i><span>Dashboard</span></a>
                <a class="sidebar-link {{ request()->routeIs('admin.employees.*') ? 'active' : '' }}" href="{{ route('admin.employees.index') }}" title="Karyawan"><i class="bi bi-people-fill"></i><span>Karyawan</span></a>
                <a class="sidebar-link {{ request()->routeIs('admin.reports.*') ? 'active' : '' }}" href="{{ route('admin.reports.index') }}" title="Laporan"><i class="bi bi-bar-chart-line-fill"></i><span>Laporan</span></a>
            @else
                <a class="sidebar-link {{ request()->routeIs('karyawan.dashboard') ? 'active' : '' }}" href="{{ route('karyawan.dashboard') }}" title="Dashboard"><i class="bi bi-grid-1x2-fill"></i><span>Dashboard</span></a>
                <a class="sidebar-link" href="{{ route('karyawan.dashboard') }}#absensi-hari-ini" title="Absensi masuk"><i class="bi bi-box-arrow-in-right"></i><span>Absensi masuk</span></a>
                <a class="sidebar-link" href="{{ route('karyawan.dashboard') }}#ajukan-izin" title="Ajukan izin atau cuti"><i class="bi bi-send-plus"></i><span>Ajukan izin / cuti</span></a>
                <a class="sidebar-link" href="{{ route('karyawan.dashboard') }}#riwayat-absensi" title="Riwayat absensi"><i class="bi bi-clock-history"></i><span>Riwayat absensi</span></a>
            @endif
        </nav>
        <div class="sidebar-bottom">
            <a class="sidebar-link {{ request()->routeIs('profile.*') ? 'active' : '' }}" href="{{ route('profile.edit') }}" title="Profil saya"><i class="bi bi-person-gear"></i><span>Profil saya</span></a>
            <p class="small mb-0 mt-3 px-2 text-white-50">Sistem Kehadiran Terpadu</p>
        </div>
    </aside>
    <div class="admin-workspace">
        <header class="app-topbar">
            <div class="d-flex align-items-center gap-3">
                <button class="btn mobile-sidebar-toggle d-lg-none" type="button" data-sidebar-toggle aria-controls="appSidebar" aria-label="Buka sidebar"><i class="bi bi-list fs-5"></i></button>
                <div class="topbar-date"><span class="topbar-date-icon"><i class="bi bi-buildings"></i></span><div class="topbar-date-copy"><span class="small fw-bold d-block">PT.NOK Indonesia</span><small class="text-muted">Waktu saat ini <span data-live-clock>--:--:--</span></small></div></div>
            </div>
            @include('layouts.partials.profile-menu')
        </header>
        <main class="admin-main page-enter">
            @include('layouts.partials.flash')
            @yield('content')
        </main>
        <footer class="app-footer admin-footer d-flex flex-wrap justify-content-between gap-2"><span>&copy; {{ now()->year }} NOK &middot; Sistem Kehadiran Terpadu</span><span>Aman dan terkelola</span></footer>
    </div>
</div>
<button class="sidebar-edge-toggle d-none d-lg-flex" type="button" data-sidebar-toggle aria-controls="appSidebar" aria-label="Ciutkan sidebar" title="Ciutkan sidebar"><i class="bi bi-arrow-left-short"></i></button>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
(() => {
    document.querySelectorAll('.modal').forEach(modal => document.body.append(modal));

    const root = document.documentElement;
    const themeToggles = document.querySelectorAll('[data-theme-toggle]');
    const setTheme = theme => {
        root.dataset.theme = theme;
        localStorage.setItem('nok-theme', theme);
        themeToggles.forEach(toggle => {
            toggle.innerHTML = `<i class="bi bi-${theme === 'dark' ? 'sun-fill' : 'moon-stars-fill'} me-2"></i>${theme === 'dark' ? 'Tema terang' : 'Tema gelap'}`;
        });
    };
    setTheme(localStorage.getItem('nok-theme') || (matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light'));
    themeToggles.forEach(toggle => toggle.addEventListener('click', () => setTheme(root.dataset.theme === 'dark' ? 'light' : 'dark')));

    const body = document.body;
    const sidebarToggles = document.querySelectorAll('[data-sidebar-toggle]');
    const desktopQuery = matchMedia('(min-width: 992px)');
    const sidebarStateKey = 'nok-sidebar-expanded-v2';
    const setSidebar = expanded => {
        if (desktopQuery.matches) {
            body.classList.remove('sidebar-open');
            body.classList.toggle('sidebar-collapsed', !expanded);
            localStorage.setItem(sidebarStateKey, expanded ? '1' : '0');
            sidebarToggles.forEach(toggle => {
                toggle.setAttribute('aria-label', expanded ? 'Ciutkan sidebar' : 'Lebarkan sidebar');
                toggle.setAttribute('title', expanded ? 'Ciutkan sidebar' : 'Lebarkan sidebar');
            });
        } else {
            body.classList.remove('sidebar-collapsed');
            body.classList.toggle('sidebar-open', expanded);
            sidebarToggles.forEach(toggle => toggle.setAttribute('aria-label', expanded ? 'Tutup sidebar' : 'Buka sidebar'));
        }
    };
    if (sidebarToggles.length && desktopQuery.matches) setSidebar(localStorage.getItem(sidebarStateKey) !== '0');
    sidebarToggles.forEach(toggle => toggle.addEventListener('click', () => setSidebar(desktopQuery.matches ? body.classList.contains('sidebar-collapsed') : !body.classList.contains('sidebar-open'))));
    document.querySelectorAll('[data-sidebar-close], .app-sidebar .sidebar-link').forEach(item => item.addEventListener('click', () => { if (!desktopQuery.matches) setSidebar(false); }));
    desktopQuery.addEventListener('change', event => setSidebar(event.matches ? localStorage.getItem(sidebarStateKey) !== '0' : false));
    addEventListener('keydown', event => { if (event.key === 'Escape' && !desktopQuery.matches) setSidebar(false); });

    const updateClock = () => {
        const time = new Intl.DateTimeFormat('id-ID', { timeZone: 'Asia/Jakarta', hour: '2-digit', minute: '2-digit', second: '2-digit' }).format(new Date());
        document.querySelectorAll('[data-live-clock]').forEach(clock => { clock.textContent = time; });
    };
    updateClock();
    setInterval(updateClock, 1000);

    document.querySelectorAll('[data-confirm]').forEach(form => form.addEventListener('submit', event => {
        if (!confirm(form.dataset.confirm)) event.preventDefault();
    }));
})();
</script>
@stack('scripts')
</body>
</html>
