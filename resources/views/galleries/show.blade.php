@extends('layouts.app')

@section('content')
<div class="container py-4" style="font-family: 'Poppins', sans-serif; background-color: #F8F8FF;">

    <!-- Tombol Kembali -->
    <div class="d-flex justify-content-start mb-4 mt-4">
        <a href="{{ route('admin.galleries.manage') }}" class="btn px-4 py-2 " 
           style="background-color: #F0F5FF; color: #0C2C5A; font-weight: 600; border-radius: 8px; border: 1px solid #0c2c5a8d;">
            <i class="fas fa-arrow-left me-2"></i> Kembali
        </a>
    </div>

    <!-- Judul Proyek -->
    <h3 class="fw-bold mb-4" style="color: #0C2C5A;">{{ $gallery->title }} </h3>

    <!-- Gambar Utama dan Info -->
    <div class="row mb-4">
        <div class="col-md-8">
            @if($gallery->thumbnail)
                <img src="{{ asset('storage/' . $gallery->thumbnail) }}" 
                     class="img-fluid rounded shadow-sm" 
                     style="width: 100%; height: 400px; object-fit: cover;" 
                     alt="Thumbnail">
            @endif
        </div>
       <div class="col-md-4">
    <div class="card p-4 shadow-sm border-0" style="border-radius: 12px; font-family: 'Poppins', sans-serif;">
        <!-- Author Info -->
        <div class=" mb-4">
            <div class="fw-semibold" style="font-size: 1.1rem; color: #0C2C5A;">{{ $gallery->author }}</div>
            <small class="text-muted">Author</small>
        </div>
        <hr>

        <!-- Project Info -->
        <div class="mb-3">
            <small class="text-muted d-block mb-1">Lokasi</small>
            <div class="fw-semibold " style="font-size: 1rem; color: #0C2C5A;">{{ $gallery->location }}</div>
        </div>

        <div class="mb-3">
            <small class="text-muted d-block mb-1">Fungsi</small>
            <div class="fw-semibold " style="font-size: 1rem; color: #0C2C5A;">{{ $gallery->function }}</div>
        </div>

        <div class="mb-3">
            <small class="text-muted d-block mb-1">Luas Tanah (LT)</small>
            <div class="fw-semibold " style="font-size: 1rem; color: #0C2C5A;">{{ $gallery->land_area }} m²</div>
        </div>

        <div>
            <small class="text-muted d-block mb-1">Luas Bangunan (LB)</small>
            <div class="fw-semibold " style="font-size: 1rem; color: #0C2C5A;">{{ $gallery->building_area }} m²</div>
        </div>
    </div>
</div>

    </div>
    <!-- Galeri Gambar -->
        @if ($gallery->images->count())
        <div class="d-flex overflow-auto flex-nowrap gap-3 mb-4 px-1">
            @foreach ($gallery->images as $image)
                <div class="flex-shrink-0" style="width: calc(100% / 7.6);">
                    <img src="{{ asset('storage/' . $image->image) }}" 
                        class="img-fluid rounded shadow-sm" 
                        style="height: 140px; object-fit: cover; width: 100%;">
                </div>
            @endforeach
        </div>
        @endif

    <!-- Deskripsi -->
    <div class="card shadow-sm p-4 mb-4 border-0" style="border-radius: 12px;">
        <p class="text-justify mb-0" style="line-height: 1.8; color: #0C2C5A;">{{ $gallery->description }}</p>
    </div>

    <!-- Konten Tambahan -->
    @foreach ($gallery->subtitles->sortBy('order_number') as $subtitle)
        <div class="card shadow-sm p-4 mb-4 border-0" style="border-radius: 12px;">
            <h5 class="fw-bold" style="color: #0C2C5A;">{{ $subtitle->order_number }}. {{ $subtitle->subtitle }}</h5>
            @foreach ($subtitle->contents->sortBy('order_number') as $content)
                <p class="text-justify mb-0" style="line-height: 1.8; color: #0C2C5A    ;">{{ $content->content }}</p>
            @endforeach
        </div>
    @endforeach

  
</div>
@endsection
