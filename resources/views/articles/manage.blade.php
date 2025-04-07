@extends('layouts.admin')

@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4">Manage Articles</h1>
    <a href="{{ route('admin.articles.create') }}" class="btn btn-primary mb-3">+ Add Article</a>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-table me-1"></i>
            Article List
        </div>
        <div class="card-body">
            <table class="table table-bordered">
                <thead class="table-dark">
                    <tr>
                        <th>#</th>
                        <th>Title</th>
                        <th>Status</th>
                        <th>Views</th>
                        <th>Thumbnail</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($articles as $index => $article)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $article->title }}</td>
                            <td>
                                <span class="badge bg-{{ $article->status == 'Published' ? 'success' : 'secondary' }}">
                                    {{ $article->status }}
                                </span>
                            </td>
                            <td>{{ $article->views }}</td>
                            <td>
                                @if($article->thumbnail)
                                    <img src="{{ asset('storage/' . $article->thumbnail) }}" alt="thumb" width="60">
                                @else
                                    <em>No Image</em>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('admin.articles.edit', $article->id) }}" class="btn btn-warning btn-sm">Edit</a>
                                <form action="{{ route('admin.articles.delete', $article->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure to delete this article?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-danger btn-sm">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6">No articles found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
