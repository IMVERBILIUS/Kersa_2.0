@extends('../layouts/master')

@section('content')

<style>
    .carousel-control-prev,
    .carousel-control-next {
        width: 5%;
        top: 50%;
        transform: translateY(-50%);
        background-color: rgba(128, 128, 128, 0.7); /* abu-abu semi-transparan */
        border-radius: 50%;
        height: 40px;
        width: 40px;
        z-index: 10;
    }

    .carousel-control-prev {
        left: -50px; /* geser ke luar gambar */
    }

    .carousel-control-next {
        right: -50px;
    }

    .carousel-control-prev-icon,
    .carousel-control-next-icon {
        filter: invert(1); /* biar icon tetap kelihatan di background abu-abu */
        background-size: 100% 100%;
    }

    @media (max-width: 768px) {
        .carousel-control-prev {
            left: -30px;
        }

        .carousel-control-next {
            right: -30px;
        }
    }

    .card-hover-zoom {
        transition: transform 0.5s ease, box-shadow 0.3s ease;
        position: relative;
        z-index: 1;
    }

    .card-hover-zoom:hover {
        transform: scale(1.25);
        z-index: 999;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
    }

    .card-hover-zoom .overlay {
        opacity: 0;
        transition: opacity 0.3s ease;
    }

    .card-hover-zoom:hover .overlay {
        opacity: 1;
    }

    .carousel-inner,
    .carousel-item {
        overflow: visible !important;
    }
</style>

<section class="position-relative">
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
                    <li class="nav-item"><a class="nav-link fw-medium text-white active" href="{{ route('front.index') }}">Home</a></li>
                    <li class="nav-item"><a class="nav-link fw-medium text-white" href="#">About Us</a></li>
                    <li class="nav-item"><a class="nav-link fw-medium text-white" href="{{ route('front.articles') }}">Articles</a></li>
                    <li class="nav-item"><a class="nav-link fw-medium text-white" href="{{ route('front.contact') }}">Contact</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="position-relative vh-100 d-flex align-items-center overflow-hidden">
        <video class="position-absolute top-0 start-0 w-100 h-100 object-fit-cover z-1" autoplay muted loop playsinline>
            <source src="{{ asset('assets/video/background.mp4') }}" type="video/mp4" />
            Your browser does not support the video tag.
        </video>
        <div class="position-absolute top-0 start-0 w-100 h-100 bg-black opacity-50 z-2"></div>
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

<!-- Latest Articles -->
<div class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="fw-bold mb-0">Latest Articles</h3>
        <a href="{{ route('front.articles') }}" class="btn btn-outline-dark px-4">See All</a>
    </div>
    <div id="latestArticlesCarousel" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-inner">
            @foreach($latest_articles->chunk($chunk_size) as $chunk)
                <div class="carousel-item {{ $loop->first ? 'active' : '' }}">
                    <div class="row g-4">
                        @foreach($chunk as $article)
                            <div class="col">
                                <a href="{{ route('front.articles.show', $article->id) }}">
                                    <div class="card card-hover-zoom border-0 rounded-3 overflow-hidden position-relative" style="height: 300px;">
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
        <button class="carousel-control-prev" type="button" data-bs-target="#latestArticlesCarousel" data-bs-slide="prev">
            <span class="carousel-control-prev-icon"></span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#latestArticlesCarousel" data-bs-slide="next">
            <span class="carousel-control-next-icon"></span>
        </button>
    </div>
</div>

<!-- Popular Articles -->
<div class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="fw-bold mb-0">Popular Articles</h3>
        <a href="{{ route('front.articles') }}" class="btn btn-outline-dark px-4">See All</a>
    </div>
    <div id="popularArticlesCarousel" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-inner">
            @foreach($populer_articles->chunk($chunk_size) as $chunk)
                <div class="carousel-item {{ $loop->first ? 'active' : '' }}">
                    <div class="row g-4">
                        @foreach($chunk as $article)
                            <div class="col">
                                <a href="{{ route('front.articles.show', $article->id) }}">
                                    <div class="card card-hover-zoom border-0 rounded-3 overflow-hidden position-relative" style="height: 300px;">
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
        <button class="carousel-control-prev" type="button" data-bs-target="#popularArticlesCarousel" data-bs-slide="prev">
            <span class="carousel-control-prev-icon"></span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#popularArticlesCarousel" data-bs-slide="next">
            <span class="carousel-control-next-icon"></span>
        </button>
    </div>
</div>

<div class="text-center mt-4">
    <a href="{{ route('front.articles') }}" class="btn btn-outline-dark px-4">See All</a>
</div>

@endsection
