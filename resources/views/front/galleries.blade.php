@extends('../layouts/master')

@section('content')
<section class="position-relative">
    <nav class="navbar navbar-expand-lg bg-white py-3 position-absolute top-0 start-0 w-100 z-3">
        <div class="container">
            <div class="navbar-brand d-flex flex-column align-items-start">
                <h1 class="mb-0 fs-4 fw-semibold  ">KERSA</h1>
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
                    <li class="nav-item"><a class="nav-link fw-medium text-custom " href="{{ route('front.contact') }}">Contact</a></li>
                </ul>
            </div>
        </div>
    </nav>
</section>
<div class="container py-5 mt-5">

    

    <h2 class="mb-4 text-center fw-bold text-custom">Semua Galeri</h2>

    <div class="d-flex justify-content-end mb-4">
        <select class="form-select w-auto text-custom border-custom" name="sort_by" id="sort_by">
            <option selected disabled>Short by:</option>
            <option value="latest">Terbaru</option>
            <option value="oldest">Terlama</option>
        </select>
    </div>

    @forelse ($galleries as $gallery)
    <div class="row bg-white shadow-sm p-2 mb-4 overflow-hidden border ">
        <div class="col-md-5 p-0 border">
            <img src="{{ asset('storage/' . $gallery->thumbnail) }}" alt="{{ $gallery->title }}" class="img-fluid w-100 h-100 object-fit-cover">
        </div>
        <div class="col-md-7 p-4 d-flex flex-column justify-content-between text-custom ">
                <h4 class="fw-bold mb-2 border-bottom pb-2">{{ $gallery->title }}</h4>
                <div class="">
                    <p class="mb-2 fs-5"><strong>{{ $gallery->author }}</strong></p>
                    <p class="mb-2 fs-6">Lokasi<br><strong>{{ $gallery->location }}</strong></p>
                    <p class="mb-2 fs-6">Fungsi<br><strong>{{ $gallery->function }}</strong></p>
                    <p class="mb-2 fs-6">
                        Luas Tanah (LT) / Luas Bangunan (LB)<br>
                        <strong>{{ $gallery->land_area }} m² / {{ $gallery->building_area }} m²</strong>
                    </p>
                </div>
            <div class="text-end mt-3">
                <a href="{{ route('front.galleries.show', Crypt::encryptString($gallery->id)) }}" class="btn btn-sm btn-outline-primary text-custom border-custom ">Detail</a>
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

    :root{
        --text-color: #0C2C5A;
    }
    h1{
        color: var(--text-color);
    }
    p{
        color: var(--text-color);
    }
    a{
        color: var(--text-color);
    }

    .btn:hover{
        background-color: #0C2C5A !important;
        color: #fff !important;
    }
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
