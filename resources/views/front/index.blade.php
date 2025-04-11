@extends('../layouts/master')

@section('content')
<section class="position-relative">
   <!-- Navbar -->
   <nav class="navbar navbar-expand-lg bg-transparent py-2  position-absolute top-0 start-0 w-100 z-3">
      <div class="container">
         <div class="navbar-brand d-flex flex-column align-items-start">
            <h1 class="mb-0 fs-3 fw-semibold text-white ">KERSA</h1>
            <p class=" fs-6 mb-0 text-white ">By Ankara Cipta</p>
         </div>
         
         <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent">
            <span class="navbar-toggler-icon"></span>
         </button>
         
         <div class="collapse navbar-collapse" id="navbarContent">
            <ul class="navbar-nav ms-auto">
               <li class="nav-item">
                  <a class="nav-link active fw-medium text-white active" href="#">Home</a>
               </li>
               <li class="nav-item">
                  <a class="nav-link fw-medium text-white" href="#">About Us</a>
               </li>
               <li class="nav-item">
                  <a class="nav-link fw-medium text-white" href="{{route('front.articles')}}">Articles</a>
               </li>
               <li class="nav-item">
                  <a class="nav-link fw-medium text-white" href="{{route('front.contact')}}">Contact</a>
               </li>
            </ul>
         </div>
      </div>
   </nav>
   
   <!-- Hero Video Section -->
   <div class="position-relative vh-100 d-flex align-items-center overflow-hidden ">
      <video class="position-absolute top-0 start-0 w-100 h-100 object-fit-cover z-1" autoplay muted loop playsinline>
        <source src="{{ asset(path: '/assets/video/background.mp4') }}" type="video/mp4" />
        Your browser does not support the video tag.
      </video>

      <!-- Gradient Overlay -->
      <div class="position-absolute top-0 start-0 w-100 h-100 bg-black opacity-50 z-2"></div>

      <!-- Hero Content -->
      <div class="container position-relative text-white z-3 ">
        <div class="row justify-content-center">
          <div class="col-lg-8 col-md-10">
            <div class="p-4 p-md-5 text-center">
              <p class="lead mb-4 fw-light">
                KERSA, lahir dari induk perusahaan <strong>CV. Ankara Cipta</strong> yang telah memiliki pengalaman dalam dunia perancangan dan konstruksi. Reksa memiliki cita-cita menjadi sahabat yang memberikan solusi membangun properti impian
                di Indonesia. Tim profesional dan berpengalaman senantiasa berkomitmen untuk menciptakan properti impian yang nyaman dan berkelanjutan.
              </p>
              <p class="fs-5 fw-light">Sejarah baru akan dimulai, <em class="text-warning">soon April 2025</em>, sahabat solusi properti impian.</p>
            </div>
          </div>
        </div>
      </div>
    </div>

    
    
    <div class="container py-5  ">
   <h3 class="fw-bold mb-4">Popular Articles</h3>
  <!-- Carousel Start -->
  <div id="popularArticlesCarousel" class="carousel " data-bs-ride="carousel">
    <div class="carousel-inner ">
      @foreach($populer_articles->chunk(3) as $chunkIndex => $chunk)
      <div class="carousel-item {{ $chunkIndex === 0 ? 'active' : '' }}">
        <div class="row row-cols-1 row-cols-md-3 g-4">
          @foreach($chunk as $article)
          <div class="col py-2 ">
            <a href="">

              <div class="card rounded-3 border-0 overflow-hidden position-relative" style="height: 300px; box-shadow: 0 2px 6px rgba(0,0,0,0.1); ">
      <div class="ratio ratio-4x3">
        <img src="{{ asset('storage/' . $article->thumbnail) }}" 
             class="img-fluid object-fit-cover w-100 h-100" 
             alt="{{ $article->title }}">
      </div>
    
      {{-- Overlay untuk hover --}}
      <div class="overlay d-flex flex-column justify-content-center align-items-center text-center px-3">
        <h5 class="text-white fs-5 fw-semibold">{{ $article->title }}</h5>
        <p class="text-white fs-7 clamp-text">{{ $article->description }}</p>
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
      <span class="carousel-control-prev-icon bg-dark rounded-circle p-2" aria-hidden="true"></span>
      <span class="visually-hidden">Previous</span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#popularArticlesCarousel" data-bs-slide="next">
      <span class="carousel-control-next-icon bg-dark rounded-circle p-2" aria-hidden="true"></span>
      <span class="visually-hidden">Next</span>
    </button>
  </div>
  <!-- Carousel End -->

  <div class="text-center mt-4">
   <a href="{{ route('front.articles') }}" class="btn btn-lg px-4 py-2  " style="border: 1px solid black;background-color: #F0F5FF; ; border-radius: 8px; ">
                                    See all article
                                   
                                </a>
  </div>
</div>


     


    <!-- Footer -->
    <footer class="bg-dark p-3 text-white text-center py-5 mt-4">
      <div class="container">
        <div class="row">
          <!-- Logo dan Hak Cipta -->
          <div class="col-md-4 mb-4 text-md-start">
            <h4 class="fw-bold mb-1">KERSA</h4>
            <p class="small mb-3">By Ankara Cipta</p>
            <p>&copy; 2025 Kersa by Ankara Cipta</p>
            <p class="small text-muted">Sahabat solusi properti impian</p>
          </div>

          <!-- Navigasi -->
          <div class="col-md-4 mb-4">
            <h5 class="fw-bold mb-3">Links</h5>
            <ul class="list-unstyled d-flex flex-column gap-2">
              <li><a href="#" class="text-decoration-none text-white">Beranda</a></li>
              <li><a href="#" class="text-decoration-none text-white">Tentang Kami</a></li>
              <li><a href="{{route('front.articles')}}" class="text-decoration-none text-white">Artikel</a></li>
              <li><a href="{{route('front.contact')}}" class="text-decoration-none text-white">Kontak</a></li>
            </ul>
          </div>

          <!-- Kontak -->
          <div class="col-md-4 mb-3 text-md-end">
            <h5 class="fw-bold mb-3">Kontak Kami</h5>
            <p>Email: <a href="mailto:kersa.id@gmail.com" class="text-warning text-decoration-none">kersa.id@gmail.com</a></p>
            <p>Telepon: <a href="tel:+620812345678" class="text-warning text-decoration-none">+62 822-2095-5595</a></p>
            <div class="d-flex justify-content-center justify-content-md-end gap-3 mt-4">
              <a href="#" class="btn btn-outline-light btn-sm rounded-circle">
                <i class="bi bi-facebook"></i>
              </a>
              <a href="#" class="btn btn-outline-light btn-sm rounded-circle">
                <i class="bi bi-instagram"></i>
              </a>
              <a href="#" class="btn btn-outline-light btn-sm rounded-circle">
                <i class="bi bi-twitter-x"></i>
              </a>
            </div>
          </div>
        </div>
      </div>
    </footer>
</section>
@endsection


@push('styles')
<style>

  .ratio-wrapper img {
    width: 100%;
    height: 100%;
    object-fit: cover;
  }
  .card .overlay {
  position: absolute;
  inset: 0;
  background: rgba(0, 0, 0, 0.5); /* semi-transparent black */
  opacity: 0;
  transition: opacity 0.3s ease;
  z-index: 2;
}

.card:hover .overlay {
  opacity: 1;
}
.card:hover{
  scale: 1.05;
  transition:  0.2s ease-in-out
}

.btn:hover {
    transform: translateY(-1px);
    box-shadow: 0 4px 8px rgba(108, 99, 255, 0.3);
}

.clamp-text {
  display: -webkit-box;
  -webkit-line-clamp: 3; /* Ganti sesuai kebutuhan */
  -webkit-box-orient: vertical;
  overflow: hidden;
  text-overflow: ellipsis;
}

  
  </style>
@endpush
