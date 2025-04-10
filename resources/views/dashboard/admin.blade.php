@extends('layouts.admin')

@section('content')
<div class="container-fluid px-4 ">
    <!-- Welcome Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="bg-white rounded-4 shadow-sm p-4">
                <div class="d-flex align-items-center">
                    <div class="d-flex justify-content-center align-items-center rounded-circle me-4" 
                         style="width: 70px; height: 70px; background-color: #E9F5FF;">
                        <i class="fas fa-user-circle fs-2" style="color: #5B93FF;"></i>
                    </div>
                    <div>
                        <h2 class="fs-3 fw-bold mb-1">Welcome, {{ Auth::user()->name }}!</h2>
                        <p class="text-muted mb-0">Here's what's happening with your articles today</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Statistics Row -->
    <div class="row mb-4">
        <div class="col-md-4 mb-3 mb-md-0">
            <div class="bg-white rounded-3 shadow-sm p-3 h-100">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="fw-semibold m-0">Total Articles</h5>
                    <div class="rounded-circle p-2" style="background-color: #F0F9FF;">
                        <i class="fas fa-newspaper" style="color: #4A89DC;"></i>
                    </div>
                </div>
                <h3 class="fw-bold">{{ $articles->count() }}</h3>
                <div class="progress" style="height: 6px;">
                    <div class="progress-bar" role="progressbar" style="width: 100%; background-color: #4A89DC;" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-3 mb-md-0">
            <div class="bg-white rounded-3 shadow-sm p-3 h-100">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="fw-semibold m-0">Published</h5>
                    <div class="rounded-circle p-2" style="background-color: #F0FFF5;">
                        <i class="fas fa-check-circle" style="color: #58D68D;"></i>
                    </div>
                </div>
                <h3 class="fw-bold">{{ $articles->where('status', 'Published')->count() }}</h3>
                <div class="progress" style="height: 6px;">
                    <div class="progress-bar" role="progressbar" style="width: {{ $articles->count() > 0 ? ($articles->where('status', 'Published')->count() / $articles->count()) * 100 : 0 }}%; background-color: #58D68D;" aria-valuenow="{{ $articles->count() > 0 ? ($articles->where('status', 'Published')->count() / $articles->count()) * 100 : 0 }}" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="bg-white rounded-3 shadow-sm p-3 h-100">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="fw-semibold m-0">Total Views</h5>
                    <div class="rounded-circle p-2" style="background-color: #FFF5F0;">
                        <i class="fas fa-eye" style="color: #E67E22;"></i>
                    </div>
                </div>
                <h3 class="fw-bold">{{ $articles->sum('views') }}</h3>
                <div class="progress" style="height: 6px;">
                    <div class="progress-bar" role="progressbar" style="width: 100%; background-color: #E67E22;" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Articles Section -->
<div class="card border-0 rounded-3 shadow-sm mb-4">
    <div class="card-body p-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="fw-semibold m-0">Recent Articles</h4>
            <a href="{{ route('admin.articles.manage') }}" class="btn btn-sm px-3" style="background-color: #F0F5FF; color: #5B93FF; border-radius: 8px;">View All</a>
        </div>

        @if($articles->count())
            <div class="row">
                @foreach($articles->take(3) as $article)
                    <div class="col-lg-4 col-md-6 mb-4">
                        <div class="card h-100 border-0 shadow-sm">
                            @if($article->thumbnail)
                                <img src="{{ asset('storage/' . $article->thumbnail) }}" class="card-img-top" alt="{{ $article->title }}" style="height: 180px; object-fit: cover;">
                            @else
                                <div class="bg-light d-flex justify-content-center align-items-center" style="height: 180px;">
                                    <i class="fas fa-image text-muted fa-2x"></i>
                                </div>
                            @endif
                            <div class="card-body">
                                <div class="d-flex justify-content-between mb-2">
                                    <span class="badge rounded-pill px-3 py-2" 
                                          style="background-color: {{ $article->status == 'Published' ? '#E6F7F1' : '#f5f5f5' }}; 
                                                color: {{ $article->status == 'Published' ? '#36b37e' : '#6c757d' }};">
                                        {{ $article->status }}
                                    </span>
                                    <span class="badge rounded-pill px-3 py-2" 
                                          style="background-color: #F2F4F6; color: #5F738C;">
                                        <i class="fas fa-eye me-1"></i> {{ $article->views }}
                                    </span>
                                </div>
                                <h5 class="card-title fw-semibold">{{ Str::limit($article->title, 50) }}</h5>
                                <p class="card-text text-muted mb-3" style="height: 60px; overflow: hidden;">{{ Str::limit($article->description, 100) }}</p>
                                <div class="d-grid">
                                    <a href="{{ route('articles.show', $article->id) }}" class="btn btn-sm" style="background-color: #F0F5FF; color: #5B93FF; border-radius: 8px;">
                                        View Details <i class="fas fa-arrow-right ms-1"></i>
                                    </a>
                                </div>
                            </div>
                            <div class="card-footer bg-white border-0 py-3">
                                <div class="d-flex justify-content-between align-items-center">
                                    <small class="text-muted">
                                        <i class="far fa-calendar-alt me-1"></i> {{ $article->created_at->format('d M Y') }}
                                    </small>
                                    <small class="text-muted">
                                        <i class="far fa-user me-1"></i> {{ $article->author ?? 'Unknown' }}
                                    </small>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="text-center py-5 bg-light rounded-3">
                <i class="fas fa-newspaper fa-3x mb-3 text-muted"></i>
                <h5 class="text-muted">No articles found</h5>
                <p class="text-muted mb-4">Get started by creating your first article</p>
                <a href="{{ route('admin.articles.create') }}" class="btn btn-primary px-4" style="background-color: #5B93FF; border: none;">
                    <i class="fas fa-plus me-2"></i> Create Article
                </a>
            </div>
        @endif
    </div>
</div>
</div>
@endsection