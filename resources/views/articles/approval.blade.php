@extends('layouts.admin')

@section('content')
<div class="container-fluid px-4">
    <div class="d-flex align-items-center justify-content-between mb-4">
        <h2 class="mb-0">Draft Articles for Approval</h2>
       
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-body p-0">
            @if (session('success'))
                <div class="alert alert-success m-3 mb-0">
                    <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                </div>
            @endif

            @if($draftArticles->isEmpty())
                <div class="alert alert-info m-3">
                    <i class="fas fa-info-circle me-2"></i>No draft articles available.
                </div>
            @else
                <div class="table-responsive rounded-4 p-4">
                    <table class="table table-hover mb-0">
                        <thead class="bg-light">
                            <tr>
                                <th class="px-4 py-3">Title</th>
                                <th class="px-4 py-3">Author</th>
                                <th class="px-4 py-3">Created At</th>
                                <th class="px-4 py-3">Status</th>
                                <th class="px-4 py-3 text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($draftArticles as $article)
                                <tr>
                                    <td class="px-4 py-3">
                                        <div class="d-flex align-items-center">
                                            @if($article->thumbnail)
                                                <div class="me-3">
                                                    <img src="{{ asset('storage/' . $article->thumbnail) }}" 
                                                        alt="Thumbnail" 
                                                        class="rounded" 
                                                        style="width: 50px; height: 50px; object-fit: cover;">
                                                </div>
                                            @endif
                                            <div>
                                                <h6 class="mb-0">{{ $article->title }}</h6>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-4 py-3">{{ $article->author ?? 'Unknown' }}</td>
                                    <td class="px-4 py-3">{{ $article->created_at->format('d M Y') }}</td>
                                    <td class="px-4 py-3">
                                        <span class="badge rounded-pill" style="background-color: #FFC107; color: #212529;">
                                            {{ ucfirst($article->status) }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-3">
                                        <div class="d-flex justify-content-center gap-2">
                                            
                                            <form action="{{ route('articles.updateStatus', $article->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('PUT')
                                                <button type="submit" class="btn btn-sm btn-success" 
                                                    onclick="return confirm('Are you sure you want to publish this article?')">
                                                    <i class="fas fa-check me-1"></i> Publish
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>
</div>

@push('styles')
<style>
    .table th {
        font-weight: 500;
        color: #6c757d;
        border-top: none;
    }
    
    .table td {
        vertical-align: middle;
    }
    
    .btn-success {
        background-color: #24E491;
        border-color: #24E491;
    }
    
    .btn-success:hover {
        background-color: #1fb47a;
        border-color: #1fb47a;
    }
    
    .btn-outline-primary {
        color: #5932EA;
        border-color: #5932EA;
    }
    
    .btn-outline-primary:hover {
        background-color: #5932EA;
        border-color: #5932EA;
    }
    
    .card {
        border-radius: 10px;
        overflow: hidden;
    }
    
    .alert {
        border-radius: 8px;
    }
</style>
@endpush

@endsection