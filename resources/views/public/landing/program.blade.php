@extends('layouts.public')
@section('title', 'Program Keahlian')
@section('page_title', 'Program Keahlian')

@section('content')
{{-- 3D Subpage Header --}}
<div class="subpage-hero-3d">
  <div class="subpage-hero-glow subpage-hero-glow-1" aria-hidden="true"></div>
  <div class="subpage-hero-glow subpage-hero-glow-2" aria-hidden="true"></div>
  <div class="container position-relative" style="z-index: 2;">
    <div class="subpage-breadcrumb-pill">
      <a href="{{ route('landing.index') }}"><i class="fas fa-home me-1"></i> Beranda</a>
      <i class="fas fa-chevron-right small opacity-50"></i>
      <span>Program Keahlian</span>
    </div>
    <h1 class="subpage-title-3d">Program Keahlian Unggulan</h1>
    <p class="subpage-desc-3d">
      Tersedia {{ $jurusans->count() }} program kejuruan berbasis kompetensi industri masa depan, dilengkapi laboratorium dan bengkel kerja standar industri.
    </p>
  </div>
</div>

<section class="py-5" style="background: var(--bg-light); min-height: 50vh;">
  <div class="container py-3">
    <div class="row g-4 g-lg-5">
      @forelse($jurusans as $j)
      <div class="col-md-6 col-lg-4 reveal" style="--d:{{ ($loop->index % 3) * 0.08 }}s">
        <div class="card-3d h-100 d-flex flex-column" style="background:#fff; border-radius: 26px; border: 1px solid rgba(226, 232, 240, 0.9); box-shadow: var(--shadow-3d); overflow: hidden;">
          <div class="card-3d-glare"></div>
          
          {{-- Header Image / Icon Banner --}}
          @if($j->gambar)
            <div style="height: 200px; position: relative; overflow: hidden;">
              <img src="{{ asset('storage/' . $j->gambar) }}" class="w-100 h-100" style="object-fit:cover; transition: transform 0.5s ease;" alt="{{ $j->nama_jurusan }}">
              <div style="position: absolute; inset: 0; background: linear-gradient(to top, rgba(7, 21, 38, 0.8) 0%, transparent 60%);"></div>
              <div style="position: absolute; bottom: 14px; left: 16px; color: #fff; font-weight: 800; font-size: 1.1rem;">
                {{ $j->nama_jurusan }}
              </div>
            </div>
          @else
            <div style="height: 160px; background: linear-gradient(135deg, var(--brand-navy) 0%, var(--brand-blue) 100%); display: flex; align-items: center; justify-content: center; position: relative; overflow: hidden;">
              <div style="position: absolute; width: 140px; height: 140px; border-radius: 50%; background: radial-gradient(circle, rgba(6, 182, 212, 0.3), transparent 70%);"></div>
              <i class="{{ $j->icon ?? 'fas fa-laptop-code' }}" style="font-size: 3.5rem; color: rgba(255, 255, 255, 0.7); position: relative; z-index: 1;"></i>
            </div>
          @endif

          <div class="p-4 d-flex flex-column flex-grow-1">
            <div class="d-flex align-items-center justify-content-between mb-3">
              <div style="width: 48px; height: 48px; border-radius: 14px; background: rgba(27, 93, 143, 0.1); color: var(--brand-blue); display: grid; place-items: center; font-size: 1.3rem;">
                <i class="{{ $j->icon ?? 'fas fa-graduation-cap' }}"></i>
              </div>
              <span class="badge rounded-pill px-3 py-2" style="background: rgba(6, 182, 212, 0.12); color: #0284c7; font-weight: 700; font-size: 0.78rem;">
                Kurikulum Industri
              </span>
            </div>

            <h4 class="fw-bold mb-2 text-dark" style="letter-spacing: -0.02em;">{{ $j->nama_jurusan }}</h4>
            
            <p class="text-muted small lh-lg flex-grow-1" style="font-size: 0.92rem;">
              @if($j->deskripsi_publik)
                {{ $j->deskripsi_publik }}
              @else
                Mempersiapkan tenaga terampil dan bersertifikasi di bidang {{ strtolower($j->nama_jurusan) }} dengan penguasaan alat kerja modern dan praktik lapangan intensif.
              @endif
            </p>

            <div class="pt-3 border-top mt-3 d-flex align-items-center justify-content-between">
              @if($j->is_aktif_ppdb && setting('ppdb_aktif') == '1')
                <a href="{{ route('ppdb.index') }}?jurusan={{ $j->id }}" class="btn-3d-accent btn-sm px-3 py-2">
                  <i class="fas fa-file-signature me-1"></i> Daftar Jurusan Ini
                </a>
              @else
                <span class="text-muted small fw-semibold"><i class="fas fa-check-circle text-success me-1"></i> Siap Kerja &amp; Wirausaha</span>
              @endif
              <a href="{{ route('landing.program') }}" class="btn btn-sm btn-outline-primary rounded-pill px-3 py-1">
                Detail <i class="fas fa-arrow-right ms-1"></i>
              </a>
            </div>
          </div>
        </div>
      </div>
      @empty
        <div class="col-12 text-center py-5 text-muted">
          <i class="fas fa-graduation-cap fa-3x mb-3 d-block opacity-25"></i>
          Program keahlian belum tersedia.
        </div>
      @endforelse
    </div>
  </div>
</section>
@endsection
