<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>@yield('title', setting('sekolah_nama', 'SIAKAD SMK')) — @yield('page_title', 'Website Resmi')</title>
  <meta name="description" content="@yield('meta_desc', setting('sekolah_tagline', ''))">
  <meta name="theme-color" content="#0b223d">

  {{-- Open Graph --}}
  <meta property="og:type"        content="website">
  <meta property="og:url"         content="{{ url()->current() }}">
  <meta property="og:title"       content="@yield('title', setting('sekolah_nama'))">
  <meta property="og:description" content="@yield('meta_desc', setting('sekolah_tagline', ''))">
  @if(setting_url('logo'))
  <meta property="og:image"       content="{{ setting_url('logo') }}">
  @endif
  <meta property="og:site_name"   content="{{ setting('sekolah_nama') }}">
  <link rel="canonical"           href="{{ url()->current() }}">
  @if(setting_url('favicon'))
  <link rel="icon" href="{{ setting_url('favicon') }}">
  @endif

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">

  <script>document.documentElement.classList.add('js')</script>

  <style>
    :root {
      /* ── 3D Theme & Brand Tokens ── */
      --brand-dark: #071526;
      --brand-navy: #0b223d;
      --brand-blue: #1b5d8f;
      --brand-cyan: #06b6d4;
      --brand-gold: #f59e0b;
      --brand-emerald: #10b981;

      --primary: #0b3a5e;
      --primary-light: #1b5d8f;
      --primary-soft: #e8f0f7;
      --accent: #f59e0b;
      --accent-dark: #d97706;
      --accent-soft: #fef3c7;
      --ink: #0f172a;
      --text-dark: #1e293b;
      --text-muted: #64748b;
      --line: #e2e8f0;
      --bg-light: #f6f8fb;
      --bg-gray: #eef2f6;
      --radius: 22px;
      --radius-sm: 14px;
      --shadow-sm: 0 1px 2px rgba(15, 23, 42, .06), 0 1px 3px rgba(15, 23, 42, .04);
      --shadow: 0 15px 35px -12px rgba(15, 23, 42, .18);
      --shadow-3d: 0 20px 45px -15px rgba(11, 34, 61, 0.16), 0 0 1px 1px rgba(255, 255, 255, 0.6) inset;
      --shadow-3d-hover: 0 30px 65px -15px rgba(11, 34, 61, 0.26), 0 0 1px 1px rgba(255, 255, 255, 0.8) inset;
      --nav-h: 76px;

      --bs-body-font-family: 'Plus Jakarta Sans', system-ui, -apple-system, 'Segoe UI', sans-serif;
      --bs-body-color: var(--text-dark);
      --bs-link-color-rgb: 27, 93, 143;
      --bs-link-hover-color-rgb: 11, 58, 94;
    }

    html { scroll-behavior: smooth; scroll-padding-top: calc(var(--nav-h) + 16px); }
    @media (prefers-reduced-motion: reduce) { html { scroll-behavior: auto; } }

    body {
      background: #ffffff;
      color: var(--text-dark);
      -webkit-font-smoothing: antialiased;
      text-rendering: optimizeLegibility;
      overflow-x: hidden;
    }
    h1, h2, h3, h4, h5, h6 { letter-spacing: -.025em; }
    ::selection { background: var(--accent-soft); color: var(--ink); }
    :focus-visible { outline: 3px solid rgba(6, 182, 212, .6); outline-offset: 2px; border-radius: 8px; }

    /* ── 3D Button Styles ── */
    .btn { font-weight: 700; border-radius: 999px; transition: all .25s cubic-bezier(0.16, 1, 0.3, 1); }
    .btn-3d-primary {
      display: inline-flex; align-items: center; gap: .6rem;
      padding: .85rem 1.8rem; font-size: .98rem; font-weight: 700; border-radius: 999px;
      background: linear-gradient(135deg, var(--brand-navy) 0%, var(--brand-blue) 100%);
      color: #fff !important; border: none; text-decoration: none;
      box-shadow: 0 10px 25px -6px rgba(11, 34, 61, 0.4), 0 0 0 1px rgba(255, 255, 255, 0.25) inset;
      transform-style: preserve-3d;
    }
    .btn-3d-primary:hover {
      transform: translateY(-3px) scale(1.02);
      box-shadow: 0 16px 32px -8px rgba(11, 34, 61, 0.55), 0 0 20px rgba(6, 182, 212, 0.35);
      color: #fff !important;
    }
    .btn-3d-accent {
      display: inline-flex; align-items: center; gap: .6rem;
      padding: .85rem 1.8rem; font-size: .98rem; font-weight: 700; border-radius: 999px;
      background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
      color: #071526 !important; border: none; text-decoration: none;
      box-shadow: 0 10px 25px -6px rgba(245, 158, 11, 0.45);
    }
    .btn-3d-accent:hover {
      transform: translateY(-3px) scale(1.02);
      box-shadow: 0 16px 32px -8px rgba(245, 158, 11, 0.6), 0 0 20px rgba(245, 158, 11, 0.4);
      color: #071526 !important;
    }
    .btn-3d-glass {
      display: inline-flex; align-items: center; gap: .6rem;
      padding: .8rem 1.6rem; font-size: .95rem; font-weight: 700; border-radius: 999px;
      background: rgba(255, 255, 255, 0.85); backdrop-filter: blur(12px);
      color: var(--brand-dark) !important; border: 1px solid rgba(203, 213, 225, 0.9);
      box-shadow: 0 6px 18px rgba(15, 23, 42, 0.05); text-decoration: none;
    }
    .btn-3d-glass:hover {
      background: #fff; border-color: var(--brand-blue); color: var(--brand-blue) !important;
      transform: translateY(-3px); box-shadow: 0 12px 26px rgba(15, 23, 42, 0.1);
    }

    /* ── Global 3D Interactive Cards ── */
    .card-3d {
      position: relative;
      background: #ffffff;
      border-radius: var(--radius);
      border: 1px solid rgba(226, 232, 240, 0.9);
      box-shadow: var(--shadow-3d);
      transition: transform 0.2s cubic-bezier(0.2, 0, 0.2, 1), box-shadow 0.3s ease, border-color 0.3s ease;
      transform-style: preserve-3d;
      overflow: hidden;
      will-change: transform;
    }
    .card-3d:hover {
      box-shadow: var(--shadow-3d-hover);
      border-color: rgba(6, 182, 212, 0.5);
    }
    .card-3d-glare {
      position: absolute; inset: 0;
      background: radial-gradient(circle at 50% 50%, rgba(255, 255, 255, 0.4) 0%, transparent 60%);
      opacity: 0; pointer-events: none; transition: opacity 0.3s ease; mix-blend-mode: overlay;
    }
    .card-3d:hover .card-3d-glare { opacity: 1; }

    /* ── 3D Subpage Hero Header ── */
    .subpage-hero-3d {
      position: relative;
      background: linear-gradient(135deg, #071526 0%, #0b223d 50%, #1b5d8f 100%);
      padding: clamp(100px, 14vw, 135px) 0 clamp(50px, 8vw, 75px);
      color: #ffffff;
      overflow: hidden;
    }
    .subpage-hero-3d::before {
      content: ''; position: absolute; inset: 0; pointer-events: none;
      background-image: 
        linear-gradient(to right, rgba(255, 255, 255, 0.06) 1px, transparent 1px),
        linear-gradient(to bottom, rgba(255, 255, 255, 0.06) 1px, transparent 1px);
      background-size: 32px 32px;
      mask-image: radial-gradient(ellipse at 50% 30%, #000 30%, transparent 80%);
      -webkit-mask-image: radial-gradient(ellipse at 50% 30%, #000 30%, transparent 80%);
    }
    .subpage-hero-glow {
      position: absolute; border-radius: 50%; pointer-events: none; filter: blur(75px); opacity: 0.5;
    }
    .subpage-hero-glow-1 {
      width: 420px; height: 420px;
      background: radial-gradient(circle, rgba(6, 182, 212, 0.4) 0%, transparent 70%);
      top: -120px; right: -80px;
    }
    .subpage-hero-glow-2 {
      width: 380px; height: 380px;
      background: radial-gradient(circle, rgba(245, 158, 11, 0.3) 0%, transparent 70%);
      bottom: -100px; left: -60px;
    }
    .subpage-breadcrumb-pill {
      display: inline-flex; align-items: center; gap: .6rem;
      padding: .35rem 1rem; border-radius: 999px;
      background: rgba(255, 255, 255, 0.12); backdrop-filter: blur(10px);
      border: 1px solid rgba(255, 255, 255, 0.2); font-size: .84rem; font-weight: 600;
      color: rgba(255, 255, 255, 0.85); text-decoration: none; margin-bottom: 1rem;
    }
    .subpage-breadcrumb-pill a { color: #fff; text-decoration: none; }
    .subpage-breadcrumb-pill a:hover { color: var(--brand-cyan); }
    .subpage-title-3d {
      font-size: clamp(2rem, 4.5vw, 3.4rem); font-weight: 850; letter-spacing: -.035em;
      line-height: 1.15; margin-bottom: .6rem; color: #fff;
    }
    .subpage-desc-3d {
      font-size: clamp(1rem, 1.6vw, 1.15rem); color: rgba(255, 255, 255, 0.78); max-width: 620px; line-height: 1.7;
    }

    /* ── Navbar ── */
    .site-nav {
      position: sticky; top: 0; z-index: 1030;
      background: rgba(255, 255, 255, 0.88);
      backdrop-filter: saturate(180%) blur(16px);
      -webkit-backdrop-filter: saturate(180%) blur(16px);
      border-bottom: 1px solid rgba(226, 232, 240, 0.7);
      transition: all .25s ease;
    }
    .site-nav.scrolled {
      background: rgba(255, 255, 255, 0.96);
      border-bottom-color: var(--line);
      box-shadow: 0 10px 30px -15px rgba(15, 23, 42, 0.15);
    }
    .site-nav .navbar { min-height: var(--nav-h); padding: .5rem 0; }
    .brand { display: flex; align-items: center; gap: .85rem; text-decoration: none; min-width: 0; }
    .brand-mark {
      width: 44px; height: 44px; border-radius: 14px; flex-shrink: 0;
      display: grid; place-items: center;
      background: linear-gradient(135deg, var(--brand-navy), var(--brand-blue)); color: #fff;
      box-shadow: 0 4px 12px rgba(11, 34, 61, 0.25);
    }
    .brand img { height: 44px; width: auto; }
    .min-w-0 { min-width: 0; }
    .brand-name { font-weight: 850; color: var(--brand-dark); font-size: 1.05rem; line-height: 1.2; letter-spacing: -.02em; }
    .brand-sub { display: block; font-size: .75rem; font-weight: 600; color: var(--text-muted); white-space: nowrap; overflow: hidden; text-overflow: ellipsis; max-width: 280px; }

    .site-nav .nav-link {
      color: var(--text-dark); font-weight: 700; font-size: .93rem;
      padding: .55rem 1rem !important; border-radius: 999px; transition: all .2s;
    }
    .site-nav .nav-link:hover { color: var(--brand-blue); background: rgba(27, 93, 143, 0.08); }
    .site-nav .nav-link.active {
      color: var(--brand-blue); background: rgba(27, 93, 143, 0.12);
      box-shadow: 0 2px 6px rgba(27, 93, 143, 0.08);
    }
    .site-nav .dropdown-menu {
      border: 1px solid rgba(226, 232, 240, 0.9); border-radius: 20px; padding: .6rem;
      background: rgba(255, 255, 255, 0.95); backdrop-filter: blur(16px);
      box-shadow: 0 20px 45px -12px rgba(15, 23, 42, 0.2); margin-top: .6rem !important; min-width: 240px;
    }
    .site-nav .dropdown-item {
      border-radius: 12px; font-weight: 600; font-size: .92rem; padding: .6rem .9rem; color: var(--text-dark);
      transition: all .2s;
    }
    .site-nav .dropdown-item i { width: 1.35rem; color: var(--brand-blue); }
    .site-nav .dropdown-item:hover, .site-nav .dropdown-item.active-item {
      background: rgba(27, 93, 143, 0.09); color: var(--brand-blue); transform: translateX(3px);
    }
    .navbar-toggler { border: 0; width: 44px; height: 44px; border-radius: 14px; display: grid; place-items: center; color: var(--brand-dark); }
    .navbar-toggler:focus { box-shadow: none; }

    /* ── Section Utilities ── */
    .section-head {
      display: flex; align-items: flex-end; justify-content: space-between;
      gap: 1.5rem; flex-wrap: wrap; margin-bottom: 2.5rem;
    }
    .eyebrow {
      display: inline-flex; align-items: center; gap: .5rem;
      font-size: .78rem; font-weight: 800; letter-spacing: .08em; text-transform: uppercase; color: var(--accent-dark);
    }
    .eyebrow::before { content: ''; width: 18px; height: 2px; background: currentColor; border-radius: 2px; }
    .section-title { font-size: clamp(1.75rem, 3.2vw, 2.5rem); font-weight: 850; color: var(--brand-dark); letter-spacing: -.03em; line-height: 1.15; margin-bottom: .5rem; }
    .section-subtitle { color: var(--text-muted); font-size: 1.05rem; line-height: 1.7; margin-bottom: 0; }

    /* ── News Cards (Pristine, 3D, Responsive) ── */
    .news-card-3d, .news {
      display: flex; flex-direction: column; height: 100%;
      background: #ffffff; border-radius: 22px; overflow: hidden;
      border: 1px solid rgba(226, 232, 240, 0.9); box-shadow: var(--shadow-3d);
      text-decoration: none; color: inherit; transition: all 0.35s cubic-bezier(0.16, 1, 0.3, 1);
    }
    .news-card-3d:hover, .news:hover {
      transform: translateY(-6px) scale(1.015);
      box-shadow: 0 25px 50px -12px rgba(11, 34, 61, 0.22);
      border-color: rgba(6, 182, 212, 0.5); color: inherit;
    }
    .news-img, .news-img-box {
      position: relative; width: 100%; aspect-ratio: 16 / 10; min-height: 185px;
      background: linear-gradient(135deg, #e8f0f7 0%, #f1f5f9 100%);
      overflow: hidden; border-radius: 20px 20px 0 0; display: block;
    }
    .news-img img, .news-img-box img {
      width: 100%; height: 100%; object-fit: cover; transition: transform 0.6s ease;
    }
    .news:hover .news-img img, .news-card-3d:hover .news-img-box img { transform: scale(1.07); }
    .news-img .ph, .news-img-placeholder {
      position: absolute; inset: 0; display: grid; place-items: center;
      color: rgba(27, 93, 143, 0.35); font-size: 3rem;
      background: radial-gradient(circle at 50% 50%, rgba(6, 182, 212, 0.12), rgba(27, 93, 143, 0.06));
    }
    .news-img .cat, .news-badge-category {
      position: absolute; top: 14px; left: 14px;
      background: rgba(255, 255, 255, 0.95); backdrop-filter: blur(8px);
      color: var(--brand-dark); font-size: 0.76rem; font-weight: 800;
      padding: 0.35rem 0.85rem; border-radius: 999px;
      box-shadow: 0 4px 12px rgba(15, 23, 42, 0.12); border: 1px solid rgba(255, 255, 255, 0.9);
      z-index: 2;
    }
    .news-content-box {
      padding: 1.5rem; display: flex; flex-direction: column; flex-grow: 1;
    }
    .news-date {
      font-size: 0.82rem; color: #64748b; font-weight: 600;
      display: flex; align-items: center; gap: 0.4rem; margin-bottom: 0.6rem;
    }
    .news-title {
      font-size: 1.18rem; font-weight: 800; line-height: 1.4; color: var(--brand-dark);
      margin-bottom: 0.65rem; letter-spacing: -0.02em; transition: color 0.2s ease;
    }
    .news-card-3d:hover .news-title, .news:hover h3 { color: var(--brand-blue); }
    .news-excerpt {
      color: #64748b; font-size: 0.92rem; line-height: 1.65; margin-bottom: 1.25rem; flex-grow: 1;
    }
    .news-readmore {
      font-size: 0.88rem; font-weight: 700; color: var(--brand-blue);
      display: inline-flex; align-items: center; gap: 0.4rem; margin-top: auto;
      transition: gap 0.2s ease, color 0.2s ease;
    }
    .news-card-3d:hover .news-readmore { gap: 0.75rem; color: var(--brand-cyan); }

    /* ── Reveal Animations ── */
    @media (prefers-reduced-motion: no-preference) {
      .js .reveal {
        opacity: 0; transform: translateY(22px);
        transition: opacity .65s ease, transform .65s cubic-bezier(.16, 1, .3, 1);
        transition-delay: var(--d, 0s);
      }
      .js .reveal.in { opacity: 1; transform: none; }
    }

    /* ── Footer ── */
    .site-footer {
      background: #071526; color: rgba(255, 255, 255, .7); padding: 5rem 0 0; font-size: .95rem;
      position: relative; overflow: hidden;
    }
    .site-footer::before {
      content: ''; position: absolute; inset: 0; pointer-events: none;
      background: radial-gradient(circle at 80% 0%, rgba(6, 182, 212, 0.15), transparent 50%);
    }
    .site-footer h6 { color: #fff; font-weight: 800; font-size: .85rem; letter-spacing: .08em; text-transform: uppercase; margin-bottom: 1.35rem; }
    .site-footer a { color: rgba(255, 255, 255, .72); text-decoration: none; transition: color .2s; }
    .site-footer a:hover { color: var(--brand-cyan); }
    .site-footer .links li { margin-bottom: .75rem; }
    .site-footer .contact li { display: flex; gap: .85rem; margin-bottom: 1rem; line-height: 1.55; }
    .site-footer .contact i { color: var(--accent); margin-top: .25rem; width: 1rem; text-align: center; }
    .footer-brand .brand-mark { background: rgba(255, 255, 255, .1); }
    .footer-brand .brand-name { color: #fff; font-size: 1.2rem; }
    .socials { display: flex; gap: .6rem; }
    .socials a {
      width: 42px; height: 42px; border-radius: 14px; display: grid; place-items: center;
      background: rgba(255, 255, 255, .08); color: #fff; transition: all .25s;
    }
    .socials a:hover { background: var(--accent); color: var(--ink); transform: translateY(-3px); }
    .map-frame { border-radius: 18px; overflow: hidden; border: 1px solid rgba(255, 255, 255, .12); height: 180px; }
    .map-frame iframe { width: 100%; height: 100%; border: 0; filter: grayscale(.3); }
    .footer-bottom { border-top: 1px solid rgba(255, 255, 255, .08); margin-top: 3.5rem; padding: 1.5rem 0; font-size: .85rem; color: rgba(255, 255, 255, .55); }

    #backToTop {
      position: fixed; right: 24px; bottom: 24px; z-index: 1020;
      width: 48px; height: 48px; border-radius: 16px; border: 0;
      background: var(--brand-dark); color: #fff; box-shadow: 0 12px 28px rgba(0, 0, 0, 0.3);
      display: grid; place-items: center;
      opacity: 0; visibility: hidden; transform: translateY(10px); transition: all .25s;
    }
    #backToTop.show { opacity: 1; visibility: visible; transform: none; }
    #backToTop:hover { background: var(--brand-blue); transform: translateY(-3px); }
  </style>
  @stack('styles')
</head>
<body>

<header class="site-nav" id="siteNav">
  <nav class="navbar navbar-expand-lg" aria-label="Navigasi utama">
    <div class="container">
      <a class="brand me-3" href="{{ route('landing.index') }}">
        @if(setting_url('logo'))
          <img src="{{ setting_url('logo') }}" alt="Logo {{ setting('sekolah_nama') }}">
        @else
          <span class="brand-mark" aria-hidden="true"><i class="fas fa-graduation-cap"></i></span>
        @endif
        <span class="min-w-0">
          <span class="brand-name">{{ setting('sekolah_nama', 'SIAKAD SMK') }}</span>
          <span class="brand-sub">{{ setting('sekolah_tagline', 'Unggul, Berkarakter, Berbudaya') }}</span>
        </span>
      </a>

      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navMenu"
              aria-controls="navMenu" aria-expanded="false" aria-label="Buka menu">
        <i class="fas fa-bars fa-lg"></i>
      </button>

      <div class="collapse navbar-collapse" id="navMenu">
        <ul class="navbar-nav mx-lg-auto gap-lg-1">
          <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('landing.index') ? 'active' : '' }}" href="{{ route('landing.index') }}">
              <i class="fas fa-home me-1 opacity-75 d-lg-none"></i> Beranda
            </a>
          </li>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle {{ request()->routeIs('landing.tentang','landing.program','landing.organisasi') ? 'active' : '' }}"
               href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">Profil</a>
            <ul class="dropdown-menu">
              <li><a class="dropdown-item {{ request()->routeIs('landing.tentang') ? 'active-item' : '' }}" href="{{ route('landing.tentang') }}"><i class="fas fa-school"></i> Tentang Sekolah</a></li>
              <li><a class="dropdown-item {{ request()->routeIs('landing.program') ? 'active-item' : '' }}" href="{{ route('landing.program') }}"><i class="fas fa-layer-group"></i> Program Keahlian</a></li>
              <li><a class="dropdown-item {{ request()->routeIs('landing.organisasi') ? 'active-item' : '' }}" href="{{ route('landing.organisasi') }}"><i class="fas fa-sitemap"></i> Struktur Organisasi</a></li>
            </ul>
          </li>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle {{ request()->routeIs('berita.*','galeri.*') ? 'active' : '' }}"
               href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">Informasi</a>
            <ul class="dropdown-menu">
              <li><a class="dropdown-item {{ request()->routeIs('berita.*') ? 'active-item' : '' }}" href="{{ route('berita.index') }}"><i class="far fa-newspaper"></i> Berita &amp; Pengumuman</a></li>
              <li><a class="dropdown-item {{ request()->routeIs('galeri.*') ? 'active-item' : '' }}" href="{{ route('galeri.index') }}"><i class="far fa-images"></i> Galeri Foto</a></li>
            </ul>
          </li>
          <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('ppdb.*') ? 'active' : '' }}" href="{{ route('ppdb.landing') }}">
              <i class="fas fa-user-graduate me-1 opacity-75 d-lg-none"></i> PPDB
            </a>
          </li>
        </ul>

        <div class="nav-actions d-flex gap-2">
          <a class="btn btn-3d-glass" href="{{ route('login') }}"><i class="fas fa-arrow-right-to-bracket me-1"></i> Masuk</a>
          @if(setting('ppdb_aktif') == '1')
            <a class="btn btn-3d-accent" href="{{ route('ppdb.index') }}"><i class="fas fa-paper-plane me-1"></i> Daftar PPDB</a>
          @endif
        </div>
      </div>
    </div>
  </nav>
</header>

<main style="min-height: 60vh;">
  @yield('content')
</main>

<footer class="site-footer">
  <div class="container">
    <div class="row g-4 g-lg-5">
      <div class="col-lg-4">
        <div class="brand footer-brand mb-3">
          @if(setting_url('logo_putih'))
            <img src="{{ setting_url('logo_putih') }}" alt="Logo {{ setting('sekolah_nama') }}">
          @else
            <span class="brand-mark" aria-hidden="true"><i class="fas fa-graduation-cap"></i></span>
          @endif
          <span>
            <span class="brand-name">{{ setting('sekolah_nama', 'SIAKAD SMK') }}</span>
            @if(setting('sekolah_npsn'))<span class="d-block small" style="color:var(--accent)">NPSN {{ setting('sekolah_npsn') }}</span>@endif
          </span>
        </div>
        <p class="mb-4" style="line-height:1.75;max-width:360px">{{ setting('sekolah_tagline', 'Mencetak generasi unggul, berkarakter, dan siap bersaing di era global.') }}</p>
        <div class="socials">
          @if(setting('sosmed_instagram'))<a href="{{ setting('sosmed_instagram') }}" aria-label="Instagram" target="_blank" rel="noopener"><i class="fab fa-instagram"></i></a>@endif
          @if(setting('sosmed_facebook'))<a href="{{ setting('sosmed_facebook') }}" aria-label="Facebook" target="_blank" rel="noopener"><i class="fab fa-facebook-f"></i></a>@endif
          @if(setting('sosmed_youtube'))<a href="{{ setting('sosmed_youtube') }}" aria-label="YouTube" target="_blank" rel="noopener"><i class="fab fa-youtube"></i></a>@endif
          @if(setting('sosmed_tiktok'))<a href="{{ setting('sosmed_tiktok') }}" aria-label="TikTok" target="_blank" rel="noopener"><i class="fab fa-tiktok"></i></a>@endif
        </div>
      </div>

      <div class="col-6 col-lg-2">
        <h6>Jelajahi</h6>
        <ul class="list-unstyled links mb-0">
          <li><a href="{{ route('landing.tentang') }}">Tentang Sekolah</a></li>
          <li><a href="{{ route('landing.program') }}">Program Keahlian</a></li>
          <li><a href="{{ route('berita.index') }}">Berita</a></li>
          <li><a href="{{ route('galeri.index') }}">Galeri</a></li>
          <li><a href="{{ route('ppdb.landing') }}">PPDB</a></li>
        </ul>
      </div>

      <div class="col-6 col-lg-2">
        <h6>Layanan</h6>
        <ul class="list-unstyled links mb-0">
          <li><a href="{{ route('login') }}">Portal SIAKAD</a></li>
          <li><a href="{{ route('ujian.login') }}">Ujian Online</a></li>
          @if(setting('ppdb_aktif') == '1')<li><a href="{{ route('ppdb.index') }}">Daftar PPDB</a></li>@endif
        </ul>
      </div>

      <div class="col-lg-4">
        <h6>Kontak</h6>
        <ul class="list-unstyled contact mb-4">
          <li><i class="fas fa-location-dot"></i><span>{{ setting('sekolah_alamat', 'Jl. Pendidikan No. 1, Jakarta Timur') }}</span></li>
          @if(setting('sekolah_no_telp'))<li><i class="fas fa-phone"></i><a href="tel:{{ preg_replace('/[^0-9+]/', '', setting('sekolah_no_telp')) }}">{{ setting('sekolah_no_telp') }}</a></li>@endif
          @if(setting('sekolah_email'))<li><i class="fas fa-envelope"></i><a href="mailto:{{ setting('sekolah_email') }}">{{ setting('sekolah_email') }}</a></li>@endif
        </ul>
        @if(setting('maps_embed'))
          <div class="map-frame"><iframe src="{{ setting('maps_embed') }}" title="Peta lokasi sekolah" loading="lazy" allowfullscreen></iframe></div>
        @endif
      </div>
    </div>

    <div class="footer-bottom d-flex flex-column flex-md-row justify-content-between gap-2">
      <span>&copy; {{ date('Y') }} {{ setting('sekolah_nama', 'SIAKAD SMK') }}. Hak cipta dilindungi.</span>
      <span>Didukung Sistem Informasi Akademik</span>
    </div>
  </div>
</footer>

<button id="backToTop" type="button" aria-label="Kembali ke atas"><i class="fas fa-arrow-up"></i></button>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/three.js/r128/three.min.js"></script>

<script>
  (() => {
    // 1. Scroll header & BackToTop
    const nav = document.getElementById('siteNav');
    const top = document.getElementById('backToTop');
    const onScroll = () => {
      nav.classList.toggle('scrolled', window.scrollY > 8);
      top.classList.toggle('show', window.scrollY > 600);
    };
    window.addEventListener('scroll', onScroll, { passive: true });
    onScroll();
    top.addEventListener('click', () => window.scrollTo({ top: 0 }));

    // 2. IntersectionObserver reveal animations
    const items = document.querySelectorAll('.reveal');
    if (!('IntersectionObserver' in window)) { items.forEach(el => el.classList.add('in')); }
    else {
      const io = new IntersectionObserver(entries => entries.forEach(e => {
        if (e.isIntersecting) { e.target.classList.add('in'); io.unobserve(e.target); }
      }), { rootMargin: '0px 0px -8% 0px' });
      items.forEach(el => io.observe(el));
    }

    // 3. Global Interactive 3D Card Tilt for ALL pages
    if (!matchMedia('(prefers-reduced-motion: reduce)').matches) {
      const apply3dTilt = () => {
        const tiltCards = document.querySelectorAll('.card-3d, .jurusan-card, .org-card, .gallery-item-3d, .news-card-3d');
        tiltCards.forEach(card => {
          if (card.dataset.tiltInit) return;
          card.dataset.tiltInit = 'true';

          let glare = card.querySelector('.card-3d-glare');
          if (!glare) {
            glare = document.createElement('div');
            glare.className = 'card-3d-glare';
            card.appendChild(glare);
          }

          card.addEventListener('mousemove', (e) => {
            const rect = card.getBoundingClientRect();
            const x = e.clientX - rect.left;
            const y = e.clientY - rect.top;
            const centerX = rect.width / 2;
            const centerY = rect.height / 2;
            const rotateX = ((y - centerY) / centerY) * -6;
            const rotateY = ((x - centerX) / centerX) * 6;

            card.style.transform = `perspective(1000px) rotateX(${rotateX.toFixed(2)}deg) rotateY(${rotateY.toFixed(2)}deg) scale3d(1.018, 1.018, 1.018)`;
            glare.style.background = `radial-gradient(circle at ${x}px ${y}px, rgba(255, 255, 255, 0.4) 0%, transparent 60%)`;
          });

          card.addEventListener('mouseleave', () => {
            card.style.transform = 'perspective(1000px) rotateX(0deg) rotateY(0deg) scale3d(1, 1, 1)';
          });

          // Mobile Touch Spring-back
          card.addEventListener('touchstart', () => {
            card.style.transform = 'perspective(1000px) scale3d(0.985, 0.985, 0.985)';
          }, { passive: true });
          card.addEventListener('touchend', () => {
            card.style.transform = 'perspective(1000px) scale3d(1, 1, 1)';
          }, { passive: true });
        });
      };
      apply3dTilt();
      window.addEventListener('DOMContentLoaded', apply3dTilt);
    }
  })();
</script>
@stack('scripts')
</body>
</html>
