@extends('layouts.admin')

@section('content')
    <h2>Dashboard</h2>
    <p>Welcome, {{ Auth::user()->name }}!</p>

    <h4>All Articles</h4>

    @if($articles->count())
        @foreach($articles as $article)
            <div class="card mb-3">
                <div class="card-body">
                    <h5 class="card-title">{{ $article->title }}</h5>
                    <p class="card-text">{{ Str::limit($article->description, 150) }}</p>
                    <span class="badge bg-info">Status: {{ $article->status }}</span>
                    <span class="badge bg-secondary">Views: {{ $article->views }}</span>

                    <div class="mt-3">
                        <a href="{{ route('articles.show', $article->id) }}" class="btn btn-primary btn-sm">Detail</a>
                    </div>
                </div>
            </div>
        @endforeach
    @else
        <p>No articles found.</p>
    @endif
@endsection
