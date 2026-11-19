@extends('layouts.public')
@section('title', $artikel->judul)
@section('page_title', $artikel->judul)
@section('meta_desc', $artikel->ringkasan_auto)

@section('content')
{{-- 3D Subpage Header --}}
<div class="subpage-hero-3d">
  <div class="subpage-hero-glow subpage-hero-glow-1" aria-hidden="true"></div>
  <div class="subpage-hero-glow subpage-hero-glow-2" aria-hidden="true"></div>
  <div class="container position-relative" style="z-index: 2;">
    <div class="subpage-breadcrumb-pill">
      <a href="{{ route('landing.index') }}"><i class="fas fa-home me-1"></i> Beranda</a>
      <i class="fas fa-chevron-right small opacity-50"></i>
      <a href="{{ route('berita.index') }}">Berita</a>
      <i class="fas fa-chevron-right small opacity-50"></i>
      <span>{{ Str::limit($artikel->judul, 30) }}</span>
    </div>
    
    <div class="mb-3">
      <span class="badge rounded-pill px-3 py-2 fw-bold" style="background: var(--brand-gold); color: #071526;">
        <i class="fas fa-tag me-1"></i> {{ $artikel->kategori_label }}
      </span>
    </div>

    <h1 class="subpage-title-3d" style="max-width: 900px;">{{ $artikel->judul }}</h1>
    
    <div class="d-flex flex-wrap align-items-center gap-3 text-white-50 mt-3" style="font-size: 0.92rem;">
      <span><i class="fas fa-user-circle text-info me-1"></i> {{ $artikel->penulis?->name ?? 'Redaksi Sekolah' }}</span>
      <span><i class="fas fa-calendar-alt text-warning me-1"></i> {{ $artikel->published_at?->translatedFormat('d F Y') }}</span>
      <span><i class="fas fa-clock text-white-50 me-1"></i> {{ $artikel->published_at?->diffForHumans() }}</span>
    </div>
  </div>
</div>

<section class="py-5" style="background: var(--bg-light); min-height: 60vh;">
  <div class="container py-3">
    <div class="row g-4 g-lg-5">
      <div class="col-lg-8">
        @if($artikel->thumbnail_url)
          <div class="card-3d overflow-hidden mb-4" style="border-radius: 26px; box-shadow: var(--shadow-3d); max-height: 440px;">
            <div class="card-3d-glare"></div>
            <img src="{{ $artikel->thumbnail_url }}" class="w-100 h-100" style="object-fit:cover;" alt="{{ $artikel->judul }}">
          </div>
        @endif

        <div class="card-3d p-4 p-md-5 mb-4">
          <div class="card-3d-glare"></div>
          @if($artikel->ringkasan)
            <div class="p-4 rounded-4 mb-4" style="background: rgba(27, 93, 143, 0.08); border-left: 4px solid var(--brand-blue);">
              <p class="lead fw-semibold text-dark mb-0" style="line-height: 1.7; font-size: 1.1rem;">
                {{ $artikel->ringkasan }}
              </p>
            </div>
          @endif
          
          <div class="lh-lg text-dark article-content" style="font-size: 1.05rem;">
            {!! $artikel->konten !!}
          </div>
        </div>

        {{-- Share Buttons --}}
        <div class="card-3d p-4 d-flex flex-wrap align-items-center justify-content-between gap-3">
          <div class="d-flex align-items-center gap-2">
            <span class="fw-bold text-dark"><i class="fas fa-share-nodes text-primary me-2"></i>Bagikan:</span>
          </div>
          <div class="d-flex flex-wrap gap-2">
            <a href="https://wa.me/?text={{ urlencode($artikel->judul . ' ' . url()->current()) }}" target="_blank"
               class="btn btn-sm btn-success rounded-pill px-3 py-2 fw-bold">
              <i class="fab fa-whatsapp me-1"></i> WhatsApp
            </a>
            <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(url()->current()) }}" target="_blank"
               class="btn btn-sm btn-primary rounded-pill px-3 py-2 fw-bold">
              <i class="fab fa-facebook-f me-1"></i> Facebook
            </a>
            <a href="https://twitter.com/intent/tweet?text={{ urlencode($artikel->judul) }}&url={{ urlencode(url()->current()) }}" target="_blank"
               class="btn btn-sm btn-dark rounded-pill px-3 py-2 fw-bold">
              <i class="fab fa-x-twitter me-1"></i> X / Twitter
            </a>
          </div>
        </div>
      </div>

      {{-- Sidebar --}}
      <div class="col-lg-4">
        @if($terkait->isNotEmpty())
        <div class="card-3d p-4 mb-4">
          <div class="card-3d-glare"></div>
          <span class="eyebrow mb-2"><i class="fas fa-newspaper text-primary me-1"></i> Terkait</span>
          <h5 class="fw-bold mb-3 text-dark">Warta Lainnya</h5>
          
          <div class="d-flex flex-column gap-3">
            @foreach($terkait as $t)
            <a href="{{ route('berita.show', $t) }}" class="d-flex gap-3 text-decoration-none text-dark p-2 rounded-3 hover-bg" style="transition: all 0.2s;">
              <div style="width: 70px; height: 60px; border-radius: 12px; overflow: hidden; flex-shrink: 0; background: rgba(27, 93, 143, 0.1); position: relative;">
                @if($t->thumbnail_url)
                  <img src="{{ $t->thumbnail_url }}" class="w-100 h-100" style="object-fit:cover;" alt="">
                @else
                  <div class="d-grid place-items-center h-100 text-muted opacity-50"><i class="far fa-newspaper"></i></div>
                @endif
              </div>
              <div>
                <h6 class="fw-bold mb-1 small lh-base text-truncate-2">{{ $t->judul }}</h6>
                <span class="text-muted" style="font-size: 0.75rem;"><i class="far fa-calendar-alt me-1"></i>{{ $t->published_at?->format('d M Y') }}</span>
              </div>
            </a>
            @endforeach
          </div>
        </div>
        @endif

        {{-- Widget PPDB --}}
        <div class="cta-banner-3d p-4 text-center">
          <div class="card-3d-glare"></div>
          <i class="fas fa-graduation-cap fa-3x text-warning mb-3"></i>
          <h5 class="fw-bold text-white mb-2">Ingin Bergabung?</h5>
          <p class="small text-white-50 mb-3">Dapatkan informasi lengkap tata cara pendaftaran peserta didik baru.</p>
          <a href="{{ route('ppdb.landing') }}" class="btn-3d-accent btn-sm w-100 py-2">
            Portal PPDB
          </a>
        </div>
      </div>
    </div>
  </div>
</section>
@endsection
