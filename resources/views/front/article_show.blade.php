@extends('layouts.master')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-lg-12">

            {{-- Back Button --}}
            <div class="d-flex justify-content-between mb-4 ">
                <a href="{{ route('front.articles') }}" class="btn px-4 py-2"
                   style="background-color: #F0F5FF; ; border-radius: 8px;">
                    <i class="fas fa-arrow-left me-2"></i> Back
                </a>
            </div>
            <!-- Article Header Card -->
            <div class="border-0 rounded-4  mb-4">
                <div class=" ">
                   

                    <h1 class="fw-bold mb-3">{{ $article->title }}</h1>

                    <div class="d-flex align-items-center justify-content-between">

                        
                        <div class="d-flex align-items-center ">
                            <div class="d-flex justify-content-center align-items-center rounded-circle me-3"
                            style="width: 40px; height: 40px; background-color: #F0F5FF;">
                            <i class="fas fa-user" style="color: #5B93FF;"></i>
                        </div>
                        <div>
                            <p class="mb-0 fw-medium">{{ $article->author }}</p>
                            <p class="text-muted small mb-0">Author</p>
                        </div>
                    </div>
                    <div class="d-flex justify-content-end align-items-start ">
                        <div class="text-muted small">
                            <i class="far fa-calendar-alt me-1"></i> {{ $article->created_at->format('d M Y') }}
                        </div>
                    </div>
                </div>


                    @if($article->thumbnail)
                        <div class="text-center my-4 rounded-3 overflow-hidden" style="box-shadow: 0 3px 10px rgba(0,0,0,0.05);">
                            <img src="{{ asset('storage/' . $article->thumbnail) }}" alt="Thumbnail"
                                 class="img-fluid w-100" style="max-height: 500px; object-fit: cover;">
                        </div>
                    @endif
                </div>
            </div>

            <!-- Article Content Card -->
            <div class="border-0 rounded-4  mb-4">
                <div class="">
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
    }
</style>
@endsection
