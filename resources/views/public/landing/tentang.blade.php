@extends('layouts.public')
@section('title', 'Tentang Kami')
@section('page_title', 'Tentang Kami')

@section('content')
{{-- 3D Subpage Header --}}
<div class="subpage-hero-3d">
  <div class="subpage-hero-glow subpage-hero-glow-1" aria-hidden="true"></div>
  <div class="subpage-hero-glow subpage-hero-glow-2" aria-hidden="true"></div>
  <div class="container position-relative" style="z-index: 2;">
    <div class="subpage-breadcrumb-pill">
      <a href="{{ route('landing.index') }}"><i class="fas fa-home me-1"></i> Beranda</a>
      <i class="fas fa-chevron-right small opacity-50"></i>
      <span>Tentang Kami</span>
    </div>
    <h1 class="subpage-title-3d">Tentang {{ setting('sekolah_nama', 'Sekolah Kami') }}</h1>
    <p class="subpage-desc-3d">
      Mengenal lebih dekat visi, sejarah, komitmen mutu, dan fasilitas unggulan dalam mencetak insan cendekia yang berdaya saing global.
    </p>
  </div>
</div>

<section class="py-5" style="background: var(--bg-light); min-height: 50vh;">
  <div class="container py-3">
    @if($halaman && $halaman->konten)
      <div class="row justify-content-center">
        <div class="col-lg-10">
          <div class="card-3d p-4 p-md-5">
            <div class="card-3d-glare"></div>
            <h2 class="section-title mb-4">{{ $halaman->judul }}</h2>
            <div class="lh-lg" style="color: #334155; font-size: 1.05rem;">{!! $halaman->konten !!}</div>
          </div>
        </div>
      </div>
    @else
      <div class="row g-4 g-lg-5 align-items-center mb-5">
        <div class="col-lg-5 reveal">
          <div class="card-3d overflow-hidden" style="border-radius: 28px; box-shadow: var(--shadow-3d); aspect-ratio: 4/4.5; background: linear-gradient(145deg, var(--brand-navy), var(--brand-blue));">
            <div class="card-3d-glare"></div>
            @if(setting_url('foto_kepsek'))
              <img src="{{ setting_url('foto_kepsek') }}" class="w-100 h-100" style="object-fit:cover;" alt="Kepala Sekolah">
            @else
              <div class="d-grid place-items-center h-100 text-white p-4 text-center">
                <i class="fas fa-school fa-5x opacity-40 mb-3"></i>
                <h4 class="fw-bold">{{ setting('sekolah_nama') }}</h4>
              </div>
            @endif
          </div>
        </div>

        <div class="col-lg-7 reveal" style="--d: 0.1s;">
          <div class="card-3d p-4 p-md-5">
            <div class="card-3d-glare"></div>
            <span class="eyebrow"><i class="fas fa-award text-warning me-1"></i> Profil Resmi</span>
            <h2 class="section-title mt-2 mb-3">{{ setting('sekolah_nama') }}</h2>
            <p class="lead fw-semibold text-primary mb-3">{{ setting('sekolah_tagline') }}</p>
            <p class="text-muted lh-lg mb-4">
              Berdiri sejak tahun {{ setting('sekolah_tahun_berdiri', '1975') }}, kami berkomitmen menghasilkan lulusan yang kompeten, berkarakter mulia, dan siap memasuki dunia industri modern maupun melanjutkan pendidikan ke jenjang yang lebih tinggi.
            </p>
            
            <div class="row g-3">
              <div class="col-sm-6">
                <div class="d-flex align-items-center gap-3 p-3 rounded-4" style="background: rgba(27, 93, 143, 0.08);">
                  <div style="width: 44px; height: 44px; border-radius: 12px; background: #fff; color: var(--brand-blue); display: grid; place-items: center; font-size: 1.2rem; box-shadow: 0 4px 10px rgba(0,0,0,0.06);">
                    <i class="fas fa-certificate"></i>
                  </div>
                  <div>
                    <strong class="d-block text-dark">Terakreditasi A</strong>
                    <span class="text-muted small">Standar Nasional</span>
                  </div>
                </div>
              </div>

              <div class="col-sm-6">
                <div class="d-flex align-items-center gap-3 p-3 rounded-4" style="background: rgba(245, 158, 11, 0.08);">
                  <div style="width: 44px; height: 44px; border-radius: 12px; background: #fff; color: #d97706; display: grid; place-items: center; font-size: 1.2rem; box-shadow: 0 4px 10px rgba(0,0,0,0.06);">
                    <i class="fas fa-id-card"></i>
                  </div>
                  <div>
                    <strong class="d-block text-dark">NPSN: {{ setting('sekolah_npsn', '-') }}</strong>
                    <span class="text-muted small">Nomor Pokok Sekolah</span>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      {{-- Sambutan Kepsek --}}
      @if(setting('sambutan_kepsek'))
      <div class="row justify-content-center">
        <div class="col-lg-10 reveal">
          <div class="card-3d p-4 p-md-5">
            <div class="card-3d-glare"></div>
            <span class="eyebrow"><i class="fas fa-quote-left text-primary me-1"></i> Sambutan Resmi</span>
            <h3 class="section-title mt-2 mb-3">Pesan Kepala Sekolah</h3>
            <blockquote class="lh-lg mb-0 text-muted fs-5 fst-italic">
              &ldquo;{!! nl2br(e(setting('sambutan_kepsek'))) !!}&rdquo;
            </blockquote>
          </div>
        </div>
      </div>
      @endif
    @endif
  </div>
</section>
@endsection
