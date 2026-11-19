@extends('layouts.public')
@section('title', $halaman->judul)
@section('page_title', $halaman->judul)
@section('meta_desc', $halaman->meta_desc ?? '')

@section('content')
{{-- 3D Subpage Header --}}
<div class="subpage-hero-3d">
  <div class="subpage-hero-glow subpage-hero-glow-1" aria-hidden="true"></div>
  <div class="subpage-hero-glow subpage-hero-glow-2" aria-hidden="true"></div>
  <div class="container position-relative" style="z-index: 2;">
    <div class="subpage-breadcrumb-pill">
      <a href="{{ route('landing.index') }}"><i class="fas fa-home me-1"></i> Beranda</a>
      <i class="fas fa-chevron-right small opacity-50"></i>
      <span>{{ $halaman->judul }}</span>
    </div>
    <h1 class="subpage-title-3d">{{ $halaman->judul }}</h1>
  </div>
</div>

<section class="py-5" style="background: var(--bg-light); min-height: 60vh;">
  <div class="container py-3">
    <div class="row justify-content-center">
      <div class="col-lg-10">
        <div class="card-3d p-4 p-md-5">
          <div class="card-3d-glare"></div>
          <div class="lh-lg text-dark article-content" style="font-size: 1.05rem;">
            {!! $halaman->konten !!}
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
@endsection
