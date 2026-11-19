@extends('layouts.public')
@section('title', $galeri->nama . ' — Galeri')
@section('page_title', 'Galeri')

@push('styles')
<style>
  .galeri-photo-card {
    cursor: pointer;
    overflow: hidden;
    border-radius: 20px;
    box-shadow: 0 8px 25px rgba(11, 34, 61, 0.08);
    position: relative;
    aspect-ratio: 1 / 1;
    background: #e2e8f0;
    transition: transform 0.35s ease, box-shadow 0.35s ease;
  }
  .galeri-photo-card img {
    transition: transform .5s cubic-bezier(0.16, 1, 0.3, 1);
    width: 100%;
    height: 100%;
    object-fit: cover;
    display: block;
  }
  .galeri-photo-card:hover {
    transform: translateY(-5px) scale(1.02);
    box-shadow: 0 20px 40px -10px rgba(11, 34, 61, 0.22);
  }
  .galeri-photo-card:hover img {
    transform: scale(1.08);
  }
  .galeri-photo-overlay {
    position: absolute;
    inset: 0;
    background: linear-gradient(to top, rgba(7, 21, 38, 0.7) 0%, transparent 60%);
    opacity: 0;
    transition: opacity 0.3s ease;
    display: flex;
    align-items: flex-end;
    padding: 1rem;
    color: #fff;
  }
  .galeri-photo-card:hover .galeri-photo-overlay {
    opacity: 1;
  }
  /* Lightbox 3D Backdrop */
  #lightbox {
    display:none;
    position:fixed;
    inset:0;
    background:rgba(7, 21, 38, 0.94);
    backdrop-filter: blur(14px);
    z-index:9999;
    align-items:center;
    justify-content:center;
    transition: all 0.3s ease;
  }
  #lightbox.show { display:flex; }
  #lightbox img {
    max-width:92vw;
    max-height:88vh;
    border-radius:18px;
    box-shadow: 0 30px 80px rgba(0, 0, 0, 0.6);
  }
  #lightbox .lb-close {
    position:absolute; top:24px; right:28px; color:#fff; font-size:2.2rem;
    cursor:pointer; line-height:1; transition: transform 0.2s;
  }
  #lightbox .lb-close:hover { transform: scale(1.15); color: var(--brand-cyan); }
  #lightbox .lb-nav {
    position:absolute; top:50%; transform:translateY(-50%); color:#fff;
    font-size:1.8rem; cursor:pointer; width: 56px; height: 56px;
    display: grid; place-items: center; background:rgba(255,255,255,.12);
    backdrop-filter: blur(8px); border-radius:50%; transition: all 0.2s;
    border: 1px solid rgba(255, 255, 255, 0.2);
  }
  #lightbox .lb-nav:hover { background: var(--brand-blue); transform: translateY(-50%) scale(1.1); }
  #lightbox .lb-prev { left:20px; }
  #lightbox .lb-next { right:20px; }
</style>
@endpush

@section('content')
{{-- 3D Subpage Header --}}
<div class="subpage-hero-3d">
  <div class="subpage-hero-glow subpage-hero-glow-1" aria-hidden="true"></div>
  <div class="subpage-hero-glow subpage-hero-glow-2" aria-hidden="true"></div>
  <div class="container position-relative" style="z-index: 2;">
    <div class="subpage-breadcrumb-pill">
      <a href="{{ route('landing.index') }}"><i class="fas fa-home me-1"></i> Beranda</a>
      <i class="fas fa-chevron-right small opacity-50"></i>
      <a href="{{ route('galeri.index') }}">Galeri</a>
      <i class="fas fa-chevron-right small opacity-50"></i>
      <span>{{ $galeri->nama }}</span>
    </div>
    
    <h1 class="subpage-title-3d">{{ $galeri->nama }}</h1>
    
    <div class="d-flex flex-wrap align-items-center gap-3 text-white-50 mt-2" style="font-size: 0.92rem;">
      <span><i class="far fa-calendar-alt text-warning me-1"></i> {{ $galeri->tanggal->translatedFormat('d F Y') }}</span>
      <span>&bull;</span>
      <span><i class="fas fa-camera text-info me-1"></i> {{ $galeri->items->count() }} Dokumentasi Foto</span>
    </div>
  </div>
</div>

<section class="py-5" style="background: var(--bg-light); min-height: 60vh;">
  <div class="container py-3">
    @if($galeri->deskripsi)
      <div class="card-3d p-4 mb-4" style="border-radius: 20px;">
        <div class="card-3d-glare"></div>
        <p class="text-muted mb-0 lh-lg fs-5">{{ $galeri->deskripsi }}</p>
      </div>
    @endif

    <div class="row g-3 g-md-4" id="galeriGrid">
      @forelse($galeri->items as $i => $item)
      <div class="col-6 col-md-4 col-lg-3 reveal" style="--d:{{ ($i % 4) * 0.05 }}s">
        <div class="galeri-photo-card" data-index="{{ $i }}" onclick="openLightbox({{ $i }})">
          <img src="{{ $item->foto_url }}" alt="{{ $item->keterangan ?? '' }}" loading="lazy">
          <div class="galeri-photo-overlay">
            <span class="small fw-semibold text-truncate">{{ $item->keterangan ?? 'Klik untuk memperbesar' }}</span>
          </div>
        </div>
      </div>
      @empty
        <div class="col-12 text-center py-5 text-muted">
          <i class="far fa-images fa-4x mb-3 d-block opacity-25"></i>
          Belum ada foto dalam album ini.
        </div>
      @endforelse
    </div>
  </div>
</section>

{{-- Lightbox modal --}}
<div id="lightbox" role="dialog" aria-modal="true" aria-label="Tampilan foto">
  <span class="lb-close" onclick="closeLightbox()">&times;</span>
  <div class="lb-nav lb-prev" onclick="navLightbox(-1)"><i class="fas fa-chevron-left"></i></div>
  <img id="lbImg" src="" alt="">
  <div class="lb-nav lb-next" onclick="navLightbox(1)"><i class="fas fa-chevron-right"></i></div>
</div>
@endsection

@push('scripts')
<script>
  const items = @json($galeri->items->map(fn($it) => ['url' => $it->foto_url, 'cap' => $it->keterangan ?? '']));
  let currentIdx = 0;
  const lb = document.getElementById('lightbox');
  const lbImg = document.getElementById('lbImg');

  function openLightbox(idx) {
    if (!items.length) return;
    currentIdx = idx;
    lbImg.src = items[idx].url;
    lb.classList.add('show');
    document.body.style.overflow = 'hidden';
  }
  function closeLightbox() {
    lb.classList.remove('show');
    document.body.style.overflow = '';
  }
  function navLightbox(dir) {
    currentIdx = (currentIdx + dir + items.length) % items.length;
    lbImg.src = items[currentIdx].url;
  }
  document.addEventListener('keydown', e => {
    if (!lb.classList.contains('show')) return;
    if (e.key === 'Escape') closeLightbox();
    if (e.key === 'ArrowLeft') navLightbox(-1);
    if (e.key === 'ArrowRight') navLightbox(1);
  });
  lb.addEventListener('click', e => { if (e.target === lb) closeLightbox(); });
</script>
@endpush
