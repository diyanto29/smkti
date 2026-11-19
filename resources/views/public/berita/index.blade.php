@extends('layouts.public')
@section('title', 'Berita & Pengumuman')
@section('page_title', 'Berita')

@section('content')
{{-- 3D Subpage Header --}}
<div class="subpage-hero-3d">
  <div class="subpage-hero-glow subpage-hero-glow-1" aria-hidden="true"></div>
  <div class="subpage-hero-glow subpage-hero-glow-2" aria-hidden="true"></div>
  <div class="container position-relative" style="z-index: 2;">
    <div class="subpage-breadcrumb-pill">
      <a href="{{ route('landing.index') }}"><i class="fas fa-home me-1"></i> Beranda</a>
      <i class="fas fa-chevron-right small opacity-50"></i>
      <span>Berita &amp; Pengumuman</span>
    </div>
    <h1 class="subpage-title-3d">Warta &amp; Informasi Kampus</h1>
    <p class="subpage-desc-3d">
      Liputan kegiatan akademik, pengumuman kedinasan, prestasi siswa, dan agenda resmi {{ setting('sekolah_nama') }}.
    </p>
  </div>
</div>

<section class="py-5" style="background: var(--bg-light); min-height: 60vh;">
  <div class="container py-3">
    <div class="row g-4 g-lg-5">
      
      {{-- Main content: Articles Grid / List --}}
      <div class="col-lg-8">
        {{-- Category filter pills --}}
        <div class="d-flex flex-wrap gap-2 mb-4">
          <a href="{{ route('berita.index') }}"
             class="btn btn-sm rounded-pill px-3 py-2 fw-bold {{ !request('kategori') ? 'btn-3d-primary' : 'btn-3d-glass' }}">
            Semua Kategori
          </a>
          @foreach(\App\Models\Artikel::KATEGORI as $k => $v)
            <a href="{{ route('berita.index', ['kategori' => $k]) }}"
               class="btn btn-sm rounded-pill px-3 py-2 fw-bold {{ request('kategori') == $k ? 'btn-3d-primary' : 'btn-3d-glass' }}">
              {{ $v }}
            </a>
          @endforeach
        </div>

        {{-- Form search --}}
        <form method="GET" action="{{ route('berita.index') }}" class="mb-4">
          @if(request('kategori'))
            <input type="hidden" name="kategori" value="{{ request('kategori') }}">
          @endif
          <div class="input-group shadow-sm" style="border-radius: 999px; overflow: hidden; background: #fff; border: 1px solid rgba(226, 232, 240, 0.9);">
            <span class="input-group-text bg-transparent border-0 ps-4 text-muted"><i class="fas fa-search"></i></span>
            <input type="text" name="q" class="form-control border-0 py-3 shadow-none" value="{{ request('q') }}" placeholder="Ketik kata kunci berita atau pengumuman...">
            <button type="submit" class="btn btn-3d-primary px-4 my-1 me-1">Cari</button>
          </div>
        </form>

        {{-- Articles List --}}
        <div class="d-flex flex-column gap-4">
          @forelse($artikels as $a)
          <article class="news-card-3d card-3d">
            <div class="card-3d-glare"></div>
            <div class="row g-0 align-items-center">
              <div class="col-md-5">
                <div class="news-img-box" style="height: 100%; min-height: 200px; border-radius: 20px 0 0 20px;">
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
              </div>
              
              <div class="col-md-7">
                <div class="p-4 d-flex flex-column h-100">
                  <div class="news-date">
                    <i class="far fa-clock text-primary"></i>
                    <span>{{ $a->published_at?->translatedFormat('d F Y') ?? $a->created_at->translatedFormat('d F Y') }}</span>
                  </div>
                  <h4 class="fw-bold mb-2">
                    <a href="{{ route('berita.show', $a) }}" class="text-decoration-none text-dark hover-primary" style="transition: color 0.2s;">
                      {{ $a->judul }}
                    </a>
                  </h4>
                  <p class="text-muted small lh-lg mb-3 flex-grow-1">{{ $a->ringkasan_auto }}</p>
                  
                  <div>
                    <a href="{{ route('berita.show', $a) }}" class="btn-3d-glass btn-sm py-2 px-3">
                      <span>Baca Selengkapnya</span>
                      <i class="fas fa-arrow-right ms-1"></i>
                    </a>
                  </div>
                </div>
              </div>
            </div>
          </article>
          @empty
            <div class="card-3d p-5 text-center text-muted">
              <i class="fas fa-newspaper fa-4x mb-3 d-block opacity-25"></i>
              <h5 class="fw-bold">Belum ada artikel ditemukan.</h5>
              <p class="small">Silakan coba kata kunci lain atau pilih kategori yang berbeda.</p>
            </div>
          @endforelse
        </div>

        <div class="mt-4 pt-2">
          {{ $artikels->links() }}
        </div>
      </div>

      {{-- Sidebar --}}
      <div class="col-lg-4">
        <div class="card-3d p-4 mb-4">
          <div class="card-3d-glare"></div>
          <span class="eyebrow mb-2"><i class="fas fa-bolt text-warning me-1"></i> Terbaru</span>
          <h5 class="fw-bold mb-3" style="color:var(--brand-dark)">Warta Paling Baru</h5>
          
          <div class="d-flex flex-column gap-3">
            @foreach($terbaru as $t)
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
                  <span class="text-muted" style="font-size: 0.75rem;"><i class="far fa-calendar-alt me-1"></i>{{ $t->published_at?->translatedFormat('d M Y') }}</span>
                </div>
              </a>
            @endforeach
          </div>
        </div>

        {{-- Widget PPDB Banner --}}
        <div class="cta-banner-3d p-4 text-center">
          <div class="card-3d-glare"></div>
          <i class="fas fa-graduation-cap fa-3x text-warning mb-3"></i>
          <h5 class="fw-bold text-white mb-2">Penerimaan Siswa Baru</h5>
          <p class="small text-white-50 mb-3">Bergabunglah menjadi bagian dari generasi vokasi unggulan.</p>
          <a href="{{ route('ppdb.landing') }}" class="btn-3d-accent btn-sm w-100 py-2">
            Informasi PPDB
          </a>
        </div>
      </div>

    </div>
  </div>
</section>
@endsection
