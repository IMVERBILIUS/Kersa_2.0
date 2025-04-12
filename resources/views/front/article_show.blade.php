@extends('layouts.master')

@section('content')
<div class="container mt-5">
    <div class="card">
        <div class="card-body">
            <h1>{{ $article->title }}</h1>
            <p class="text-muted">Published on {{ $article->created_at->format('F d, Y') }} | Views: {{ $article->views }}</p>
            <hr>
            <div>
                {!! nl2br(e($article->content)) !!}
            </div>
        </div>
    </div>
    <a href="{{ route('front.articles') }}" class="btn btn-warning mt-3"><i class="fa fa-arrow-left"></i> Back to Articles</a>
</div>
@endsection
