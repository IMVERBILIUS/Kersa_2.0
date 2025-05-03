@extends('../layouts/master')

@section('content')

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
                <ul class="navbar-nav ms-auto align-items-lg-center gap-lg-3">
                    <li class="nav-item"><a class="nav-link fw-medium text-white active" href="{{ route('front.index') }}">Home</a></li>
                    <li class="nav-item"><a class="nav-link fw-medium text-white" href="{{ route('front.articles') }}">Articles</a></li>
                    <li class="nav-item"><a class="nav-link fw-medium text-white" href="{{ route('front.contact') }}">Contact</a></li>

                    @guest
                        <li class="nav-item"><a class="nav-link fw-medium text-white" href="{{ route('login') }}">Login</a></li>
                    @else
                        <li class="nav-item">
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="btn btn-outline-light ms-lg-3">Logout</button>
                            </form>
                        </li>
                    @endguest
                </ul>
            </div>
        </div>
    </nav>

    <div class="position-relative vh-100 d-flex align-items-center overflow-hidden">
        <video
        class="position-absolute top-0 start-0 w-100 h-100 object-fit-cover z-1"
        autoplay muted loop playsinline
        disablepictureinpicture controlslist="nodownload nofullscreen noremoteplayback"
        style="pointer-events: none;"
    >
        <source src="{{ asset('assets/video/background.mp4') }}" type="video/mp4" />
        Your browser does not support the video tag.
    </video>

        <div class="position-absolute top-0 start-0 w-100 h-100 bg-black opacity-50 z-2"></div>
        <div class="container position-relative text-white z-2">
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
        <h3 class="fw-bold mb-0 article-text">Artikel Terbaru</h3>
        <a href="{{ route('front.articles') }}" class="btn btn-outline-dark lihat-semua-btn px-4">Lihat semuanya</a>
    </div>
    <div id="latestArticlesCarousel" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-inner">
            @foreach($latest_articles->chunk($chunk_size) as $chunk)
                <div class="carousel-item {{ $loop->first ? 'active' : '' }}">
                    <div class="row g-4">
                        @foreach($chunk as $article)
                            <div class="col">
                                <a href="{{ route('front.articles.show', Crypt::encryptString($article->id)) }}" class="text-decoration-none">
                                    <div class="card card-hover-zoom border-0 rounded-3 overflow-hidden position-relative" style="height: 350px;">
                                        <div class="ratio ratio-16x9 mb-2">
                                            <img src="{{ asset('storage/' . $article->thumbnail) }}" class="img-fluid object-fit-cover w-100 h-100" alt="{{ $article->title }}">
                                        </div>
                                        <div class="d-flex flex-column justify-content-center align-items-start px-3">
                                            <h5 class="fs-5 fw-semibold article-text">{{ Str::limit($article->title, 50) }}</h5>
                                            <p class="opacity-75 fs-7 clamp-text article-text">{{ Str::limit($article->description, 70) }}</p>
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
        <h3 class="fw-bold mb-0 article-text">Artikel Populer</h3>
        <a href="{{ route('front.articles') }}" class="btn btn-outline-dark lihat-semua-btn px-4">Lihat semuanya</a>
    </div>
    <div id="popularArticlesCarousel" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-inner">
            @foreach($populer_articles->chunk($chunk_size) as $chunk)
                <div class="carousel-item {{ $loop->first ? 'active' : '' }}">
                    <div class="row g-4">
                        @foreach($chunk as $article)
                            <div class="col">
                                <a href="{{ route('front.articles.show', Crypt::encryptString($article->id)) }}" class="text-decoration-none">
                                    <div class="card card-hover-zoom border-0 rounded-3 overflow-hidden position-relative" style="height: 350px;">
                                        <div class="ratio ratio-16x9 mb-2">
                                            <img src="{{ asset('storage/' . $article->thumbnail) }}" class="img-fluid object-fit-cover w-100 h-100" alt="{{ $article->title }}">
                                        </div>
                                        <div class="d-flex flex-column justify-content-center align-items-start px-3">
                                            <h5 class="fs-5 fw-semibold article-text">{{ Str::limit($article->title, 50) }}</h5>
                                            <p class="opacity-75 fs-7 clamp-text article-text">{{ Str::limit($article->description, 70) }}</p>
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
    <a href="{{ route('front.articles') }}" class="btn btn-outline-dark lihat-semua-btn px-4">Lihat semuanya</a>
</div>



{{-- Galleries --}}
<div class="container py-5">
     <div class="carousel-container">
      <h2 class="carousel-title">Galeri</h2>
      <p class="carousel-subtitle">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Culpa, corporis ratione. Aperiam recusandae quidem maiores.</p>
      <div class="carousel">
        <button class="nav-button left">&#10094;</button>
        <div class="carousel-images">

            @foreach ($galleries as $gallery)
            <a href="{{ route('front.galleries.show', Crypt::encryptString($gallery->id)) }}" class="image-item">
              <img src="{{ asset(path: 'storage/' . $gallery->thumbnail) }}" alt="{{ $gallery->title }}" />
              <h1>{{ Str::limit($gallery->title, 30)     }}</h1>
            </a>
            @endforeach

        </div>
        <button class="nav-button right">&#10095;</button>
      </div>
    </div>
</div>
<div class="text-center mt-4">
    <a href="{{ route('front.galleries') }}" class="btn btn-outline-dark lihat-semua-btn px-4">Lihat semuanya</a>
</div>


@endsection

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/carousel_gallery.css') }}">
@endpush
@push('scripts')
    <script src="{{ asset('js/carousel_gallery.js') }}"></script>
@endpush
