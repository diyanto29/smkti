@extends('layouts.public')
@section('title', 'Galeri Foto')
@section('page_title', 'Galeri')

@section('content')
{{-- 3D Subpage Header --}}
<div class="subpage-hero-3d">
  <div class="subpage-hero-glow subpage-hero-glow-1" aria-hidden="true"></div>
  <div class="subpage-hero-glow subpage-hero-glow-2" aria-hidden="true"></div>
  <div class="container position-relative" style="z-index: 2;">
    <div class="subpage-breadcrumb-pill">
      <a href="{{ route('landing.index') }}"><i class="fas fa-home me-1"></i> Beranda</a>
      <i class="fas fa-chevron-right small opacity-50"></i>
      <span>Galeri Foto</span>
    </div>
    <h1 class="subpage-title-3d">Galeri Momen &amp; Aktivitas</h1>
    <p class="subpage-desc-3d">
      Dokumentasi visual kegiatan belajar mengajar, sarana prasarana, kompetisi, ekstrakurikuler, dan momentum bersejarah {{ setting('sekolah_nama') }}.
    </p>
  </div>
</div>

<section class="py-5" style="background: var(--bg-light); min-height: 60vh;">
  <div class="container py-3">
    <div class="row g-4 g-lg-5">
      @forelse($galeris as $g)
      <div class="col-md-6 col-lg-4 reveal" style="--d:{{ ($loop->index % 3) * 0.08 }}s">
        <a href="{{ route('galeri.show', $g) }}" class="text-decoration-none">
          <div class="card-3d h-100 overflow-hidden" style="border-radius: 24px; box-shadow: var(--shadow-3d); background: #fff;">
            <div class="card-3d-glare"></div>
            
            <div style="position:relative; overflow:hidden; aspect-ratio: 16 / 10; min-height: 200px; background: linear-gradient(135deg, #e8f0f7, #f1f5f9);">
              @if($g->cover_url)
                <img src="{{ $g->cover_url }}" class="w-100 h-100" style="object-fit:cover; transition: transform 0.6s ease;" alt="{{ $g->nama }}">
              @else
                <div class="d-grid place-items-center h-100 text-muted opacity-40">
                  <i class="far fa-images fa-3x"></i>
                </div>
              @endif
              
              {{-- Floating Photos Count Badge --}}
              <div style="position:absolute; top: 14px; right: 14px; background: rgba(7, 21, 38, 0.75); backdrop-filter: blur(8px); border-radius: 999px; padding: 0.35rem 0.85rem; color: #fff; font-size: 0.78rem; font-weight: 700; border: 1px solid rgba(255, 255, 255, 0.2);">
                <i class="fas fa-camera me-1 text-warning"></i> {{ $g->items_count }} Foto
              </div>

              {{-- Gradient Overlay --}}
              <div style="position:absolute; inset:auto 0 0 0; background: linear-gradient(to top, rgba(7, 21, 38, 0.85) 0%, transparent 100%); padding: 2rem 1.25rem 0.85rem; color: #fff;">
                <span class="small opacity-80"><i class="far fa-calendar-alt me-1"></i> {{ $g->tanggal->translatedFormat('d F Y') }}</span>
              </div>
            </div>

            <div class="p-4">
              <h5 class="fw-bold mb-2 text-dark" style="letter-spacing: -0.02em;">{{ $g->nama }}</h5>
              @if($g->deskripsi)
                <p class="text-muted small mb-3 lh-lg">{{ Str::limit($g->deskripsi, 90) }}</p>
              @endif
              
              <div class="d-inline-flex align-items-center gap-2 fw-bold small text-primary">
                <span>Buka Album</span>
                <i class="fas fa-arrow-right"></i>
              </div>
            </div>

          </div>
        </a>
      </div>
      @empty
        <div class="col-12 text-center py-5 text-muted">
          <i class="far fa-images fa-4x mb-3 d-block opacity-25"></i>
          <h5 class="fw-bold">Belum ada album galeri foto.</h5>
        </div>
      @endforelse
    </div>
  </div>
</section>
@endsection
