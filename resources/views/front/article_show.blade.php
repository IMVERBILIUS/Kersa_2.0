@extends('layouts.master')

@section('content')

<div class="container px-4 px-lg-5">
    <div class="row justify-content-center">
        <div class="col-lg-12">

            <!-- Back Button -->
            <div class="d-flex justify-content-between mb-4 mt-4">
                <a href="{{ route('front.index') }}" class="btn px-4 py-2"
                style="background-color: #F0F5FF; color: #5B93FF; border-radius: 8px;">
                    <i class="fas fa-arrow-left me-2"></i> Kembali
                </a>
            </div>


            <!-- Article Header -->
            <div class="mb-4">
                <div class="d-flex justify-content-between align-items-start mb-3">
                    <span class="badge rounded-pill px-3 py-2"
                          style="background-color: {{ $article->status == 'Published' ? '#E6F7F1' : '#f5f5f5' }};
                                color: {{ $article->status == 'Published' ? '#36b37e' : '#6c757d' }};">
                        {{ $article->status }}
                    </span>
                    <div class="text-muted small">
                        <i class="far fa-calendar-alt me-1"></i> {{ $article->created_at->format('d M Y') }}
                    </div>
                </div>

                <h1 class="fw-bold mb-3">{{ $article->title }}</h1>

                <div class="d-flex align-items-center mb-4">
                    <div class="d-flex justify-content-center align-items-center rounded-circle me-3"
                         style="width: 40px; height: 40px; background-color: #F0F5FF;">
                        <i class="fas fa-user" style="color: #5B93FF;"></i>
                    </div>
                    <div>
                        <p class="mb-0 fw-medium">{{ $article->author }}</p>
                        <p class="text-muted small mb-0">Author</p>
                    </div>
                </div>

                @if($article->thumbnail)
                    <div class="text-center my-4">
                        <img src="{{ asset('storage/' . $article->thumbnail) }}" alt="Thumbnail"
                             class="img-fluid mx-auto d-block"
                             style="max-width: 100%; height: auto; border-radius: 16px;">
                    </div>
                @endif
            </div>


            <!-- Article Content -->
            <div class="mb-4">
                <!-- Description Section -->
                <div class="article-description mb-4">
                    <div class="p-3 rounded-3" style="background-color: #F8FAFD;">
                        <p class="lead mb-0" style="color: #5F738C;">{{ $article->description }}</p>
                    </div>
                </div>

                <!-- Main Content -->
                @if($article->subheadings->count())
                    <div class="article-content">
                        @foreach($article->subheadings as $subheading)
                            <div class="subheading-section mb-4">
                                <h3 class="fw-bold mb-3" style="color: #3A4A5C; padding-bottom: 10px; border-bottom: 2px solid #F0F5FF;">
                                    {{ $subheading->title }}
                                </h3>
                                @foreach($subheading->paragraphs as $paragraph)
                                    <div class="paragraph mb-4">
                                        <p style="line-height: 1.8; color: #5F738C;">{{ $paragraph->content }}</p>
                                    </div>
                                @endforeach
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>

        </div>
    </div>
</div>

<style>
    .article-content h3 {
        font-size: 1.5rem;
    }

    .article-content p {
        font-size: 1.05rem;
    }

    .lead {
        font-size: 1.15rem;
        font-weight: 400;
    }
    .btn:hover {
    transform: translateY(-1px);
    box-shadow: 0 4px 8px rgba(108, 99, 255, 0.3);
}


    @media (max-width: 768px) {
        .article-content h3 {
            font-size: 1.3rem;
        }

        img.img-fluid {
            max-width: 100% !important;
        }
    }
</style>
@endsection
