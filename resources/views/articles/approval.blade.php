@extends('layouts.admin')

@section('content')
<div class="container-fluid px-4">
    {{-- Approval Header --}}
    <div class="row mb-4">
        <div class="col-12">
            <div class="bg-white rounded-4 shadow-sm p-4">
                <div class="d-flex align-items-center">
                    <div class="d-flex justify-content-center align-items-center rounded-circle me-4"
                         style="width: 70px; height: 70px; background-color: #e6f7f1;">
                        <i class="fas fa-check-circle fs-2" style="color: #36b37e;"></i>
                    </div>
                    <div>
                        <h2 class="fs-3 fw-bold mb-1">Approval Articles</h2>
                        <p class="text-muted mb-0">Manage your published and draft articles</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Sorting Form --}}
    <div class="row mb-4">
        <div class="col-12">
            <form method="GET" class="d-flex align-items-center gap-2">
                <span class="text-muted">Sort by:</span>
                <select name="sort" class="form-select form-select-sm custom-select-dropdown border-0" onchange="this.form.submit()" style="width: auto;">
                    <option value="latest" {{ request('sort') == 'latest' ? 'selected' : '' }}>Latest</option>
                    <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>Newest</option>
                </select>
            </form>
        </div>
    </div>

    {{-- Articles Table --}}
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
                <div class="table-responsive p-4">
                    <table class="table table-hover align-middle">
                        <thead>
                            <tr style="border-bottom: 1px solid #eee;">
                                <th class="fw-medium" style="color: #B5B7C0;">Thumbnail</th>
                                <th class="fw-medium" style="color: #B5B7C0;">Title</th>
                                <th class="fw-medium" style="color: #B5B7C0;">Author</th>
                                <th class="fw-medium" style="color: #B5B7C0;">Created At</th>
                                <th class="fw-medium" style="color: #B5B7C0;">Status</th>
                                <th class="fw-medium" style="color: #B5B7C0;">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($draftArticles as $article)
                               <tr style="border-bottom: 1px solid #eee;">
                                    <td class="py-3">
                                        @if($article->thumbnail)
                                            <img src="{{ asset('storage/' . $article->thumbnail) }}"
                                                alt="thumbnail"
                                                class="rounded-3 object-fit-cover"
                                                style="width: 150px; height: 80px;">
                                        @else
                                            <div class="bg-light rounded-3 d-flex justify-content-center align-items-center"
                                                style="width: 150px; height: 80px;">
                                                <span class="text-muted small">No Image</span>
                                            </div>
                                        @endif
                                    </td>
                                    <td class="py-3" style="max-width: 250px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">{{ $article->title }}</td>
                                    <td class="py-3">{{ $article->author ?? 'Unknown' }}</td>
                                    <td class="py-3">{{ $article->created_at->format('d M Y') }}</td>
                                    <td class="py-3">
                                        <span class="badge rounded-pill px-3 py-2"
                                              style="background-color: #FFC107; color: #212529;">
                                            {{ ucfirst($article->status) }}
                                        </span>
                                    </td>
                                    <td class="py-3">
                                        <div class="d-flex gap-2">
                                            <form action="{{ route('articles.updateStatus', $article->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('PUT')
                                                <button type="submit" class="btn btn-success badge rounded-pill btn-sm px-3 py-2"
                                                    style="border-radius: 6px;"
                                                    onclick="confirmPublish(event, this.parentElement)">
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

{{-- Custom Pagination --}}
@if ($draftArticles->hasPages())
    <div class="mt-4 d-flex justify-content-center">
        <nav aria-label="Article pagination">
            <ul class="pagination pagination-sm mb-0">
                {{-- Previous Page Link --}}
                @if ($draftArticles->onFirstPage())
                    <li class="page-item disabled"><span class="page-link rounded-3">&laquo;</span></li>
                @else
                    <li class="page-item">
                        <a class="page-link rounded-3" href="{{ $draftArticles->previousPageUrl() }}" rel="prev">&laquo;</a>
                    </li>
                @endif

                {{-- Pagination Elements --}}
                @php
                    $currentPage = $draftArticles->currentPage();
                    $lastPage = $draftArticles->lastPage();
                    $pageRange = 5;  // Number of page links to show at once

                    // Calculate the range of pages to show (for example, 1-5, 6-10)
                    $startPage = max(1, $currentPage - floor($pageRange / 2));
                    $endPage = min($lastPage, $currentPage + floor($pageRange / 2));

                    // Adjust the range if we're close to the start or end
                    if ($currentPage < floor($pageRange / 2)) {
                        $endPage = min($lastPage, $pageRange);
                    }

                    if ($currentPage > $lastPage - floor($pageRange / 2)) {
                        $startPage = max(1, $lastPage - $pageRange + 1);
                    }
                @endphp

                {{-- Page Number Links --}}
                @for ($i = $startPage; $i <= $endPage; $i++)
                    @if ($i == $currentPage)
                        <li class="page-item active">
                            <span class="page-link rounded-3" style="background-color: #36b37e; border-color: #36b37e;">{{ $i }}</span>
                        </li>
                    @else
                        <li class="page-item">
                            <a class="page-link rounded-3" href="{{ $draftArticles->url($i) }}">{{ $i }}</a>
                        </li>
                    @endif
                @endfor

                {{-- Next Page Link --}}
                @if ($draftArticles->hasMorePages())
                    <li class="page-item">
                        <a class="page-link rounded-3" href="{{ $draftArticles->nextPageUrl() }}" rel="next">&raquo;</a>
                    </li>
                @else
                    <li class="page-item disabled"><span class="page-link rounded-3">&raquo;</span></li>
                @endif
            </ul>
        </nav>
    </div>
@endif

</div>

{{-- SweetAlert --}}
<script>
function confirmPublish(event, form) {
    event.preventDefault();
    Swal.fire({
        title: 'Are you sure?',
        text: "You want to publish this article?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#24E491',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, publish it!'
    }).then((result) => {
        if (result.isConfirmed) {
            form.submit();
        }
    });
}

@if(session('success'))
Swal.fire({
    icon: 'success',
    title: "{{ session('success') }}",
    showConfirmButton: false,
    timer: 1500
});
@endif
</script>

@endsection
