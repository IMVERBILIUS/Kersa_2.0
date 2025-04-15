@extends('../layouts/master')

@section('content')
<section class="position-relative">
    <nav class="navbar navbar-expand-lg bg-transparent py-3 position-absolute top-0 start-0 w-100 z-3">
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
                    <li class="nav-item"><a class="nav-link fw-medium text-dark" href="#">About Us</a></li>
                    <li class="nav-item"><a class="nav-link fw-medium text-dark" href="{{ route('front.articles') }}">Articles</a></li>
                    <li class="nav-item"><a class="nav-link fw-medium text-dark" href="{{ route('front.contact') }}">Contact</a></li>
                </ul>
            </div>
        </div>
    </nav>
</section>

<div class="container py-5 mt-5">
    <h2 class="fw-bold mb-4 text-center">Semua Artikel</h2>

    <!-- Filter Dropdown -->
    <div class="mb-4">
        <form action="{{ route('front.articles') }}" method="GET">
            <select name="filter" class="form-select" onchange="this.form.submit()">
                <option value="">Sort by</option>
                <option value="latest" {{ request('filter') == 'latest' ? 'selected' : '' }}>Latest</option>
                <option value="popular" {{ request('filter') == 'popular' ? 'selected' : '' }}>Popular</option>
                <option value="author" {{ request('filter') == 'author' ? 'selected' : '' }}>By Author</option>
            </select>
        </form>
    </div>

    <div class="row row-cols-1 row-cols-md-3 g-4">
        @forelse($articles as $article)
            <div class="col">
                <a href="{{ route('front.articles.show', Crypt::encryptString($article->id)) }}">
                    <div class="card h-100 border-0 shadow-sm card-hover-zoom overflow-hidden">
                        <div class="ratio ratio-4x3">
                            <img src="{{ asset('storage/' . $article->thumbnail) }}" class="card-img-top object-fit-cover" alt="{{ $article->title }}">
                        </div>
                        <div class="card-body">
                            <h5 class="card-title fw-semibold">{{ $article->title }}</h5>
                            <p class="card-text">{{ Str::limit($article->description, 100) }}</p>
                        </div>
                    </div>
                </a>
            </div>
        @empty
            <div class="col-12">
                <p class="text-center">No articles found.</p>
            </div>
        @endforelse
    </div>

    <!-- Pagination -->
    <div class="mt-4 d-flex justify-content-center">
        <!-- Custom Pagination -->
        <ul class="pagination">
            @for ($i = 1; $i <= $articles->lastPage(); $i++)
                <li class="page-item {{ $i == $articles->currentPage() ? 'active' : '' }}">
                    <a class="page-link btn btn-outline-dark" href="{{ $articles->url($i) }}">{{ $i }}</a>
                </li>
            @endfor
        </ul>
    </div>
</div>

<style>
    /* Custom Pagination Styles */
    .pagination {
        list-style: none;
        display: flex;
        justify-content: center;
        padding: 0;
        margin: 0;
    }

    .pagination .page-item {
        margin: 0 5px;
    }

    .pagination .page-link {
        border-radius: 50%;
        padding: 10px 15px;
        color: #212529;
        background-color: transparent;
        border: 1px solid #ddd;
        transition: background-color 0.3s ease, border-color 0.3s ease;
    }

    .pagination .page-link:hover {
        background-color: #f8f9fa;
        border-color: #b5b5b5;
    }

    .pagination .page-item.active .page-link {
        background-color: #1e1a0e;
        border-color: #1f1b0f;
        color: #fff;
    }

    .pagination .page-item.disabled .page-link {
        color: #aaa;
        pointer-events: none;
    }

    /* Hover Zoom Effect */
    .card-hover-zoom {
        transition: transform 0.4s ease, box-shadow 0.3s ease;
    }

    .card-hover-zoom:hover {
        transform: scale(1.05);
        z-index: 2;
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
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

    /* Customize Filter Dropdown */
    .form-select {
        width: 200px;
        display: inline-block;
    }
</style>

@endsection
