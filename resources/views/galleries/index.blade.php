@extends('layouts.admin')

@section('content')
<style>
.custom-select-dropdown {
    background-color: #f5f5f5;
    border-radius: 0.375rem;
    padding: 0.5rem 1rem;
    font-size: 0.875rem;
    font-weight: 500;
    color: #495057;
    transition: all 0.3s ease;
}
.custom-select-dropdown:focus {
    border-color: #36b37e;
    box-shadow: 0 0 0 0.2rem rgba(54, 179, 126, 0.25);
}
</style>

<div class="container-fluid px-4" style="min-height: 100vh;">

    {{-- Header --}}
    <div class="row mb-4">
        <div class="col-12">
            <div class="bg-white rounded-4 shadow-sm p-4">
                <div class="d-flex align-items-center">
                    <div class="d-flex justify-content-center align-items-center rounded-circle me-4"
                         style="width: 70px; height: 70px; background-color: #e6f7f1;">
                        <i class="fas fa-images fs-2" style="color: #36b37e;"></i>
                    </div>
                    <div>
                        <h2 class="fs-3 fw-bold mb-1">Manage Gallery</h2>
                        <p class="text-muted mb-0">Manage your gallery items and media</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Add Button --}}
    <div class="row mb-4">
        <div class="col-md-12 d-flex justify-content-end">
            <a href="{{ route('admin.galleries.create') }}" class="btn btn-success d-flex align-items-center px-3 py-2 rounded-3"
               style="background-color: #36b37e; border: none;">
                <i class="fas fa-plus me-2"></i>
                <span class="fw-small">Add New Gallery</span>
            </a>
        </div>
    </div>

    {{-- Gallery Table --}}
    <div class="card border-0 rounded-4 shadow-sm">
        <div class="card-body p-4">
            @if(session('success'))
                <div class="alert alert-success rounded-3"><i class="fas fa-check-circle me-2"></i>{{ session('success') }}</div>
            @endif

            {{-- Sort Filter --}}
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1 class="fs-5 fw-semibold">All Galleries</h1>
                <form method="GET" class="d-flex align-items-center gap-2">
                    <span class="text-muted">Sort by:</span>
                    <select name="sort" class="form-select form-select-sm custom-select-dropdown border-0" onchange="this.form.submit()" style="width: auto;">
                        <option value="latest" {{ request('sort') == 'latest' ? 'selected' : '' }}>Newest</option>
                        <option value="oldest" {{ request('sort') == 'oldest' ? 'selected' : '' }}>Oldest</option>
                        <option value="view" {{ request('sort') == 'view' ? 'selected' : '' }}>Views</option>
                    </select>
                </form>
            </div>

            {{-- Table --}}
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead>
                        <tr style="border-bottom: 1px solid #eee;">
                            <th style="color: #B5B7C0;">Thumbnail</th>
                            <th style="color: #B5B7C0;">Name</th>
                            <th style="color: #B5B7C0;">Author</th>
                            <th style="color: #B5B7C0;">Status</th>
                            <th style="color: #B5B7C0;">Views</th>
                            <th style="color: #B5B7C0;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($galleries as $gallery)
                            <tr style="border-bottom: 1px solid #eee;">
                                <td class="py-3">
                                    @if($gallery->thumbnail)
                                        <img src="{{ asset('storage/' . $gallery->thumbnail) }}" alt="thumbnail" class="rounded-3 object-fit-cover" style="width: 200px; height: 100px;">
                                    @else
                                        <div class="bg-light rounded-3 d-flex justify-content-center align-items-center" style="width: 200px; height: 100px;">
                                            <span class="text-muted small">No Image</span>
                                        </div>
                                    @endif
                                </td>
                                <td class="py-3">{{ $gallery->title }}</td>
                                <td class="py-3">{{ $gallery->author ?? '-' }}</td>
                                <td class="py-3">
                                    <span class="badge rounded-pill px-3 py-2"
                                          style="background-color: {{ $gallery->status == 'Published' ? '#E6F7F1' : '#f5f5f5' }};
                                                 color: {{ $gallery->status == 'Published' ? '#36b37e' : '#6c757d' }};">
                                        {{ $gallery->status }}
                                    </span>
                                </td>
                                <td class="py-3">{{ $gallery->views }}</td>
                                <td class="py-3">
                                    <div class="d-flex gap-2">
                                        <a href="{{ route('admin.galleries.show', $gallery->id) }}" class="btn btn-outline-dark btn-sm px-2 py-1 rounded-2">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('admin.galleries.edit', $gallery->id) }}" class="btn btn-outline-dark btn-sm px-2 py-1 rounded-2">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('admin.galleries.delete', $gallery->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" onclick="confirmDelete(event, this.parentElement)" class="btn btn-outline-dark btn-sm px-2 py-1 rounded-2">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-4 text-muted">No galleries found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Pagination --}}
            @if($galleries->hasPages())
                <div class="mt-4 d-flex justify-content-center">
                    <nav aria-label="Gallery pagination">
                        <ul class="pagination pagination-sm mb-0">
                            @if ($galleries->onFirstPage())
                                <li class="page-item disabled"><span class="page-link rounded-3">&laquo;</span></li>
                            @else
                                <li class="page-item">
                                    <a class="page-link rounded-3" href="{{ $galleries->previousPageUrl() }}" rel="prev">&laquo;</a>
                                </li>
                            @endif

                            @php
                                $currentPage = $galleries->currentPage();
                                $lastPage = $galleries->lastPage();
                                $pageRange = 5;
                                $startPage = max(1, $currentPage - floor($pageRange / 2));
                                $endPage = min($lastPage, $currentPage + floor($pageRange / 2));
                                if ($currentPage < floor($pageRange / 2)) {
                                    $endPage = min($lastPage, $pageRange);
                                }
                                if ($currentPage > $lastPage - floor($pageRange / 2)) {
                                    $startPage = max(1, $lastPage - $pageRange + 1);
                                }
                            @endphp

                            @for ($i = $startPage; $i <= $endPage; $i++)
                                @if ($i == $currentPage)
                                    <li class="page-item active">
                                        <span class="page-link rounded-3" style="background-color: #36b37e; border-color: #36b37e;">{{ $i }}</span>
                                    </li>
                                @else
                                    <li class="page-item">
                                        <a class="page-link rounded-3" href="{{ $galleries->url($i) }}">{{ $i }}</a>
                                    </li>
                                @endif
                            @endfor

                            @if ($galleries->hasMorePages())
                                <li class="page-item">
                                    <a class="page-link rounded-3" href="{{ $galleries->nextPageUrl() }}" rel="next">&raquo;</a>
                                </li>
                            @else
                                <li class="page-item disabled"><span class="page-link rounded-3">&raquo;</span></li>
                            @endif
                        </ul>
                    </nav>
                </div>
            @endif

        </div>
    </div>
</div>

{{-- SweetAlert --}}
<script>
function confirmDelete(event, form) {
    event.preventDefault();

    Swal.fire({
        title: "Yakin ingin menghapus?",
        text: "Data tidak bisa dikembalikan!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#24E491",
        cancelButtonColor: "#d33",
        confirmButtonText: "Ya, hapus!",
    }).then((result) => {
        if (result.isConfirmed) {
            form.submit();
            Swal.fire({
                title: "Berhasil!",
                text: "Gallery berhasil dihapus.",
                icon: "success",
                confirmButtonColor: "#24E491",
            });
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
