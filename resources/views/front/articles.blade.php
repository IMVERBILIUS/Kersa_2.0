@extends('../layouts/master')

@section('content')
<<<<<<< HEAD
<div class="container py-5">

  {{-- Back Button --}}
    <div class="d-flex justify-content-between mb-4 ">
        <a href="{{ route('front.index') }}" class="btn px-4 py-2"
            style="background-color: #F0F5FF; ; border-radius: 8px;">
            <i class="fas fa-arrow-left me-2"></i> Back
        </a>
    </div>
    <div class="row mb-5">
        <div class="col-12 text-center">
            <h1 class="display-4 fw-bold mb-2">Our Articles</h1>
            <p class="text-muted fs-5 mb-0">Discover insights and inspiration for your property dreams</p>
            <div class="mx-auto mt-3" style="width: 80px; height: 3px; background-color: lightgray; "></div>
        </div>
    </div>

    
    

    <!-- Articles Grid -->
    <div class="row">
        <div class="col-12 mb-4">
            <h2 class="fw-bold fs-4">Latest Articles</h2>
        </div>
    </div>

    <div class="row row-cols-1 row-cols-md-2 row-cols-lg-4 g-4 mb-5">
        @forelse ( $articles as $article )
          
        <div class="col">
          <a href="{{route('front.articles.show', $article->id) }}" style="text-decoration: none;">

            <div class="card h-100 border-0 shadow-sm rounded-3 overflow-hidden article-card">
                <div class="position-relative">
                    <div class="ratio ratio-4x3">
                        <img src="{{ asset('storage/' . $article->thumbnail)}}" class="card-img-top object-fit-cover h-100" alt="Article Image">
                    </div>
                    
                </div>
                <div class="card-body p-3 ">
                    <h3 class="card-title fw-bold fs-6 ">{{ $article->title }}</h3>
                </div>
                <div class="card-footer bg-white border-0 p-3 pt-0">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="d-flex align-items-center">
                           <div class="d-flex justify-content-center align-items-center rounded-circle me-3"
                            style="width: 40px; height: 40px; background-color: #F0F5FF;">
                            <i class="fas fa-user" style="color: #5B93FF;"></i>
                        </div>
                            <span class="text-muted small">{{ $article->author ?? 'Unknown' }}</span>
                        </div>
                        <small class="text-muted">{{ $article->created_at->format('d M Y') }}</small>
                    </div>
                </div>
            </div>
          </a>
        </div>
        @empty
        <div class="col"> 
            <div class="card h-100 border-0 shadow-sm rounded-3 overflow-hidden article-card">
                <div class="card-body p-3">
                    <h3 class="card-title fw-bold fs-6 ">No Article Found</h3>
                </div>
            </div>
        </div>
          
        @endforelse
          
          
       
    </div>

    <!-- Pagination -->
<div class="row">
    <div class="col-12">
        @if ($articles->hasPages())
            <nav>
                <ul class="pagination justify-content-center">
                    {{-- Previous Page Link --}}
                    <li class="page-item {{ $articles->onFirstPage() ? 'disabled' : '' }}">
                        <a class="page-link rounded-start-pill" href="{{ $articles->previousPageUrl() }}" tabindex="-1">Previous</a>
                    </li>
                    
                    {{-- Pagination Elements --}}
                    @for ($i = 1; $i <= $articles->lastPage(); $i++)
                        <li class="page-item {{ $articles->currentPage() == $i ? 'active' : '' }}">
                            <a class="page-link" href="{{ $articles->url($i) }}">{{ $i }}</a>
                        </li>
                    @endfor
                    
                    {{-- Next Page Link --}}
                    <li class="page-item {{ $articles->hasMorePages() ? '' : 'disabled' }}">
                        <a class="page-link rounded-end-pill" href="{{ $articles->nextPageUrl() }}">Next</a>
                    </li>
                </ul>
            </nav>
        @endif
    </div>
</div>
</div>

<style>
    
.article-card {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .article-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(108, 155, 207, 0.15) !important;
    }

   
    .pagination .page-link {
        color: var(--primary-color);
        border: 1px solid #dee2e6;
        margin: 0 2px;
    }

    .pagination .page-item.active .page-link {
        background-color: var(--primary-color);
        border-color: var(--primary-color);
    }

    /* Input focus states */
    .form-control:focus, .form-select:focus {
        border-color: var(--primary-color);
        box-shadow: 0 0 0 0.25rem rgba(108, 155, 207, 0.25);
    }
</style>
@endsection
=======
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
    <h2 class="fw-bold mb-4 text-center">All Articles</h2>

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
                <a href="{{ route('front.articles.show', $article->id) }}" class="text-decoration-none text-dark">
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
>>>>>>> 9715db2ac282c7b1fd55ad2422c1b2b6ace485e7
