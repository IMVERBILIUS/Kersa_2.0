@extends('../layouts/master')

@section('content')
<section class="position-relative">
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg bg-transparent py-2 position-absolute top-0 start-0 w-100 z-3">
        <div class="container">
            <div class="navbar-brand d-flex flex-column align-items-start">
                <h1 class="mb-0 fs-3 fw-semibold text-white">KERSA</h1>
                <p class="fs-6 mb-0 text-white">By Ankara Cipta</p>
            </div>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarContent">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link fw-medium text-white active" href="#">Home</a></li>
                    <li class="nav-item"><a class="nav-link fw-medium text-white" href="#">About Us</a></li>
                    <li class="nav-item"><a class="nav-link fw-medium text-white" href="{{ route('front.articles') }}">Articles</a></li>
                    <li class="nav-item"><a class="nav-link fw-medium text-white" href="{{ route('front.contact') }}">Contact</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Hero Video Section -->
    <div class="position-relative vh-100 d-flex align-items-center overflow-hidden">
        <video class="position-absolute top-0 start-0 w-100 h-100 object-fit-cover z-1" autoplay muted loop playsinline>
            <source src="{{ asset('assets/video/background.mp4') }}" type="video/mp4" />
            Your browser does not support the video tag.
        </video>

        <!-- Overlay -->
        <div class="position-absolute top-0 start-0 w-100 h-100 bg-black opacity-50 z-2"></div>

        <!-- Content -->
        <div class="container position-relative text-white z-3">
            <div class="row justify-content-center">
                <div class="col-lg-8 col-md-10">
                    <div class="p-4 p-md-5 text-center">
                        <p class="lead mb-4 fw-light">
                            KERSA, lahir dari induk perusahaan <strong>CV. Ankara Cipta</strong> yang telah memiliki pengalaman dalam dunia perancangan dan konstruksi. Reksa memiliki cita-cita menjadi sahabat yang memberikan solusi membangun properti impian di Indonesia. Tim profesional dan berpengalaman senantiasa berkomitmen untuk menciptakan properti impian yang nyaman dan berkelanjutan.
                        </p>
                        <p class="fs-5 fw-light">Sejarah baru akan dimulai, <em class="text-warning">soon April 2025</em>, sahabat solusi properti impian.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Popular Articles -->
<div class="container my-5">
    <h3 class="fw-bold mb-4">Popular Articles</h3>
    <div id="popularArticlesCarousel" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-inner py-3">
            @foreach($populer_articles->chunk(3) as $chunkIndex => $chunk)
            <div class="carousel-item {{ $chunkIndex === 0 ? 'active' : '' }}">
                <div class="row row-cols-1 row-cols-md-3 g-4">
                    @foreach($chunk as $article)
                    <div class="col">
                        <a href="{{ route('front.articles.show', $article->id) }}">
                            <div class="card border-0 rounded-3 overflow-hidden position-relative" style="height: 300px; box-shadow: 0 2px 6px rgba(0,0,0,0.1);">
                                <div class="ratio ratio-4x3">
                                    <img src="{{ asset('storage/' . $article->thumbnail) }}" class="img-fluid object-fit-cover w-100 h-100" alt="{{ $article->title }}">
                                </div>
                                <div class="overlay d-flex flex-column justify-content-center align-items-center text-center px-3 position-absolute top-0 start-0 w-100 h-100 bg-dark bg-opacity-50">
                                    <h5 class="text-white fs-5 fw-semibold">{{ $article->title }}</h5>
                                    <p class="text-white fs-7 clamp-text">{{ Str::limit($article->description, 100) }}</p>
                                </div>
                            </div>
                        </a>
                    </div>
                    @endforeach
                </div>
            </div>
            @endforeach
        </div>

        <!-- Controls -->
        <button class="carousel-control-prev" type="button" data-bs-target="#popularArticlesCarousel" data-bs-slide="prev">
            <span class="carousel-control-prev-icon"></span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#popularArticlesCarousel" data-bs-slide="next">
            <span class="carousel-control-next-icon"></span>
        </button>
    </div>
</div>

<!-- Latest Articles -->
<div class="container mb-5">
    <h3 class="fw-bold mb-4">Latest Articles</h3>
    <div id="latestArticlesCarousel" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-inner py-3">
            @foreach($latest_articles->chunk(3) as $chunkIndex => $chunk)
            <div class="carousel-item {{ $chunkIndex === 0 ? 'active' : '' }}">
                <div class="row row-cols-1 row-cols-md-3 g-4">
                    @foreach($chunk as $article)
                    <div class="col" >
                        <a href="{{ route('front.articles.show', $article->id) }}">
                            <div class="card border-0 rounded-3 overflow-hidden position-relative" style="height: 300px; box-shadow: 0 2px 6px rgba(0,0,0,0.1);">
                                <div class="ratio ratio-4x3">
                                    <img src="{{ asset('storage/' . $article->thumbnail) }}" class="img-fluid object-fit-cover w-100 h-100" alt="{{ $article->title }}">
                                </div>
                                <div class="overlay d-flex flex-column justify-content-center align-items-center text-center px-3 position-absolute top-0 start-0 w-100 h-100 bg-dark bg-opacity-50">
                                    <h5 class="text-white fs-5 fw-semibold">{{ $article->title }}</h5>
                                    <p class="text-white fs-7 clamp-text">{{ Str::limit($article->description, 100) }}</p>
                                </div>
                            </div>
                        </a>
                    </div>
                    @endforeach
                </div>
            </div>
            @endforeach
        </div>

        <!-- Controls -->
        <button class="carousel-control-prev" type="button" data-bs-target="#latestArticlesCarousel" data-bs-slide="prev">
            <span class="carousel-control-prev-icon"></span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#latestArticlesCarousel" data-bs-slide="next">
            <span class="carousel-control-next-icon"></span>
        </button>
    </div>
</div>

<style>
.card {
    transition: transform 0.3s ease-in-out;
}

.card:hover {
    transform: scale(1.05);
    z-index: 10; 
    box-shadow: 0 4px 12px rgba(0,0,0,0.2); 
}

.overlay {
    transition: opacity 0.3s ease;
}

.card:hover .overlay {
    opacity: 0.9; 
}
</style>

@endsection
