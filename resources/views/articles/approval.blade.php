@extends('layouts.admin')

@section('content')
<div class="container">
    <h2 class="mb-4">Draft Articles for Approval</h2>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if($draftArticles->isEmpty())
        <div class="alert alert-info">No draft articles available.</div>
    @else
        <table class="table table-bordered">
            <thead class="table-dark">
                <tr>
                    <th>Title</th>
                    <th>Author</th>
                    <th>Created At</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($draftArticles as $article)
                    <tr>
                        <td>{{ $article->title }}</td>
                        <td>{{ $article->author ?? 'Unknown' }}</td>
                        <td>{{ $article->created_at->format('d M Y') }}</td>
                        <td>
                            <span class="badge bg-warning text-dark">{{ ucfirst($article->status) }}</span>
                        </td>
                        <td>
                            <form action="{{ route('articles.updateStatus', $article->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to publish this article?')">
                                @csrf
                                @method('PUT')
                                <button type="submit" class="btn btn-success btn-sm">Publish</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
@endsection
