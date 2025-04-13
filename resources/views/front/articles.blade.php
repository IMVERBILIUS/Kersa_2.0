@extends('../layouts.master')

@section('content')
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