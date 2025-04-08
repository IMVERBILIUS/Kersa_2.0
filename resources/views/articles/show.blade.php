@extends('layouts.admin')

@section('content')
<div class="container">
    <h2 class="mb-3">{{ $article->title }}</h2>

    <div class="mb-2">
        <strong>Author:</strong> {{ $article->author }}
    </div>
    <div class="mb-2">
        <strong>Status:</strong>
        <span class="badge bg-{{ $article->status == 'Published' ? 'success' : 'warning' }}">
            {{ $article->status }}
        </span>
    </div>
    <div class="mb-2">
        <strong>Created at:</strong> {{ $article->created_at->format('d M Y') }}
    </div>

    @if($article->thumbnail)
        <div class="my-4">
            <img src="{{ asset('storage/' . $article->thumbnail) }}" alt="Thumbnail" class="img-fluid rounded" style="max-height: 300px;">
        </div>
    @endif

    <hr>
    <p>{{ $article->description }}</p>

    @if($article->subheadings->count())
        <div class="mt-4">
            @foreach($article->subheadings as $subheading)
                <h4 class="mt-4">{{ $subheading->title }}</h4>
                @foreach($subheading->paragraphs as $paragraph)
                    <p>{{ $paragraph->content }}</p>
                @endforeach
            @endforeach
        </div>
    @endif

    <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary mt-4">← Back to Dashboard</a>
</div>
@endsection
