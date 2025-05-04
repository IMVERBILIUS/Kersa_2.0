@extends('../layouts.master')

@section('content')

<!-- Navbar Section -->
<section class="position-relative">
    <nav class="navbar navbar-expand-lg bg-white py-3 position-absolute top-0 start-0 w-100 z-3">
        <div class="container">
            <div class="navbar-brand d-flex flex-column align-items-start">
                <h1 class="mb-0 fs-4 fw-semibold text-dark">KERSA</h1>
                <p class="fs-6 mb-0 text-dark">By Ankara Cipta</p>
            </div>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarContent">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link fw-medium text-dark active" href="{{ route('front.index') }}">Home</a></li>
                    <li class="nav-item"><a class="nav-link fw-medium text-dark" href="{{ route('front.articles') }}">Articles</a></li>
                    <li class="nav-item"><a class="nav-link fw-medium text-dark" href="{{ route('front.galleries') }}">Galleries</a></li>
                    <li class="nav-item"><a class="nav-link fw-medium text-dark" href="{{ route('front.contact') }}">Contact</a></li>
                </ul>
            </div>
        </div>
    </nav>
</section>

<!-- Content Section -->
<div class="container py-5 mt-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <select class="form-select w-auto" onchange="location = this.value;" style="border: 1px solid #0C2C5A; color: #0C2C5A;">
            <option value="{{ request()->url() }}?sort=latest" {{ request('sort') == 'latest' ? 'selected' : '' }}>Terbaru</option>
            <option value="{{ request()->url() }}?sort=oldest" {{ request('sort') == 'oldest' ? 'selected' : '' }}>Terlama</option>
            <option value="{{ request()->url() }}?sort=popular" {{ request('sort') == 'popular' ? 'selected' : '' }}>Terpopuler</option>
        </select>

        <h2 class="text-center flex-grow-1" style="color: #0C2C5A;">Semua Galeri</h2>
    </div>

    @forelse ($galleries as $gallery)
        <div class="card mb-4 card-hover-zoom shadow-sm">
            <div class="row g-0">
                <div class="col-md-4">
                    @if ($gallery->thumbnail)
                        <img src="{{ asset('storage/' . $gallery->thumbnail) }}" class="img-fluid h-100" alt="{{ $gallery->title }}" style="object-fit: cover;">
                    @endif
                </div>
                <div class="col-md-8">
                    <div class="card-body">
                        <h5 class="card-title fw-bold mb-1" style="color: #0C2C5A;">{{ $gallery->title }}</h5>
                        <p class="mb-1" style="color: #0C2C5A;"><strong>{{ $gallery->author }}</strong></p>
                        <p class="mb-1" style="color: #0C2C5A;">Lokasi<br><strong>{{ $gallery->location }}</strong></p>
                        <p class="mb-1" style="color: #0C2C5A;">Fungsi<br><strong>{{ $gallery->function }}</strong></p>
                        <p class="mb-2" style="color: #0C2C5A;">Luas Tanah (LT) / Luas Bangunan (LB)<br>
                            <strong>{{ $gallery->land_area }} m² / {{ $gallery->building_area }} m²</strong>
                        </p>
                        <div class="text-end mt-5">
                            <a href="{{ route('front.galleries.show', Crypt::encryptString($gallery->id)) }}" class="btn btn-sm btn-outline-primary text-custom border-custom">Detail</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @empty
        <p class="text-center" style="color: #0C2C5A;">Tidak ada galeri untuk ditampilkan.</p>
    @endforelse

    {{-- Pagination --}}
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

<style>
    body {
        color: #0C2C5A;
    }

    .pagination .page-link {
        border-radius: 50%;
        padding: 10px 15px;
        color: #0C2C5A;
        background-color: transparent;
        border: 1px solid #ddd;
        transition: background-color 0.3s ease, border-color 0.3s ease;
    }

    .pagination .page-link:hover {
        background-color: #f8f9fa;
        border-color: #b5b5b5;
    }

    .pagination .page-item.active .page-link {
        background-color: #0C2C5A;
        border-color: #0C2C5A;
        color: #fff;
    }

    .pagination .page-item.disabled .page-link {
        color: #aaa;
        pointer-events: none;
    }

    .card-hover-zoom {
        transition: transform 0.4s ease, box-shadow 0.3s ease;
    }

    .card-hover-zoom:hover {
        transform: scale(1.01);
        z-index: 2;
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
    }

    .form-select {
        color: #0C2C5A;
    }

    .btn-outline-dark {
        color: #0C2C5A;
        border-color: #0C2C5A;
    }

    .btn-outline-dark:hover {
        background-color: #0C2C5A;
        color: white;
    }
      /* Customize navbar text color and size */
      .navbar-nav .nav-link {
        font-size: 1.2rem; /* Make text larger */
        color: #343a40 !important; /* Dark gray text */
    }

    .navbar-nav .nav-link.active {
        font-weight: 600; /* Bold active link */
    }

    .navbar-brand h1,
    .navbar-brand p {
        color: #343a40; /* Dark gray text for the brand */
    }

    .navbar-nav .nav-link:hover {
        color: #6c757d; /* Slightly lighter gray on hover */
    }


    @media (max-width: 767.98px) {
        .form-select {
            width: 100%;
            margin-bottom: 1rem;
        }

        .d-flex.justify-content-between {
            flex-direction: column;
            align-items: flex-start;
        }

        h2.text-center {
            text-align: left !important;
        }

    }
</style>

@endsection
