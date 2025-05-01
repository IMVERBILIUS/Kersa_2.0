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
                        <i class="fas fa-image fs-2" style="color: #36b37e;"></i>
                    </div>
                    <div>
                        <h2 class="fs-3 fw-bold mb-1">Approval Galleries</h2>
                        <p class="text-muted mb-0">Manage your published and draft galleries</p>
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
                <select name="sort" class="form-select form-select-sm border-0" onchange="this.form.submit()" style="width: auto;">
                    <option value="latest" {{ request('sort') == 'latest' ? 'selected' : '' }}>Latest</option>
                    <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>Newest</option>
                </select>
            </form>
        </div>
    </div>

    {{-- Table --}}
    <div class="card shadow-sm border-0">
        <div class="card-body p-0">
            @if (session('success'))
                <div class="alert alert-success m-3 mb-0">
                    <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                </div>
            @endif

            @if($draftGalleries->isEmpty())
                <div class="alert alert-info m-3">
                    <i class="fas fa-info-circle me-2"></i>No draft galleries available.
                </div>
            @else
                <div class="table-responsive p-4">
                    <table class="table table-hover align-middle">
                        <thead>
                            <tr>
                                <th style="color: #B5B7C0;">Thumbnail</th>
                                <th style="color: #B5B7C0;">Title</th>
                                <th style="color: #B5B7C0;">Author</th>
                                <th style="color: #B5B7C0;">Created At</th>
                                <th style="color: #B5B7C0;">Status</th>
                                <th style="color: #B5B7C0;">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($draftGalleries as $gallery)
                                <tr style="border-bottom: 1px solid #eee;">
                                    <td class="py-3">
                                        @if($gallery->thumbnail)
                                            <img src="{{ asset('storage/' . $gallery->thumbnail) }}"
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
                                    <td class="py-3">{{ $gallery->title }}</td>
                                    <td class="py-3">{{ $gallery->author ?? 'Unknown' }}</td>
                                    <td class="py-3">{{ $gallery->created_at->format('d M Y') }}</td>
                                    <td class="py-3">
                                        <span class="badge rounded-pill px-3 py-2"
                                              style="background-color: #FFC107; color: #212529;">
                                            {{ ucfirst($gallery->status) }}
                                        </span>
                                    </td>
                                    <td class="py-3">
                                        <div class="d-flex gap-2">
                                            <form action="{{ route('galleries.updateStatus', $gallery->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('PUT')
                                                <button type="submit" class="btn btn-success badge rounded-pill btn-sm px-3 py-2"
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

    {{-- Pagination --}}
    @if ($draftGalleries->hasPages())
        <div class="mt-4 d-flex justify-content-center">
            {{ $draftGalleries->links('pagination::bootstrap-5') }}
        </div>
    @endif
</div>

{{-- SweetAlert --}}
<script>
function confirmPublish(event, form) {
    event.preventDefault();
    Swal.fire({
        title: 'Are you sure?',
        text: "You want to publish this gallery?",
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
