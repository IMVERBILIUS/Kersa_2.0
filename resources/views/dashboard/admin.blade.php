@extends('layouts.admin')

@section('content')
<div class="container-fluid px-4">
    <!-- Welcome Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="bg-white rounded-4 shadow-sm p-4">
                <div class="d-flex align-items-center">
                    <div class="d-flex justify-content-center align-items-center rounded-circle me-4" style="width: 80px; height: 80px; background-color: #E9F5FF;">
                        <i class="fas fa-user-circle fs-2" style="color: #5B93FF;"></i>
                    </div>
                    <div>
                        <h2 class="fs-3 fw-bold mb-1">Welcome, {{ Auth::user()->name }}!</h2>
                        <p class="text-muted mb-0">Here's what's happening with your articles and galleries today</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Statistics Row -->
    <div class="row mb-4">
        @foreach([['Articles', $articles, '#4A89DC', 'fas fa-newspaper'], ['Published Articles', $articles->filter(fn($a) => strtolower(trim($a->status)) == 'published'), '#58D68D', 'fas fa-check-circle'], ['Galleries', $galleries, '#8E44AD', 'fas fa-images'], ['Published Galleries', $galleries->filter(fn($g) => strtolower(trim($g->status)) == 'published'), '#28B463', 'fas fa-check-circle']] as $stat)
        <div class="col-md-3 mb-3">
            <div class="bg-white rounded-3 shadow-sm p-4">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="fw-semibold m-0">Total {{ $stat[0] }}</h5>
                    <div class="rounded-circle p-3" style="background-color: {{ $stat[2] }};">
                        <i class="{{ $stat[3] }}" style="color: #fff; font-size: 1.5rem;"></i>
                    </div>
                </div>
                <h3 class="fw-bold text-center">{{ $stat[1]->count() }}</h3>
                <div class="progress mt-2" style="height: 6px;">
                    <div class="progress-bar" role="progressbar" style="width: 100%; background-color: {{ $stat[2] }};" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <!-- Views Statistics -->
    <div class="row mb-4">
        @foreach([['Articles', $articles], ['Galleries', $galleries]] as $stat)
        <div class="col-md-6 mb-3">
            <div class="bg-white rounded-3 shadow-sm p-3">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <h5 class="fw-semibold m-0 fs-6">Total Views ({{ $stat[0] }})</h5>
                    <div class="rounded-circle p-2" style="background-color: #FFF5F0;">
                        <i class="fas fa-eye" style="color: #E67E22; font-size: 1.25rem;"></i>
                    </div>
                </div>
                <h3 class="fw-bold text-center fs-4">{{ $stat[1]->sum('views') }}</h3>
                <div class="progress mt-2" style="height: 4px;">
                    <div class="progress-bar" role="progressbar" style="width: 100%; background-color: #E67E22;" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <!-- Visits Overview -->
    <div class="row mb-4">
        @foreach([['Today', $today, 'calendar-day', 'text-primary'], ['This Week', $week, 'calendar-week', 'text-success'], ['This Month', $month, 'calendar-alt', 'text-warning'], ['This Year', $year, 'calendar', 'text-danger']] as $visit)
        <div class="col-md-3 mb-3">
            <div class="bg-white rounded-3 shadow-sm p-4">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <h6 class="fw-semibold m-0">{{ $visit[0] }}</h6>
                    <i class="fas fa-{{ $visit[2] }} {{ $visit[3] }}"></i>
                </div>
                <h4 class="fw-bold text-center">{{ $visit[1] }}</h4>
            </div>
        </div>
        @endforeach
    </div>

    <div class="row mb-4">
        <!-- Page Visits Card -->
        <div class="col-md-6 mb-3 d-flex">
            <div class="bg-white rounded-3 shadow-sm p-4 flex-fill">
                <h5 class="fw-semibold mb-3">
                    <i class="fas fa-chart-line me-2"></i> Page Visits
                </h5>
                <ul class="list-unstyled mb-0">
                    @foreach([['Homepage (kersa.id)', $homeVisit, 'home', 'text-primary'], ['Articles (kersa.id/articles)', $articleVisit, 'newspaper', 'text-info'], ['Galleries (kersa.id/galleries)', $galleryVisit, 'images', 'text-purple']] as $page)
                    <li class="mb-2">
                        <i class="fas fa-{{ $page[2] }} {{ $page[3] }} me-2"></i>
                        {{ $page[0] }}: <strong>{{ $page[1] }}</strong> visits
                    </li>
                    @endforeach
                </ul>
            </div>
        </div>

        <!-- Total Visits Card -->
        <div class="col-md-6 mb-3 d-flex">
            <div class="bg-white rounded-3 shadow-sm p-4 flex-fill">
                <h5 class="fw-semibold mb-3">
                    <i class="fas fa-users me-2"></i> Total Visits
                </h5>
                <div class="d-flex justify-content-between align-items-center">
                    <span class="fw-bold text-primary">{{ $homeVisit + $articleVisit + $galleryVisit }}</span>
                </div>
            </div>
        </div>
    </div>



    <!-- Visit Chart -->
    <div class="row mb-4">
        <div class="col-md-12">
            <div class="bg-white rounded-3 shadow-sm p-4">
                <h5 class="fw-semibold mb-3">Page Visit Statistics Chart</h5>
                <canvas id="visitChart" height="100"></canvas>
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
                    @foreach($articles->take(6) as $article)
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
                                        <span class="badge rounded-pill px-3 py-2" style="background-color: {{ strtolower(trim($article->status)) == 'published' ? '#E6F7F1' : '#f5f5f5' }}; color: {{ strtolower(trim($article->status)) == 'published' ? '#36b37e' : '#6c757d' }};">
                                            {{ $article->status }}
                                        </span>
                                        <span class="badge rounded-pill px-3 py-2" style="background-color: #F2F4F6; color: #5F738C;">
                                            <i class="fas fa-eye me-1"></i> {{ $article->views }}
                                        </span>
                                    </div>
                                    <h5 class="card-title fw-semibold">{{ Str::limit($article->title, 50) }}</h5>
                                    <p class="card-text text-muted mb-3" style="height: 60px; overflow: hidden;">{{ Str::limit($article->description, 100) }}</p>
                                    <div class="d-grid">
                                        <a href="{{ route('admin.articles.show', $article->id) }}" class="btn btn-sm" style="background-color: #F0F5FF; color: #5B93FF; border-radius: 8px;">
                                            View Details <i class="fas fa-arrow-right ms-1"></i>
                                        </a>
                                    </div>
                                </div>
                                <div class="card-footer text-muted text-center">
                                    Published on {{ \Carbon\Carbon::parse($article->created_at)->format('F d, Y') }}
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <p>No recent articles found.</p>
            @endif
        </div>
    </div>
        <!-- Recent Galleries Section -->
<div class="card border-0 rounded-3 shadow-sm mb-4">
    <div class="card-body p-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="fw-semibold m-0">Recent Galleries</h4>
            <a href="{{ route('admin.galleries.manage') }}" class="btn btn-sm px-3" style="background-color: #F5F0FF; color: #8E44AD; border-radius: 8px;">View All</a>
        </div>

        @if($galleries->count())
            <div class="row">
                @foreach($galleries->take(6) as $gallery)
                    <div class="col-lg-4 col-md-6 mb-4">
                        <div class="card h-100 border-0 shadow-sm">
                            @if($gallery->thumbnail)
                                <img src="{{ asset('storage/' . $gallery->thumbnail) }}" class="card-img-top" alt="{{ $gallery->title }}" style="height: 180px; object-fit: cover;">
                            @else
                                <div class="bg-light d-flex justify-content-center align-items-center" style="height: 180px;">
                                    <i class="fas fa-image text-muted fa-2x"></i>
                                </div>
                            @endif
                            <div class="card-body">
                                <div class="d-flex justify-content-between mb-2">
                                    <span class="badge rounded-pill px-3 py-2"
                                          style="background-color: {{ strtolower(trim($gallery->status)) == 'published' ? '#F4E6FF' : '#f5f5f5' }}; color: {{ strtolower(trim($gallery->status)) == 'published' ? '#8E44AD' : '#6c757d' }};">
                                        {{ $gallery->status }}
                                    </span>
                                    <span class="badge rounded-pill px-3 py-2" style="background-color: #F2F4F6; color: #5F738C;">
                                        <i class="fas fa-eye me-1"></i> {{ $gallery->views }}
                                    </span>
                                </div>
                                <h5 class="card-title fw-semibold">{{ Str::limit($gallery->title, 50) }}</h5>
                                <div class="d-grid">
                                    <a href="{{ route('admin.galleries.show', $gallery->id) }}" class="btn btn-sm" style="background-color: #F5F0FF; color: #8E44AD; border-radius: 8px;">
                                        View Details <i class="fas fa-arrow-right ms-1"></i>
                                    </a>
                                </div>
                            </div>
                            <div class="card-footer bg-white border-0 py-3">
                                <div class="d-flex justify-content-between align-items-center">
                                    <small class="text-muted">
                                        <i class="far fa-calendar-alt me-1"></i> {{ $gallery->created_at->format('d M Y') }}
                                    </small>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="text-center py-5 bg-light rounded-3">
                <i class="fas fa-images fa-3x mb-3 text-muted"></i>
                <h5 class="text-muted">No galleries found</h5>
                <p class="text-muted mb-4">Get started by creating your first gallery</p>
                <a href="{{ route('admin.galleries.create') }}" class="btn btn-primary px-4" style="background-color: #8E44AD; border: none;">
                    <i class="fas fa-plus me-2"></i> Create Gallery
                </a>
            </div>
        @endif
    </div>
</div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('visitChart').getContext('2d');
    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ['Homepage', 'Articles', 'Galleries'],
            datasets: [{
                label: 'Page Visits',
                data: [{{ $homeVisit }}, {{ $articleVisit }}, {{ $galleryVisit }}],
                backgroundColor: ['#5B93FF', '#E67E22', '#8E44AD'],
                borderColor: ['#5B93FF', '#E67E22', '#8E44AD'],
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
</script>
@endpush
