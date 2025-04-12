@extends('layouts.admin')

@section('content')
<div class="container-fluid px-4 " style="min-height: 100vh; ">

    {{-- Article Header --}}
     <div class="row mb-4">
        <div class="col-12">
            <div class="bg-white rounded-4 shadow-sm p-4">
                <div class="d-flex align-items-center">
                    <div class="d-flex justify-content-center align-items-center rounded-circle me-4"
                         style="width: 70px; height: 70px; background-color: #e6f7f1;">
                        <i class="fas fa-file-alt fs-2" style="color: #36b37e;"></i>
                    </div>
                    <div>
                        <h2 class="fs-3 fw-bold mb-1 ">Manage Article</h2>
                        <p class="text-muted mb-0">Manage your published and draft articles</p>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- Add Button -->
    <div class="row mb-4">

        <div class="col-md-12 d-flex justify-content-end">
            <a href="{{ route('admin.articles.create') }}" class="btn btn-success d-flex align-items-center px-3 py-2 rounded-3"
               style="background-color: #36b37e; border: none;">
                <i class="fas fa-plus me-2"></i>
                <span class="fw-small ">Add New Article</span>
            </a>
        </div>
    </div>

    <!-- Article Table -->
    <div class="card border-0 rounded-4 shadow-sm">
        <div class="card-body p-4">
            <div class="col-md-6">
                @if(session('success'))
                    <div class="alert alert-success rounded-3"><i class="fas fa-check-circle me-2"></i>{{ session('success') }}</div>
                @endif
            </div>
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1 class="fs-5 fw-semibold">All Articles</h1>
                <div>
                    <span>Sort by:</span>
                    <select class="form-select form-select-sm border-0 d-inline-block ms-2" style="color: #B5B7C0; width: auto;">
                        <option value="date">Date</option>
                        <option value="view">Views</option>
                        <option value="status">Status</option>
                    </select>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead>
                        <tr style="border-bottom: 1px solid #eee;">
                            <th class="fw-medium" style="color: #B5B7C0;">Thumbnail</th>
                            <th class="fw-medium" style="color: #B5B7C0;">Title</th>
                            <th class="fw-medium" style="color: #B5B7C0;">Status</th>
                            <th class="fw-medium" style="color: #B5B7C0;">Views</th>
                            <th class="fw-medium" style="color: #B5B7C0;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($articles as $index => $article)
                            <tr style="border-bottom: 1px solid #eee;">
                                <td class="py-3">
                                    @if($article->thumbnail)
                                      <img src="{{ asset('storage/' . $article->thumbnail) }}" alt="thumbnail" class="rounded-3 object-fit-cover" style="width: 200px; height: 100px;">

                                    @else
                                        <div class="bg-light rounded-3 d-flex justify-content-center align-items-center" style="width: 104px; height: 72px;">
                                            <span class="text-muted small">No Image</span>
                                        </div>
                                    @endif
                                </td>
                                <td class="py-3">{{ $article->title }}</td>
                                <td class="py-3">
                                    <span class="badge rounded-pill px-3 py-2"
                                          style="background-color: {{ $article->status == 'Published' ? '#E6F7F1' : '#f5f5f5' }};
                                                 color: {{ $article->status == 'Published' ? '#36b37e' : '#6c757d' }};">
                                        {{ $article->status }}
                                    </span>
                                </td>
                                <td class="py-3">{{ $article->views }}</td>
                                <td class="py-3">
                                    <div class="d-flex gap-2">
                                        <a href="{{ route('front.articles.show', $article->id) }}" class="btn btn-outline-dark btn-sm px-2 py-1" style="border-radius: 6px;">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('admin.articles.edit', $article->id) }}" class="btn btn-outline-dark btn-sm px-2 py-1" style="border-radius: 6px;">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('admin.articles.delete', $article->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" onclick="confirmDelete(event, this.parentElement)" class="btn btn-outline-dark btn-sm px-2 py-1" style="border-radius: 6px;">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-4 text-muted">No articles found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="d-flex justify-content-between align-items-center mt-4">
                <div>
                    <p class="text-muted" style="color: #B5B7C0;">Showing data 1 to {{ min(count($articles), 6) }} of {{ count($articles) }} entries</p>
                </div>
                <nav aria-label="Page navigation">
                    <ul class="pagination">
                        <li class="page-item">
                            <a class="page-link" href="#" aria-label="Previous" style="background-color: #F5F5F5; border-color: #EEEEEE; color: #333;">
                                <span aria-hidden="true">&laquo;</span>
                            </a>
                        </li>
                        <li class="page-item active">
                            <a class="page-link" href="#" style="width: 40px; height: 40px; display: flex; align-items: center; justify-content: center; background-color: #5932EA; border-color: #5932EA;">1</a>
                        </li>
                        <li class="page-item">
                            <a class="page-link" href="#" style="width: 40px; height: 40px; display: flex; align-items: center; justify-content: center; background-color: #F5F5F5; border-color: #EEEEEE; color: #333;">2</a>
                        </li>
                        <li class="page-item">
                            <a class="page-link" href="#" style="width: 40px; height: 40px; display: flex; align-items: center; justify-content: center; background-color: #F5F5F5; border-color: #EEEEEE; color: #333;">3</a>
                        </li>
                        <li class="page-item">
                            <a class="page-link" href="#" aria-label="Next" style="background-color: #F5F5F5; border-color: #EEEEEE; color: #333;">
                                <span aria-hidden="true">&raquo;</span>
                            </a>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>
    </div>
</div>

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
                text: "Artikel berhasil dihapus.",
                icon: "success",
                confirmButtonColor: "#24E491",
            });
        }
    });
}

// Show success message using SweetAlert
@if(session('success'))
    const Toast = Swal.mixin({
        toast: true,
        position: "top-end",
        showConfirmButton: false,
        timer: 2000,
        didOpen: (toast) => {
            toast.onmouseenter = Swal.stopTimer;
            toast.onmouseleave = Swal.resumeTimer;
        },
    });
    Toast.fire({
        icon: "success",
        title: "{{ session('success') }}"
    });
@endif
</script>
@endsection
