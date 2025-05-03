@extends('../layouts/master')

@section('content')
<div class="container py-5">
    <h2 class="mb-4 text-center fw-bold text-custom">Semua Galeri</h2>

    <div class="d-flex justify-content-end mb-4">
        <select class="form-select w-auto text-custom border-custom" name="sort_by" id="sort_by">
            <option selected disabled>Short by:</option>
            <option value="latest">Terbaru</option>
            <option value="oldest">Terlama</option>
        </select>
    </div>

    @forelse ($galleries as $gallery)
    <div class="row bg-white shadow-sm rounded-3 mb-4 overflow-hidden border">
        <div class="col-md-5 p-0">
            <img src="{{ asset('storage/' . $gallery->thumbnail) }}" alt="{{ $gallery->title }}" class="img-fluid w-100 h-100 object-fit-cover">
        </div>
        <div class="col-md-7 p-4 d-flex flex-column justify-content-between text-custom">
            <div>
                <h4 class="fw-bold mb-2">{{ $gallery->title }}</h4>
                <p class="mb-1"><strong>{{ $gallery->author }}</strong></p>
                <p class="mb-1">Lokasi<br><strong>{{ $gallery->location }}</strong></p>
                <p class="mb-1">Fungsi<br><strong>{{ $gallery->function }}</strong></p>
                <p class="mb-1">
                    Luas Tanah (LT) / Luas Bangunan (LB)<br>
                    <strong>{{ $gallery->land_area }} m² / {{ $gallery->building_area }} m²</strong>
                </p>
            </div>
            <div class="text-end mt-3">
                <a href="{{ route('front.galleries.show', Crypt::encryptString($gallery->id)) }}" class="btn btn-sm btn-outline-primary text-custom border-custom">Detail</a>
            </div>
        </div>
    </div>
    @empty
        <p class="text-center text-custom">Tidak ada galeri untuk ditampilkan.</p>
    @endforelse

    <div class="mt-4 d-flex justify-content-center text-custom">
        {{ $galleries->links('pagination::bootstrap-5') }}
    </div>
</div>
@endsection

@push('styles')
<style>
    .text-custom {
        color: #0C2C5A !important;
    }
    .border-custom {
        border-color: #0C2C5A !important;
    }
    .object-fit-cover {
        object-fit: cover;
        height: 100%;
    }
</style>
@endpush
