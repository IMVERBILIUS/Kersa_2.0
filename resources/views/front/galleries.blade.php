@extends('../layouts/master')

@section('content')
<section class="position-relative">
    <nav class="navbar navbar-expand-lg bg-white py-3 position-absolute top-0 start-0 w-100 z-3">
        <div class="container">
            <div class="navbar-brand d-flex flex-column align-items-start">
                <h1 class="mb-0 fs-4 fw-semibold">KERSA</h1>
                <p class="fs-6 mb-0 text-dark">By Ankara Cipta</p>
            </div>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarContent">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link fw-medium text-custom active" href="{{ route('front.index') }}">Home</a></li>
                    <li class="nav-item"><a class="nav-link fw-medium text-custom" href="{{ route('front.articles') }}">Articles</a></li>
                    <li class="nav-item"><a class="nav-link fw-medium text-custom" href="{{ route('front.galleries') }}">Galleries</a></li>
                    <li class="nav-item"><a class="nav-link fw-medium text-custom" href="{{ route('front.contact') }}">Contact</a></li>
                </ul>
            </div>
        </div>
    </nav>
</section>

<div class="container py-5 mt-5 gallery-page">

    <h2 class="mb-4 text-center fw-bold text-custom">Semua Galeri</h2>

    <div class="d-flex justify-content-end mb-4">
        <select class="form-select w-auto" onchange="location = this.value;" style="border: 1px solid #0C2C5A; color: #0C2C5A;">
            <option value="{{ request()->url() }}?sort=latest" {{ request('sort') == 'latest' ? 'selected' : '' }}>Terbaru</option>
            <option value="{{ request()->url() }}?sort=oldest" {{ request('sort') == 'oldest' ? 'selected' : '' }}>Terlama</option>
            <option value="{{ request()->url() }}?sort=popular" {{ request('sort') == 'popular' ? 'selected' : '' }}>Terpopuler</option>
        </select>
    </div>

    @forelse ($galleries as $gallery)
    <div class="row bg-white shadow-sm p-2 mb-4 overflow-hidden border">
        <div class="col-md-5 p-0 border">
            <img src="{{ asset('storage/' . $gallery->thumbnail) }}" alt="{{ $gallery->title }}" class="img-fluid w-100 h-100 object-fit-cover">
        </div>
        <div class="col-md-7 p-4 d-flex flex-column justify-content-between text-custom">
            <h4 class="fw-bold mb-2 border-bottom pb-2">{{ $gallery->title }}</h4>
            <div>
                <p class="mb-2 fs-5"><strong>{{ $gallery->author }}</strong></p>
                <p class="mb-2 fs-6">Lokasi<br><strong>{{ $gallery->location }}</strong></p>
                <p class="mb-2 fs-6">Fungsi<br><strong>{{ $gallery->function }}</strong></p>
                <p class="mb-2 fs-6">
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

    <div class="mt-4 d-flex justify-content-center">
        <ul class="pagination">
            {{-- Previous --}}
            @if ($galleries->onFirstPage())
                <li class="page-item disabled"><span class="page-link btn btn-outline-dark">&laquo;</span></li>
            @else
                <li class="page-item"><a class="page-link btn btn-outline-dark" href="{{ $galleries->previousPageUrl() }}" rel="prev">&laquo;</a></li>
            @endif

            @php
                $currentPage = $galleries->currentPage();
                $lastPage = $galleries->lastPage();
                $pageRange = 5;
                $startPage = max(1, $currentPage - floor($pageRange / 2));
                $endPage = min($lastPage, $currentPage + floor($pageRange / 2));
                if ($currentPage < floor($pageRange / 2)) {
                    $endPage = min($lastPage, $pageRange);
                }
                if ($currentPage > $lastPage - floor($pageRange / 2)) {
                    $startPage = max(1, $lastPage - $pageRange + 1);
                }
            @endphp

            @for ($i = $startPage; $i <= $endPage; $i++)
                <li class="page-item {{ $i == $currentPage ? 'active' : '' }}">
                    <a class="page-link btn btn-outline-dark" href="{{ $galleries->url($i) }}">{{ $i }}</a>
                </li>
            @endfor

            {{-- Next --}}
            @if ($galleries->hasMorePages())
                <li class="page-item"><a class="page-link btn btn-outline-dark" href="{{ $galleries->nextPageUrl() }}" rel="next">&raquo;</a></li>
            @else
                <li class="page-item disabled"><span class="page-link btn btn-outline-dark">&raquo;</span></li>
            @endif
        </ul>
    </div>
</div>
@endsection

@push('styles')
<style>

.gallery-page {
    --text-color: #0C2C5A;
}

.gallery-page h1,
.gallery-page p,
.gallery-page a:not(.page-link):not(.btn-outline-dark),
.gallery-page .text-custom {
    color: var(--text-color) !important;
}

.gallery-page .btn:not(.btn-outline-dark):hover {
    background-color: var(--text-color) !important;
    color: #fff !important;
}

.gallery-page .border-custom {
    border-color: var(--text-color) !important;
}

.gallery-page .object-fit-cover {
    object-fit: cover;
    height: 100%;
}

</style>
@endpush
