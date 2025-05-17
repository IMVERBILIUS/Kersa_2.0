@extends('layouts.admin')

@section('content')
<div class="container-fluid px-4">
    <div class="d-flex justify-content-between mb-4">
        <a href="{{ route('admin.galleries.manage') }}" class="btn px-4 py-2"
            style="background-color: #F0F5FF; color: #5B93FF; border-radius: 8px;">
            <i class="fas fa-arrow-left me-2"></i> Back
        </a>
    </div>

    <div class="card shadow-sm border-0 mb-4 rounded-4">
        <div class="card-body p-4">
            <form action="{{ route('admin.galleries.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="row mb-4">
                    <!-- Thumbnail -->
                    <div class="col-md-6">
                        <label class="form-label text-secondary fw-medium">Thumbnail</label>
                        <div class="position-relative border rounded-3 d-flex align-items-center justify-content-center" style="height: 240px;">
                            <input type="file" id="thumbnail" name="thumbnail" accept="image/*" class="position-absolute w-100 h-100 opacity-0 cursor-pointer" style="z-index: 3;">
                            <div class="position-absolute w-100 h-100 d-flex align-items-center justify-content-center border border-success bg-white rounded-3" style="pointer-events: none;">
                                <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" fill="none" viewBox="0 0 24 24" stroke="#36b37e" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 5v14m-7-7h14"/>
                                </svg>
                            </div>
                        </div>
                    </div>

                    <!-- Basic Info -->
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label text-secondary fw-medium">Nama Karya</label>
                            <input type="text" class="form-control border-success rounded-3" name="title" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label text-secondary fw-medium">Author</label>
                            <input type="text" class="form-control border-success rounded-3" name="author">
                        </div>

                        <div class="mb-3">
                            <label class="form-label text-secondary fw-medium">Status</label>
                            <select name="status" class="form-select border-success rounded-3" required>
                                <option value="Draft">Draft</option>
                                <option value="Published">Published</option>
                            </select>
                        </div>
                    </div>
                </div>

                <!-- Info Tambahan -->
                <div class="row mb-4">
                    <div class="col-md-6 mb-3">
                        <label class="form-label text-secondary fw-medium">Lokasi</label>
                        <input type="text" class="form-control border-success rounded-3" name="location">
                    </div>
                    <div class="col-md-3 mb-3">
                        <label class="form-label text-secondary fw-medium">Luas Tanah (m²)</label>
                        <input type="number" class="form-control border-success rounded-3" name="land_area">
                    </div>
                    <div class="col-md-3 mb-3">
                        <label class="form-label text-secondary fw-medium">Luas Bangunan (m²)</label>
                        <input type="number" class="form-control border-success rounded-3" name="building_area">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label text-secondary fw-medium">Fungsi</label>
                        <input type="text" class="form-control border-success rounded-3" name="function">
                    </div>
                </div>

                <!-- Deskripsi -->
                <div class="mb-4">
                    <label class="form-label text-secondary fw-medium">Deskripsi</label>
                    <textarea class="form-control border-success rounded-3" name="description" rows="4"></textarea>
                </div>

                <!-- Upload Gambar Galeri -->
                <div class="mb-4">
                    <label class="form-label text-secondary fw-medium">Gallery Images</label>
                    <div id="gallery-image-container" class="d-flex flex-wrap gap-3">
                        <div class="gallery-image-group" style="width: 200px;">
                            <input type="file" name="gallery_images[]" accept="image/*" class="form-control border-success rounded-3 preview-gallery-image" style="padding: .375rem .75rem;">
                            <img src="#" class="img-thumbnail mt-2 d-none gallery-preview" style="width: 100%; height: 150px; object-fit: cover; border-radius: 8px;">
                            <button type="button" class="btn btn-danger btn-sm mt-2 w-100 remove-gallery-image">Remove</button>
                        </div>
                    </div>
                    <button type="button" id="add-gallery-image" class="btn btn-primary btn-sm mt-3">
                        <i class="fas fa-plus me-1"></i> Add More Images
                    </button>
                </div>

                <!-- Subtitle & Paragraph -->
                <div id="content-container">
                    <div class="content-group mb-4 border-0">
                        <label class="form-label text-secondary fw-medium">Subtitle</label>
                        <input type="text" name="contents[0][subtitle]" class="form-control border-success rounded-3 mb-3" required>

                        <div class="paragraph-container">
                            <label class="form-label text-secondary fw-medium">Paragraph</label>
                            <textarea name="contents[0][paragraphs][0][content]" class="form-control border-success rounded-3 mb-3" rows="4" required></textarea>
                        </div>

                        <button type="button" class="btn btn-primary btn-sm add-paragraph">Add Paragraph</button>
                        <button type="button" class="btn btn-danger btn-sm ms-2 remove-subtitle">Remove Subtitle</button>
                    </div>
                </div>

                <div class="d-flex justify-content-center mb-4">
                    <button type="button" id="add-subtitle-group" class="btn btn-primary px-4 py-2">
                        <i class="fas fa-plus me-1"></i> Add Subtitle & Paragraph
                    </button>
                </div>

                <div class="d-flex justify-content-start">
                    <button type="submit" class="btn btn-success px-4 py-2">Simpan Galeri</button>
                    <a href="{{ route('admin.galleries.manage') }}" class="btn btn-outline-secondary ms-2 px-4 py-2">Batal</a>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
    // Subtitle & Paragraph management
    let subtitleIndex = 1;

    document.getElementById('add-subtitle-group').addEventListener('click', function () {
        const container = document.getElementById('content-container');
        const group = document.createElement('div');
        group.classList.add('content-group', 'mb-4', 'border-0');
        group.innerHTML = `
            <label class="form-label text-secondary fw-medium">Subtitle</label>
            <input type="text" name="contents[${subtitleIndex}][subtitle]" class="form-control border-success rounded-3 mb-3" required>

            <div class="paragraph-container">
                <label class="form-label text-secondary fw-medium">Paragraph</label>
                <textarea name="contents[${subtitleIndex}][paragraphs][0][content]" class="form-control border-success rounded-3 mb-3" rows="4" required></textarea>
            </div>

            <button type="button" class="btn btn-primary btn-sm add-paragraph">Add Paragraph</button>
            <button type="button" class="btn btn-danger btn-sm ms-2 remove-subtitle">Remove Subtitle</button>
        `;
        container.appendChild(group);
        subtitleIndex++;
    });

    document.getElementById('content-container').addEventListener('click', function (e) {
        if (e.target.classList.contains('add-paragraph')) {
            const group = e.target.closest('.content-group');
            const subtitleInput = group.querySelector('input[name^="contents"]');
            const subtitleMatch = subtitleInput.name.match(/contents\[(\d+)\]/);
            const index = subtitleMatch ? subtitleMatch[1] : 0;

            const paragraphContainer = group.querySelector('.paragraph-container');
            const paragraphCount = paragraphContainer.querySelectorAll('textarea').length;

            const div = document.createElement('div');
            div.classList.add('mb-3');
            div.innerHTML = `
                <label class="form-label text-secondary fw-medium">Paragraph</label>
                <textarea name="contents[${index}][paragraphs][${paragraphCount}][content]" class="form-control border-success rounded-3 mb-3" rows="4" required></textarea>
                <button type="button" class="btn btn-danger btn-sm remove-paragraph">Remove Paragraph</button>
            `;
            paragraphContainer.appendChild(div);
        }

        if (e.target.classList.contains('remove-paragraph')) {
            e.target.closest('div.mb-3').remove();
        }

        if (e.target.classList.contains('remove-subtitle')) {
            e.target.closest('.content-group').remove();
        }
    });

    // Gallery Images preview & management
    function setupPreview(input) {
        input.addEventListener('change', function () {
            const file = input.files[0];
            const preview = input.parentElement.querySelector('.gallery-preview');
            if (file) {
                const reader = new FileReader();
                reader.onload = function (e) {
                    preview.src = e.target.result;
                    preview.classList.remove('d-none');
                }
                reader.readAsDataURL(file);
            } else {
                preview.src = '#';
                preview.classList.add('d-none');
            }
        });
    }

    // Setup preview for existing inputs
    document.querySelectorAll('.preview-gallery-image').forEach(input => {
        setupPreview(input);
    });

    // Add new gallery image input with preview and remove button
    document.getElementById('add-gallery-image').addEventListener('click', function () {
        const container = document.getElementById('gallery-image-container');
        const div = document.createElement('div');
        div.classList.add('gallery-image-group');
        div.style.width = '200px';
        div.innerHTML = `
            <input type="file" name="gallery_images[]" accept="image/*" class="form-control border-success rounded-3 preview-gallery-image" style="padding: .375rem .75rem;">
            <img src="#" class="img-thumbnail mt-2 d-none gallery-preview" style="width: 100%; height: 150px; object-fit: cover; border-radius: 8px;">
            <button type="button" class="btn btn-danger btn-sm mt-2 w-100 remove-gallery-image">Remove</button>
        `;
        container.appendChild(div);

        // Setup preview for new input
        setupPreview(div.querySelector('.preview-gallery-image'));
    });

    // Remove gallery image group
    document.getElementById('gallery-image-container').addEventListener('click', function (e) {
        if (e.target.classList.contains('remove-gallery-image')) {
            e.target.closest('.gallery-image-group').remove();
        }
    });

    // Thumbnail preview
    document.getElementById
('thumbnail').addEventListener('change', function () {
const file = this.files[0];
if (file) {
const reader = new FileReader();
reader.onload = function (e) {
// Jika mau tampilkan preview thumbnail, bisa tambahkan elemen img dan update src di sini
// Misal buat elemen img preview di samping input thumbnail
}
reader.readAsDataURL(file);
}
});
</script>
@endpush
@endsection
