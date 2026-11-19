@extends('layouts.public')
@section('title', setting('sekolah_nama', 'SIAKAD SMK'))
@section('page_title', 'Beranda')
@section('meta_desc', setting('sekolah_tagline', ''))

@php
  $ppdbAktif = setting('ppdb_aktif') == '1';
  $heroBg = setting_url('hero_bg');
  $warnaTingkat = [
    'Internasional'  => ['#fef3c7', '#92400e', '#f59e0b'],
    'Nasional'       => ['#fee2e2', '#991b1b', '#ef4444'],
    'Provinsi'       => ['#e0f2fe', '#0369a1', '#0ea5e9'],
    'Kabupaten/Kota' => ['#dcfce7', '#166534', '#22c55e'],
  ];
@endphp

@push('styles')
<style>
  /* ── Background Ambience ── */
  .landing-wrapper { position: relative; overflow-x: clip; }
  .ambient-glow {
    position: absolute; border-radius: 50%; filter: blur(90px);
    opacity: 0.45; pointer-events: none; z-index: 0;
  }
  .ambient-glow-1 {
    width: 650px; height: 650px;
    background: radial-gradient(circle, rgba(6, 182, 212, 0.35) 0%, rgba(27, 93, 143, 0.15) 60%, transparent 80%);
    top: -150px; right: -120px;
  }
  .ambient-glow-2 {
    width: 550px; height: 550px;
    background: radial-gradient(circle, rgba(245, 158, 11, 0.25) 0%, rgba(249, 115, 22, 0.1) 60%, transparent 80%);
    top: 35%; left: -180px;
  }
  .ambient-glow-3 {
    width: 700px; height: 700px;
    background: radial-gradient(circle, rgba(37, 99, 235, 0.25) 0%, rgba(14, 165, 233, 0.12) 60%, transparent 80%);
    bottom: 5%; right: -150px;
  }

  /* ── 3D Hero Section ── */
  .hero-3d {
    position: relative;
    padding: clamp(48px, 8vw, 96px) 0 clamp(48px, 7vw, 84px);
    background:
      radial-gradient(1200px 600px at 75% 10%, rgba(27, 93, 143, 0.12), transparent 70%),
      radial-gradient(800px 450px at 15% 90%, rgba(245, 158, 11, 0.08), transparent 70%),
      linear-gradient(180deg, #f8fafc 0%, #ffffff 100%);
    overflow: hidden;
  }
  .hero-3d::before {
    content: ''; position: absolute; inset: 0;
    background-image: 
      linear-gradient(to right, rgba(148, 163, 184, 0.07) 1px, transparent 1px),
      linear-gradient(to bottom, rgba(148, 163, 184, 0.07) 1px, transparent 1px);
    background-size: 32px 32px;
    mask-image: radial-gradient(ellipse at 50% 30%, #000 30%, transparent 80%);
    -webkit-mask-image: radial-gradient(ellipse at 50% 30%, #000 30%, transparent 80%);
    pointer-events: none;
  }

  .hero-badge-pill {
    display: inline-flex; align-items: center; gap: 0.65rem;
    padding: 0.4rem 1.1rem 0.4rem 0.5rem; border-radius: 999px;
    background: rgba(255, 255, 255, 0.9); backdrop-filter: blur(12px);
    border: 1px solid rgba(226, 232, 240, 0.9); box-shadow: 0 4px 14px rgba(15, 23, 42, 0.06);
    font-size: 0.88rem; font-weight: 600; color: var(--brand-dark); text-decoration: none;
    transition: all 0.3s cubic-bezier(0.2, 0.8, 0.2, 1);
  }
  .hero-badge-pill:hover {
    transform: translateY(-2px); border-color: var(--brand-cyan);
    box-shadow: 0 8px 22px rgba(6, 182, 212, 0.2); color: var(--brand-blue);
  }
  .hero-badge-dot {
    background: linear-gradient(135deg, var(--brand-gold), #d97706);
    color: #fff; padding: 0.2rem 0.65rem; border-radius: 999px;
    font-size: 0.76rem; font-weight: 700; box-shadow: 0 2px 6px rgba(245, 158, 11, 0.3);
  }
  .pulse-online {
    display: inline-block; width: 8px; height: 8px; background: var(--brand-emerald);
    border-radius: 50%; animation: pulse-ring 2s infinite;
  }
  @keyframes pulse-ring {
    0% { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(16, 185, 129, 0.7); }
    70% { transform: scale(1); box-shadow: 0 0 0 8px rgba(16, 185, 129, 0); }
    100% { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(16, 185, 129, 0); }
  }

  .hero-title {
    font-size: clamp(2.4rem, 5.5vw, 4.2rem); font-weight: 850;
    line-height: 1.08; letter-spacing: -0.04em; margin: 1.35rem 0 1.25rem; color: #0f172a;
  }
  .hero-title-gradient {
    background: linear-gradient(135deg, #0b223d 0%, #1b5d8f 50%, #06b6d4 100%);
    -webkit-background-clip: text; -webkit-text-fill-color: transparent; display: inline-block;
  }
  .hero-description {
    font-size: clamp(1.05rem, 1.8vw, 1.2rem); line-height: 1.75; color: #475569;
    max-width: 560px; margin-bottom: 2.2rem;
  }

  /* Hero 3D Stage Visual */
  .hero-stage-container {
    position: relative; width: 100%; min-height: 480px;
    display: flex; align-items: center; justify-content: center; perspective: 1200px;
  }
  .hero-canvas-wrapper {
    position: relative; width: 100%; max-width: 520px; aspect-ratio: 1 / 1;
    border-radius: 36px;
    background: radial-gradient(circle at 50% 50%, rgba(255, 255, 255, 0.9) 0%, rgba(241, 245, 249, 0.7) 100%);
    box-shadow: 0 30px 70px -20px rgba(11, 34, 61, 0.25), 0 0 0 1px rgba(255, 255, 255, 0.8) inset, 0 0 40px rgba(6, 182, 212, 0.15);
    overflow: hidden; backdrop-filter: blur(20px); border: 1px solid rgba(226, 232, 240, 0.8);
  }
  #hero3dCanvas {
    position: absolute; inset: 0; width: 100%; height: 100%;
    touch-action: pan-y; cursor: grab;
  }
  #hero3dCanvas:active { cursor: grabbing; }

  .float-badge {
    position: absolute; z-index: 10; background: rgba(255, 255, 255, 0.92);
    backdrop-filter: blur(16px); border-radius: 20px; padding: 0.9rem 1.25rem;
    border: 1px solid rgba(255, 255, 255, 0.9);
    box-shadow: 0 20px 35px -10px rgba(15, 23, 42, 0.2), 0 0 0 1px rgba(226, 232, 240, 0.6);
    display: flex; align-items: center; gap: 0.9rem; transition: transform 0.2s ease-out;
  }
  .float-badge:hover {
    box-shadow: 0 25px 45px -10px rgba(6, 182, 212, 0.3), 0 0 0 1px var(--brand-cyan);
  }
  .float-badge-icon {
    width: 44px; height: 44px; border-radius: 14px; display: grid; place-items: center;
    font-size: 1.2rem; flex-shrink: 0;
  }
  .float-badge-title { font-weight: 800; font-size: 0.96rem; color: var(--brand-dark); line-height: 1.2; }
  .float-badge-sub { font-size: 0.8rem; color: #64748b; font-weight: 500; }
  .badge-pos-top { top: 6%; right: -4%; }
  .badge-pos-bottom { bottom: 8%; left: -4%; }

  /* Stats Grid */
  .stats-grid-3d { display: grid; grid-template-columns: repeat(4, 1fr); gap: 1.25rem; margin-top: 3.5rem; }
  .stat-card-3d {
    padding: 1.25rem 1.5rem; background: rgba(255, 255, 255, 0.85);
    backdrop-filter: blur(14px); border-radius: 20px; border: 1px solid rgba(226, 232, 240, 0.9);
    box-shadow: 0 10px 25px -8px rgba(15, 23, 42, 0.08); display: flex; align-items: center; gap: 1.1rem;
  }
  .stat-card-icon {
    width: 48px; height: 48px; border-radius: 14px; display: grid; place-items: center;
    font-size: 1.3rem; flex-shrink: 0;
  }
  .stat-card-val { font-size: clamp(1.6rem, 2.5vw, 2.1rem); font-weight: 850; color: var(--brand-dark); letter-spacing: -0.03em; line-height: 1.1; }
  .stat-card-lbl { font-size: 0.83rem; font-weight: 600; color: #64748b; margin-top: 0.15rem; }

  /* Section Utilitas */
  .section-3d { position: relative; padding: clamp(60px, 9vw, 100px) 0; z-index: 1; }
  .bg-soft { background: var(--bg-light); }

  /* Program Keahlian Cards */
  .program-card-3d {
    text-decoration: none; color: inherit; display: flex; flex-direction: column;
    height: 100%; padding: 2.2rem; position: relative; background: #ffffff;
    border-radius: 26px; border: 1px solid rgba(226, 232, 240, 0.85);
    box-shadow: var(--shadow-3d); transition: all 0.35s cubic-bezier(0.16, 1, 0.3, 1);
  }
  .program-card-3d:hover {
    transform: translateY(-8px) scale(1.02);
    box-shadow: 0 30px 60px -15px rgba(11, 34, 61, 0.22), 0 0 24px rgba(6, 182, 212, 0.2);
    border-color: rgba(6, 182, 212, 0.6); color: inherit;
  }
  .program-card-index {
    position: absolute; top: 1.8rem; right: 2rem; font-size: 2.2rem; font-weight: 900;
    color: rgba(203, 213, 225, 0.5); letter-spacing: -0.05em; line-height: 1; transition: color 0.3s;
  }
  .program-card-3d:hover .program-card-index { color: var(--brand-cyan); }
  .program-icon-box {
    width: 60px; height: 60px; border-radius: 18px; display: grid; place-items: center;
    font-size: 1.6rem; background: linear-gradient(135deg, rgba(27, 93, 143, 0.1), rgba(6, 182, 212, 0.15));
    color: var(--brand-blue); margin-bottom: 1.5rem; transition: all 0.3s ease;
  }
  .program-card-3d:hover .program-icon-box {
    background: linear-gradient(135deg, var(--brand-navy), var(--brand-blue));
    color: #ffffff; transform: scale(1.1) rotate(-4deg);
    box-shadow: 0 10px 20px rgba(27, 93, 143, 0.3);
  }
  .program-card-title { font-size: 1.3rem; font-weight: 800; color: var(--brand-dark); margin-bottom: 0.85rem; padding-right: 2.5rem; }
  .program-card-desc { color: #64748b; font-size: 0.95rem; line-height: 1.65; margin-bottom: 1.5rem; flex-grow: 1; }
  .program-card-action { display: inline-flex; align-items: center; gap: 0.5rem; font-size: 0.92rem; font-weight: 700; color: var(--brand-blue); transition: gap 0.2s ease, color 0.2s ease; }
  .program-card-3d:hover .program-card-action { gap: 0.8rem; color: var(--brand-cyan); }

  /* Kepsek Card */
  .kepsek-card-3d {
    position: relative; border-radius: 28px; overflow: hidden;
    box-shadow: 0 35px 70px -20px rgba(15, 23, 42, 0.35); aspect-ratio: 4 / 4.8;
    background: linear-gradient(145deg, #0b223d, #1b5d8f);
  }
  .kepsek-card-3d img { width: 100%; height: 100%; object-fit: cover; transition: transform 0.6s ease; }
  .kepsek-card-3d:hover img { transform: scale(1.05); }
  .kepsek-card-fallback { position: absolute; inset: 0; display: grid; place-items: center; font-size: 6rem; font-weight: 900; color: rgba(255, 255, 255, 0.35); }
  .kepsek-card-overlay {
    position: absolute; inset: auto 16px 16px 16px; background: rgba(255, 255, 255, 0.92);
    backdrop-filter: blur(14px); border-radius: 20px; padding: 1.1rem 1.4rem;
    box-shadow: 0 15px 35px rgba(0, 0, 0, 0.2); border: 1px solid rgba(255, 255, 255, 0.9);
  }
  .quote-box-3d {
    position: relative; padding: 2.5rem; border-radius: 28px;
    background: rgba(255, 255, 255, 0.8); backdrop-filter: blur(16px);
    border: 1px solid rgba(226, 232, 240, 0.9); box-shadow: var(--shadow-3d);
  }

  /* Prestasi & Ekskul */
  .achievement-item-3d {
    display: flex; align-items: center; gap: 1.25rem; padding: 1.15rem 1.35rem;
    border-radius: 18px; background: #ffffff; border: 1px solid rgba(226, 232, 240, 0.8);
    box-shadow: 0 4px 15px rgba(15, 23, 42, 0.04); margin-bottom: 0.85rem; transition: all 0.25s ease;
  }
  .achievement-item-3d:hover {
    transform: translateX(6px); border-color: rgba(6, 182, 212, 0.4);
    box-shadow: 0 8px 25px rgba(11, 34, 61, 0.1);
  }
  .achievement-badge-tingkat {
    font-size: 0.75rem; font-weight: 800; padding: 0.25rem 0.75rem;
    border-radius: 999px; letter-spacing: 0.02em; display: inline-flex; align-items: center; gap: 0.35rem;
  }
  .ekskul-tag-3d {
    display: inline-flex; align-items: center; gap: 0.65rem; padding: 0.6rem 1.1rem 0.6rem 0.6rem;
    background: rgba(255, 255, 255, 0.9); backdrop-filter: blur(10px);
    border: 1px solid rgba(226, 232, 240, 0.9); border-radius: 999px;
    font-weight: 700; font-size: 0.92rem; color: var(--brand-dark);
    box-shadow: 0 4px 12px rgba(15, 23, 42, 0.04); transition: all 0.25s ease;
  }
  .ekskul-tag-3d:hover {
    transform: translateY(-3px) scale(1.03); border-color: var(--brand-cyan);
    box-shadow: 0 8px 20px rgba(6, 182, 212, 0.2); color: var(--brand-blue);
  }
  .ekskul-tag-icon {
    width: 32px; height: 32px; border-radius: 50%;
    background: linear-gradient(135deg, rgba(27, 93, 143, 0.12), rgba(6, 182, 212, 0.15));
    color: var(--brand-blue); display: grid; place-items: center; font-size: 0.85rem;
  }

  /* Galeri 3D */
  .gallery-grid-3d {
    display: grid; grid-template-columns: repeat(4, 1fr); grid-auto-rows: 220px; gap: 1.25rem;
  }
  .gallery-item-3d {
    position: relative; border-radius: 24px; overflow: hidden; text-decoration: none;
    box-shadow: var(--shadow-3d); transition: all 0.4s cubic-bezier(0.16, 1, 0.3, 1);
  }
  .gallery-item-3d:first-child { grid-column: span 2; grid-row: span 2; }
  .gallery-item-3d img { width: 100%; height: 100%; object-fit: cover; transition: transform 0.6s ease; }
  .gallery-item-3d:hover img { transform: scale(1.08); }
  .gallery-item-3d:hover { transform: translateY(-5px); box-shadow: 0 25px 50px -12px rgba(11, 34, 61, 0.3); }
  .gallery-item-caption {
    position: absolute; inset: auto 0 0 0; padding: 3rem 1.5rem 1.25rem;
    background: linear-gradient(to top, rgba(7, 21, 38, 0.9) 0%, rgba(7, 21, 38, 0) 100%); color: #ffffff;
  }

  /* 3D CTA Banner */
  .cta-banner-3d {
    position: relative; border-radius: 36px; padding: clamp(2.5rem, 6vw, 4.5rem);
    background: linear-gradient(135deg, #071526 0%, #0b223d 45%, #1b5d8f 100%);
    color: #ffffff; overflow: hidden; box-shadow: 0 40px 90px -25px rgba(7, 21, 38, 0.55);
  }
  .cta-banner-3d::after {
    content: ''; position: absolute; width: 500px; height: 500px; right: -150px; top: -150px;
    border-radius: 50%;
    background: radial-gradient(circle, rgba(6, 182, 212, 0.4) 0%, rgba(245, 158, 11, 0.2) 50%, transparent 75%);
    filter: blur(60px); pointer-events: none;
  }
  .cta-banner-3d > * { position: relative; z-index: 1; }

  /* Responsive Mobile */
  @media (max-width: 991.98px) {
    .hero-stage-container { min-height: 400px; margin-top: 2rem; }
    .badge-pos-top { right: 0; top: 0; }
    .badge-pos-bottom { left: 0; bottom: 0; }
    .stats-grid-3d { grid-template-columns: repeat(2, 1fr); }
    .gallery-grid-3d { grid-template-columns: repeat(2, 1fr); grid-auto-rows: 170px; }
  }
  @media (max-width: 575.98px) {
    .hero-3d { padding: 36px 0 48px; }
    .hero-stage-container { min-height: 330px; }
    .hero-canvas-wrapper { max-width: 320px; border-radius: 28px; }
    .float-badge { padding: 0.65rem 0.85rem; border-radius: 16px; }
    .float-badge-icon { width: 34px; height: 34px; font-size: 1rem; border-radius: 10px; }
    .float-badge-title { font-size: 0.85rem; }
    .float-badge-sub { font-size: 0.72rem; }
    .badge-pos-top { top: -8px; right: -8px; }
    .badge-pos-bottom { bottom: -8px; left: -8px; }
    .stats-grid-3d { grid-template-columns: 1fr 1fr; gap: 0.85rem; }
    .stat-card-3d { padding: 1rem; gap: 0.75rem; border-radius: 16px; }
    .stat-card-icon { width: 38px; height: 38px; font-size: 1.1rem; border-radius: 10px; }
    .stat-card-val { font-size: 1.45rem; }
    .program-card-3d { padding: 1.6rem; border-radius: 20px; }
    .gallery-grid-3d { grid-template-columns: 1fr; grid-auto-rows: 200px; }
    .gallery-item-3d:first-child { grid-column: span 1; grid-row: span 1; }
    .cta-banner-3d { padding: 2.2rem 1.6rem; border-radius: 26px; }
  }
</style>
@endpush

@section('content')

<div class="landing-wrapper">
  {{-- Ambient Glowing Lights --}}
  <div class="ambient-glow ambient-glow-1" aria-hidden="true"></div>
  <div class="ambient-glow ambient-glow-2" aria-hidden="true"></div>
  <div class="ambient-glow ambient-glow-3" aria-hidden="true"></div>

  {{-- ── 1. Hero 3D Section ──────────────────────────────────────────────── --}}
  <section class="hero-3d">
    <div class="container position-relative" style="z-index: 2;">
      <div class="row align-items-center g-4 g-lg-5">
        
        {{-- Hero Left: Headlines & Actions --}}
        <div class="col-lg-6">
          <div class="reveal">
            @if($ppdbAktif)
              <a href="{{ route('ppdb.index') }}" class="hero-badge-pill mb-3">
                <span class="hero-badge-dot">PPDB {{ setting('ppdb_tahun_ajaran') }}</span>
                <span>Pendaftaran Online Terbuka</span>
                <span class="pulse-online ms-1"></span>
              </a>
            @else
              <div class="hero-badge-pill mb-3">
                <span class="hero-badge-dot">Berdiri Sejak {{ $stats['tahun_berdiri'] }}</span>
                <span>Pendidikan Vokasi Unggulan</span>
                <i class="fas fa-certificate text-warning ms-1"></i>
              </div>
            @endif

            <h1 class="hero-title">
              Membentuk Generasi <span class="hero-title-gradient">Digital &amp; Vokasi</span> Masa Depan.
            </h1>

            <p class="hero-description">
              {{ setting('sekolah_tagline', 'Berkomitmen mencetak lulusan yang kompeten, berkarakter mulia, dan siap bersaing di kancah industri global melalui pembelajaran modern berbasis praktik nyata.') }}
            </p>

            <div class="d-flex flex-wrap gap-3 pt-2">
              @if($ppdbAktif)
                <a href="{{ route('ppdb.index') }}" class="btn-3d-accent">
                  <i class="fas fa-user-plus"></i>
                  <span>Daftar PPDB Sekarang</span>
                </a>
              @endif
              <a href="#program" class="btn-3d-primary">
                <i class="fas fa-shapes"></i>
                <span>Jelajahi Program</span>
              </a>
              <a href="{{ route('landing.tentang') }}" class="btn-3d-glass">
                <i class="fas fa-compass"></i>
                <span>Profil Sekolah</span>
              </a>
            </div>
          </div>
        </div>

        {{-- Hero Right: Interactive 3D Canvas Stage --}}
        <div class="col-lg-6">
          <div class="hero-stage-container reveal" style="--d: 0.15s">
            <div class="hero-canvas-wrapper" id="heroCanvasWrapper">
              {{-- Three.js Canvas --}}
              <canvas id="hero3dCanvas" aria-label="3D Interactive Holographic Emblem"></canvas>

              {{-- Fallback Emblem if WebGL Disabled --}}
              <noscript>
                <div class="d-grid place-items-center h-100 p-4 text-center">
                  <i class="fas fa-graduation-cap fa-5x text-primary mb-3"></i>
                  <h4 class="fw-bold">{{ setting('sekolah_nama') }}</h4>
                </div>
              </noscript>
            </div>

            {{-- 3D Floating Interactive Badges --}}
            <div class="float-badge badge-pos-top" data-parallax="0.25">
              <div class="float-badge-icon" style="background: rgba(245, 158, 11, 0.15); color: #d97706;">
                <i class="fas fa-trophy"></i>
              </div>
              <div>
                <div class="float-badge-title">{{ number_format($stats['prestasi'], 0, ',', '.') }}+ Prestasi</div>
                <div class="float-badge-sub">Nasional &amp; Provinsi</div>
              </div>
            </div>

            <div class="float-badge badge-pos-bottom" data-parallax="-0.2">
              <div class="float-badge-icon" style="background: rgba(6, 182, 212, 0.15); color: #0284c7;">
                <i class="fas fa-laptop-code"></i>
              </div>
              <div>
                <div class="float-badge-title">{{ $stats['jurusan'] }} Kejuruan Unggulan</div>
                <div class="float-badge-sub">Kurikulum Berbasis Industri</div>
              </div>
            </div>

          </div>
        </div>

      </div>

      {{-- 3D Interactive Stats Grid --}}
      <div class="stats-grid-3d reveal" style="--d: 0.25s">
        <div class="stat-card-3d card-3d">
          <div class="card-3d-glare"></div>
          <div class="stat-card-icon" style="background: rgba(37, 99, 235, 0.12); color: #2563eb;">
            <i class="fas fa-user-graduate"></i>
          </div>
          <div>
            <div class="stat-card-val" data-count="{{ $stats['siswa'] }}">{{ number_format($stats['siswa'], 0, ',', '.') }}</div>
            <div class="stat-card-lbl">Siswa Aktif</div>
          </div>
        </div>

        <div class="stat-card-3d card-3d">
          <div class="card-3d-glare"></div>
          <div class="stat-card-icon" style="background: rgba(16, 185, 129, 0.12); color: #059669;">
            <i class="fas fa-chalkboard-teacher"></i>
          </div>
          <div>
            <div class="stat-card-val" data-count="{{ $stats['guru'] }}">{{ number_format($stats['guru'], 0, ',', '.') }}</div>
            <div class="stat-card-lbl">Pendidik Profesional</div>
          </div>
        </div>

        <div class="stat-card-3d card-3d">
          <div class="card-3d-glare"></div>
          <div class="stat-card-icon" style="background: rgba(245, 158, 11, 0.12); color: #d97706;">
            <i class="fas fa-cubes"></i>
          </div>
          <div>
            <div class="stat-card-val" data-count="{{ $stats['jurusan'] }}">{{ number_format($stats['jurusan'], 0, ',', '.') }}</div>
            <div class="stat-card-lbl">Program Kejuruan</div>
          </div>
        </div>

        <div class="stat-card-3d card-3d">
          <div class="card-3d-glare"></div>
          <div class="stat-card-icon" style="background: rgba(168, 85, 247, 0.12); color: #9333ea;">
            <i class="fas fa-medal"></i>
          </div>
          <div>
            <div class="stat-card-val" data-count="{{ $stats['prestasi'] }}">{{ number_format($stats['prestasi'], 0, ',', '.') }}</div>
            <div class="stat-card-lbl">Penghargaan Juara</div>
          </div>
        </div>
      </div>

    </div>
  </section>

  {{-- ── 2. Sambutan Kepala Sekolah ────────────────────────────────────────── --}}
  @if(setting('sambutan_kepsek') || setting('nama_kepsek'))
  @php
    $namaKepsek = setting('nama_kepsek', 'Kepala Sekolah');
    $inisial = collect(preg_split('/\s+/', preg_replace('/^(drs?|dra|ir|prof|h|hj)\.?\s+/i', '', $namaKepsek)))
      ->filter(fn ($k) => preg_match('/^\p{L}/u', $k))->take(2)->map(fn ($k) => mb_strtoupper(mb_substr($k, 0, 1)))->implode('');
  @endphp
  <section class="section-3d">
    <div class="container">
      <div class="row align-items-center g-4 g-lg-5">
        <div class="col-lg-5 reveal">
          <div class="kepsek-card-3d card-3d mx-auto mx-lg-0">
            <div class="card-3d-glare"></div>
            @if(setting_url('foto_kepsek'))
              <img src="{{ setting_url('foto_kepsek') }}" alt="Foto {{ $namaKepsek }}" loading="lazy">
            @else
              <div class="kepsek-card-fallback" aria-hidden="true">{{ $inisial ?: 'KS' }}</div>
            @endif
            <div class="kepsek-card-overlay">
              <strong>{{ $namaKepsek }}</strong>
              <span>Kepala Sekolah {{ setting('sekolah_nama') }}</span>
            </div>
          </div>
        </div>

        <div class="col-lg-7 reveal" style="--d: 0.1s">
          <div class="quote-box-3d">
            <span class="eyebrow"><i class="fas fa-quote-left text-primary me-2"></i>Sambutan Kepala Sekolah</span>
            <h2 class="section-title mt-2 mb-3">Membangun Generasi Vokasi yang Siap Berkarya dan Berdaya Saing</h2>
            @if(setting('sambutan_kepsek'))
              <p class="section-subtitle fs-5" style="line-height: 1.85; color: #334155;">
                &ldquo;{{ Str::limit(html_entity_decode(strip_tags(setting('sambutan_kepsek'))), 480) }}&rdquo;
              </p>
            @endif
            <div class="mt-4 pt-2">
              <a href="{{ route('landing.tentang') }}" class="btn-3d-primary">
                <span>Kenali Sekolah Lebih Dekat</span>
                <i class="fas fa-arrow-right"></i>
              </a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  @endif

  {{-- ── 3. Program Keahlian (3D Hover Grid) ───────────────────────────────── --}}
  <section class="section-3d bg-soft" id="program">
    <div class="container">
      <div class="section-head reveal">
        <div>
          <span class="eyebrow"><i class="fas fa-microchip text-primary me-1"></i> Jalur Kejuruan</span>
          <h2 class="section-title mt-2">Program Keahlian Terakreditasi</h2>
          <p class="section-subtitle">Didesain bersama praktisi industri, mengasah kompetensi teknis dengan laboratorium modern.</p>
        </div>
        <a href="{{ route('landing.program') }}" class="btn-3d-glass">
          <span>Semua Jurusan</span>
          <i class="fas fa-arrow-right ms-1"></i>
        </a>
      </div>

      <div class="row g-4">
        @forelse($jurusans as $j)
          <div class="col-md-6 col-lg-4 reveal" style="--d:{{ ($loop->index % 3) * 0.08 }}s">
            <a href="{{ route('landing.program') }}" class="program-card-3d card-3d">
              <div class="card-3d-glare"></div>
              <span class="program-card-index">{{ str_pad($loop->iteration, 2, '0', STR_PAD_LEFT) }}</span>
              <div class="program-icon-box">
                <i class="{{ $j->icon ?: 'fas fa-laptop-code' }}"></i>
              </div>
              <h3 class="program-card-title">{{ $j->nama_jurusan }}</h3>
              <p class="program-card-desc">
                {{ $j->deskripsi_publik ? Str::limit($j->deskripsi_publik, 140) : 'Program keahlian spesialisasi dengan kurikulum aplikatif yang siap mengantar siswa menuju karir industri impian.' }}
              </p>
              <div class="program-card-action">
                <span>Pelajari Kurikulum &amp; Prospek</span>
                <i class="fas fa-arrow-right"></i>
              </div>
            </a>
          </div>
        @empty
          <div class="col-12"><div class="empty">Belum ada data program keahlian.</div></div>
        @endforelse
      </div>
    </div>
  </section>

  {{-- ── 4. Prestasi & Ekstrakurikuler Showcase ────────────────────────────── --}}
  <section class="section-3d">
    <div class="container">
      <div class="row g-4 g-lg-5">
        
        {{-- Prestasi Terkini --}}
        <div class="col-lg-7 reveal">
          <div class="panel card-3d p-4 p-md-5">
            <div class="card-3d-glare"></div>
            <span class="eyebrow"><i class="fas fa-award text-warning me-1"></i> Rekam Jejak Juara</span>
            <h3 class="section-title fs-2 mt-2 mb-4">Prestasi Siswa Terbaru</h3>
            
            @forelse($prestasis->take(4) as $p)
              @php 
                [$bg, $fg, $accent] = $warnaTingkat[$p->tingkat] ?? ['#f1f5f9', '#334155', '#64748b']; 
              @endphp
              <div class="achievement-item-3d">
                <div class="stat-card-icon" style="background: {{ $bg }}; color: {{ $accent }};">
                  <i class="fas fa-trophy"></i>
                </div>
                <div class="flex-grow-1 min-w-0">
                  <h5 class="fw-bold mb-1 text-truncate" title="{{ $p->nama_prestasi }}">{{ $p->nama_prestasi }}</h5>
                  <div class="d-flex flex-wrap align-items-center gap-2">
                    <span class="achievement-badge-tingkat" style="background: {{ $bg }}; color: {{ $fg }}; border: 1px solid {{ $accent }}40;">
                      <i class="fas fa-star small"></i> {{ $p->tingkat }}
                    </span>
                    <span class="text-muted small"><i class="far fa-user me-1"></i>{{ $p->siswa->nama ?? 'Siswa' }}</span>
                    <span class="text-muted small"><i class="far fa-calendar-alt me-1"></i>{{ \Carbon\Carbon::parse($p->tanggal)->locale('id')->translatedFormat('F Y') }}</span>
                  </div>
                </div>
              </div>
            @empty
              <div class="empty">Belum ada catatan prestasi.</div>
            @endforelse
          </div>
        </div>

        {{-- Ekstrakurikuler --}}
        <div class="col-lg-5 reveal" style="--d: 0.12s">
          <div class="panel card-3d p-4 p-md-5">
            <div class="card-3d-glare"></div>
            <span class="eyebrow"><i class="fas fa-compass text-info me-1"></i> Pengembangan Karakter</span>
            <h3 class="section-title fs-2 mt-2 mb-2">Ekstrakurikuler</h3>
            <p class="text-muted mb-4">Wadah bagi siswa untuk mengasah bakat, minat, leadership, dan kreativitas di luar jam kelas.</p>

            @if($ekskuls->isNotEmpty())
              <div class="d-flex flex-wrap gap-2">
                @foreach($ekskuls as $e)
                  <span class="ekskul-tag-3d" @if($e->pembina) title="Pembina: {{ $e->pembina->nama }}" @endif>
                    <span class="ekskul-tag-icon"><i class="fas fa-star"></i></span>
                    <span>{{ $e->nama }}</span>
                  </span>
                @endforeach
              </div>
            @else
              <div class="empty">Belum ada data ekstrakurikuler.</div>
            @endif
          </div>
        </div>

      </div>
    </div>
  </section>

  {{-- ── 5. Galeri Momen Sekolah ───────────────────────────────────────────── --}}
  @if($galeriTerbaru->isNotEmpty())
  <section class="section-3d bg-soft">
    <div class="container">
      <div class="section-head reveal">
        <div>
          <span class="eyebrow"><i class="fas fa-camera text-primary me-1"></i> Dokumentasi</span>
          <h2 class="section-title mt-2">Aktivitas &amp; Fasilitas Sekolah</h2>
        </div>
        <a href="{{ route('galeri.index') }}" class="btn-3d-glass">
          <span>Semua Album</span>
          <i class="fas fa-arrow-right ms-1"></i>
        </a>
      </div>

      <div class="gallery-grid-3d reveal">
        @foreach($galeriTerbaru as $g)
          <a href="{{ route('galeri.show', $g) }}" class="gallery-item-3d card-3d">
            <div class="card-3d-glare"></div>
            @if($g->cover_url)
              <img src="{{ $g->cover_url }}" alt="{{ $g->nama }}" loading="lazy">
            @else
              <div class="d-grid place-items-center h-100 bg-secondary bg-opacity-10 text-muted">
                <i class="far fa-images fa-3x opacity-50"></i>
              </div>
            @endif
            <div class="gallery-item-caption">
              <strong>{{ $g->nama }}</strong>
              <span class="small opacity-75">{{ $g->items_count }} Foto @if($g->tanggal) &bull; {{ $g->tanggal->locale('id')->translatedFormat('d M Y') }}@endif</span>
            </div>
          </a>
        @endforeach
      </div>
    </div>
  </section>
  @endif

  {{-- ── 6. Kabar & Berita Terbaru (BERITA FIX & REDESIGN) ─────────────────── --}}
  @if($artikelTerbaru->isNotEmpty())
  <section class="section-3d">
    <div class="container">
      <div class="section-head reveal">
        <div>
          <span class="eyebrow"><i class="fas fa-newspaper text-primary me-1"></i> Warta Kampus</span>
          <h2 class="section-title mt-2">Berita &amp; Informasi Terkini</h2>
          <p class="section-subtitle">Dapatkan update pengumuman resmi dan kabar prestasi terkini dari sekolah.</p>
        </div>
        <a href="{{ route('berita.index') }}" class="btn-3d-glass">
          <span>Arsip Berita</span>
          <i class="fas fa-arrow-right ms-1"></i>
        </a>
      </div>

      <div class="row g-4 g-lg-5">
        @foreach($artikelTerbaru as $a)
          <div class="col-md-6 col-lg-4 reveal" style="--d:{{ $loop->index * 0.08 }}s">
            <a href="{{ route('berita.show', $a) }}" class="news-card-3d card-3d">
              <div class="card-3d-glare"></div>
              
              {{-- Thumbnail Box with Category Badge --}}
              <div class="news-img-box">
                @if($a->thumbnail_url)
                  <img src="{{ $a->thumbnail_url }}" alt="{{ $a->judul }}" loading="lazy">
                @else
                  <div class="news-img-placeholder">
                    <i class="far fa-newspaper"></i>
                  </div>
                @endif
                <span class="news-badge-category">
                  <i class="fas fa-tag small text-primary me-1"></i>{{ $a->kategori_label }}
                </span>
              </div>

              {{-- Content Box --}}
              <div class="news-content-box">
                <div class="news-date">
                  <i class="far fa-clock text-primary"></i>
                  <span>{{ \Carbon\Carbon::parse($a->published_at)->locale('id')->translatedFormat('d F Y') }}</span>
                </div>
                <h3 class="news-title">{{ Str::limit($a->judul, 72) }}</h3>
                <p class="news-excerpt">{{ Str::limit($a->ringkasan_auto, 115) }}</p>
                
                <div class="news-readmore">
                  <span>Baca Selengkapnya</span>
                  <i class="fas fa-arrow-right"></i>
                </div>
              </div>
            </a>
          </div>
        @endforeach
      </div>
    </div>
  </section>
  @endif

  {{-- ── 7. Interactive 3D Call To Action ─────────────────────────────────── --}}
  <section class="pb-5 pt-3">
    <div class="container pb-4">
      <div class="cta-banner-3d card-3d reveal">
        <div class="card-3d-glare"></div>
        <div class="row align-items-center g-4">
          <div class="col-lg-8">
            @if($ppdbAktif)
              <span class="badge rounded-pill px-3 py-2 mb-3 fw-bold" style="background: var(--brand-gold); color: #071526;">
                <i class="fas fa-bell me-1"></i> PPDB T.A. {{ setting('ppdb_tahun_ajaran') }} Telah Dibuka
              </span>
              <h2 class="display-6 fw-bold mb-3 text-white">Siap Mengukir Masa Depan Gemilang Bersama Kami?</h2>
              <p class="fs-5 text-white-50 mb-0">Daftarkan dirimu secara online dengan mudah, pilih jurusan favoritmu, dan pantau status kelulusan secara real-time.</p>
            @else
              <h2 class="display-6 fw-bold mb-3 text-white">Ingin Mengetahui Informasi Lebih Lanjut?</h2>
              <p class="fs-5 text-white-50 mb-0">Hubungi kami atau jadwalkan kunjungan sekolah untuk melihat langsung sarana praktikum dan kultur belajar unggulan kami.</p>
            @endif
          </div>
          <div class="col-lg-4 text-lg-end">
            @if($ppdbAktif)
              <a href="{{ route('ppdb.index') }}" class="btn-3d-accent btn-lg px-4 py-3">
                <i class="fas fa-paper-plane"></i>
                <span>Daftar Sekarang</span>
              </a>
            @else
              <a href="{{ route('ppdb.landing') }}" class="btn-3d-accent btn-lg px-4 py-3">
                <i class="fas fa-info-circle"></i>
                <span>Informasi PPDB</span>
              </a>
            @endif
          </div>
        </div>
      </div>
    </div>
  </section>

</div>

@endsection

@push('scripts')
<script>
  /* ==========================================================================
     THREE.JS 3D HERO INTERACTIVE SCENE
     ========================================================================== */
  (() => {
    const canvas = document.getElementById('hero3dCanvas');
    const container = document.getElementById('heroCanvasWrapper');
    if (!canvas || !container || typeof THREE === 'undefined') return;

    const isReduced = matchMedia('(prefers-reduced-motion: reduce)').matches;

    const scene = new THREE.Scene();
    const camera = new THREE.PerspectiveCamera(45, container.clientWidth / container.clientHeight, 0.1, 1000);
    camera.position.z = 7;

    const renderer = new THREE.WebGLRenderer({
      canvas,
      antialias: true,
      alpha: true,
      powerPreference: 'high-performance'
    });
    renderer.setPixelRatio(Math.min(window.devicePixelRatio, 2));
    renderer.setSize(container.clientWidth, container.clientHeight);

    const mainGroup = new THREE.Group();
    scene.add(mainGroup);

    // 1. Central Core
    const coreGeo = new THREE.IcosahedronGeometry(1.6, 1);
    const coreMat = new THREE.MeshPhongMaterial({
      color: 0x1b5d8f,
      emissive: 0x071526,
      specular: 0x06b6d4,
      shininess: 90,
      flatShading: true,
      transparent: true,
      opacity: 0.92
    });
    const coreMesh = new THREE.Mesh(coreGeo, coreMat);
    mainGroup.add(coreMesh);

    const wireMat = new THREE.MeshBasicMaterial({
      color: 0x38bdf8,
      wireframe: true,
      transparent: true,
      opacity: 0.4
    });
    const wireMesh = new THREE.Mesh(coreGeo, wireMat);
    wireMesh.scale.set(1.02, 1.02, 1.02);
    mainGroup.add(wireMesh);

    // 2. Orbiting Rings
    const ringGeo1 = new THREE.TorusGeometry(2.35, 0.035, 16, 100);
    const ringMat1 = new THREE.MeshBasicMaterial({ color: 0xf59e0b, transparent: true, opacity: 0.75 });
    const ring1 = new THREE.Mesh(ringGeo1, ringMat1);
    ring1.rotation.x = Math.PI / 3;
    ring1.rotation.y = Math.PI / 6;
    mainGroup.add(ring1);

    const ringGeo2 = new THREE.TorusGeometry(2.7, 0.025, 16, 100);
    const ringMat2 = new THREE.MeshBasicMaterial({ color: 0x06b6d4, transparent: true, opacity: 0.65 });
    const ring2 = new THREE.Mesh(ringGeo2, ringMat2);
    ring2.rotation.x = -Math.PI / 4;
    ring2.rotation.y = Math.PI / 4;
    mainGroup.add(ring2);

    // 3. Floating 3D Star Particles
    const particleCount = 140;
    const particleGeo = new THREE.BufferGeometry();
    const positions = new Float32Array(particleCount * 3);
    const colors = new Float32Array(particleCount * 3);

    for (let i = 0; i < particleCount * 3; i += 3) {
      const radius = 2.8 + Math.random() * 2.2;
      const theta = Math.random() * Math.PI * 2;
      const phi = Math.acos((Math.random() * 2) - 1);

      positions[i] = radius * Math.sin(phi) * Math.cos(theta);
      positions[i + 1] = radius * Math.sin(phi) * Math.sin(theta);
      positions[i + 2] = radius * Math.cos(phi);

      if (Math.random() > 0.5) {
        colors[i] = 0.02; colors[i + 1] = 0.71; colors[i + 2] = 0.83;
      } else {
        colors[i] = 0.96; colors[i + 1] = 0.62; colors[i + 2] = 0.04;
      }
    }
    particleGeo.setAttribute('position', new THREE.BufferAttribute(positions, 3));
    particleGeo.setAttribute('color', new THREE.BufferAttribute(colors, 3));

    const particleMat = new THREE.PointsMaterial({
      size: 0.08,
      vertexColors: true,
      transparent: true,
      opacity: 0.85
    });
    const particles = new THREE.Points(particleGeo, particleMat);
    mainGroup.add(particles);

    // 4. Lights
    const ambientLight = new THREE.AmbientLight(0xffffff, 0.85);
    scene.add(ambientLight);

    const pointLight1 = new THREE.PointLight(0x06b6d4, 2.5, 20);
    pointLight1.position.set(4, 3, 5);
    scene.add(pointLight1);

    const pointLight2 = new THREE.PointLight(0xf59e0b, 1.8, 20);
    pointLight2.position.set(-4, -3, 3);
    scene.add(pointLight2);

    // Interactive Dragging
    let targetRotX = 0;
    let targetRotY = 0;
    let isDragging = false;
    let prevPointerX = 0;
    let prevPointerY = 0;

    const handlePointerDown = (clientX, clientY) => {
      isDragging = true;
      prevPointerX = clientX;
      prevPointerY = clientY;
    };

    const handlePointerMove = (clientX, clientY) => {
      if (isDragging) {
        const deltaX = clientX - prevPointerX;
        const deltaY = clientY - prevPointerY;
        targetRotY += deltaX * 0.007;
        targetRotX += deltaY * 0.007;
        prevPointerX = clientX;
        prevPointerY = clientY;
      } else {
        const rect = container.getBoundingClientRect();
        const nx = ((clientX - rect.left) / rect.width) * 2 - 1;
        const ny = -(((clientY - rect.top) / rect.height) * 2 - 1);
        targetRotY = nx * 0.45;
        targetRotX = -ny * 0.45;
      }
    };

    const handlePointerUp = () => { isDragging = false; };

    container.addEventListener('mousedown', (e) => handlePointerDown(e.clientX, e.clientY));
    window.addEventListener('mousemove', (e) => {
      if (isDragging || container.contains(e.target)) {
        handlePointerMove(e.clientX, e.clientY);
      }
    });
    window.addEventListener('mouseup', handlePointerUp);

    container.addEventListener('touchstart', (e) => {
      if (e.touches.length === 1) handlePointerDown(e.touches[0].clientX, e.touches[0].clientY);
    }, { passive: true });

    container.addEventListener('touchmove', (e) => {
      if (isDragging && e.touches.length === 1) handlePointerMove(e.touches[0].clientX, e.touches[0].clientY);
    }, { passive: true });

    container.addEventListener('touchend', handlePointerUp, { passive: true });

    const ro = new ResizeObserver(() => {
      const w = container.clientWidth;
      const h = container.clientHeight;
      camera.aspect = w / h;
      camera.updateProjectionMatrix();
      renderer.setSize(w, h);
    });
    ro.observe(container);

    let clock = new THREE.Clock();
    const animate = () => {
      requestAnimationFrame(animate);
      if (!isReduced) {
        ring1.rotation.z += 0.008;
        ring2.rotation.z -= 0.006;
        particles.rotation.y += 0.002;
        coreMesh.rotation.y += 0.004;
        wireMesh.rotation.y += 0.004;

        mainGroup.rotation.y += (targetRotY - mainGroup.rotation.y) * 0.08;
        mainGroup.rotation.x += (targetRotX - mainGroup.rotation.x) * 0.08;
      }
      renderer.render(scene, camera);
    };
    animate();
  })();

  /* ==========================================================================
     FLOATING BADGES 3D MOUSE PARALLAX
     ========================================================================== */
  (() => {
    if (matchMedia('(prefers-reduced-motion: reduce)').matches) return;
    const badges = document.querySelectorAll('[data-parallax]');
    window.addEventListener('mousemove', (e) => {
      const nx = (e.clientX / window.innerWidth) * 2 - 1;
      const ny = (e.clientY / window.innerHeight) * 2 - 1;
      badges.forEach(badge => {
        const factor = parseFloat(badge.dataset.parallax || 0.15);
        badge.style.transform = `translate3d(${(nx * factor * 35).toFixed(1)}px, ${(ny * factor * 35).toFixed(1)}px, 0)`;
      });
    });
  })();

  /* ==========================================================================
     NUMBER COUNTER ANIMATION
     ========================================================================== */
  (() => {
    if (!('IntersectionObserver' in window) || matchMedia('(prefers-reduced-motion: reduce)').matches) return;
    const fmt = n => n.toLocaleString('id-ID');
    const io = new IntersectionObserver(entries => {
      entries.forEach(e => {
        if (!e.isIntersecting) return;
        io.unobserve(e.target);
        const el = e.target;
        const target = +el.dataset.count;
        if (!target) return;
        const t0 = performance.now();
        const dur = 1200;
        const tick = now => {
          const p = Math.min((now - t0) / dur, 1);
          el.textContent = fmt(Math.round(target * (1 - Math.pow(1 - p, 4))));
          if (p < 1) requestAnimationFrame(tick);
        };
        requestAnimationFrame(tick);
      });
    }, { threshold: 0.5 });
    document.querySelectorAll('[data-count]').forEach(el => io.observe(el));
  })();
</script>
@endpush
