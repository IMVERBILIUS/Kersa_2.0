@extends('layouts.app')

@section('content')
<div class="container py-4">
    {{-- Tombol Kembali --}}
    <a href="{{ route('admin.galleries.manage') }}" class="btn btn-light mb-4">
        <i class="bi bi-arrow-left"></i> Kembali
    </a>

    {{-- Judul --}}
    <h2 class="fw-bold mb-4">{{ $gallery->title }} <span class="text-muted">( Nama proyek )</span></h2>

    {{-- Thumbnail dan Info --}}
    <div class="row mb-4">
        <div class="col-md-8">
            @if($gallery->thumbnail)
                <img src="{{ asset('storage/' . $gallery->thumbnail) }}" class="img-fluid rounded shadow-sm" style="width: 100%; height: 400px; object-fit: cover;" alt="Thumbnail">
            @endif
        </div>
        <div class="col-md-4">
            <div class="card shadow-sm p-3">
                <div class="d-flex align-items-center mb-3">
                    <i class="bi bi-person-circle fs-3 me-2"></i>
                    <div>
                        <small class="fw-bold">Author</small>
                        <div class="text-muted">{{ $gallery->author }}</div>
                    </div>
                </div>
                <hr>
                <p><strong>( Lokasi )</strong><br><span class="text-muted">{{ $gallery->location }}</span></p>
                <p><strong>( Fungsi )</strong><br><span class="text-muted">{{ $gallery->function }}</span></p>
                <p><strong>LT {{ $gallery->land_area }} m² / LB {{ $gallery->building_area }} m²</strong></p>
            </div>
        </div>
    </div>

    {{-- Galeri Gambar --}}
    @if ($gallery->images->count())
    <div class="d-flex overflow-auto gap-3 mb-4">
        @foreach ($gallery->images as $image)
            <img src="{{ asset('storage/' . $image->image) }}" class="rounded shadow-sm" style="height: 90px; width: 140px; object-fit: cover;">
        @endforeach
    </div>
    @endif

    {{-- Deskripsi --}}
    <div class="card shadow-sm p-4 mb-4">
        <p class="text-muted text-justify mb-0">{{ $gallery->description }}</p>
    </div>

    {{-- Konten --}}
    @foreach ($gallery->subtitles->sortBy('order_number') as $subtitle)
        <div class="card shadow-sm p-4 mb-4">
            <h5 class="fw-bold">{{ $subtitle->order_number }}. {{ $subtitle->subtitle }}</h5>
            @foreach ($subtitle->contents->sortBy('order_number') as $content)
                <p class="text-justify mb-0">{{ $content->content }}</p>
            @endforeach
        </div>
    @endforeach
</div>
@endsection
