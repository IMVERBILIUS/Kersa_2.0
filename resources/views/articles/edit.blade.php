@extends('layouts.admin')

@section('content')
<div class="container-fluid px-4">
    {{-- Back Button --}}
    <div class="d-flex justify-content-between mb-4">
        <a href="{{ route('admin.articles.manage') }}" class="btn px-4 py-2" 
            style="background-color: #F0F5FF; color: #5B93FF; border-radius: 8px;">
            <i class="fas fa-arrow-left me-2"></i> Back
        </a>
    </div>

    <div class="card shadow-sm border-0 mb-4 rounded-4">
        <div class="card-body p-4">
            <form action="{{ route('admin.articles.update', $article->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="row mb-4">
                    <!-- Left Column - Thumbnail -->
                    <div class="col-md-6">
                        <label class="form-label text-secondary fw-medium">Thumbnail</label>
                        <div class="position-relative border rounded-3 d-flex align-items-center justify-content-center" style="height: 240px;">
                            <input type="file" id="thumbnail" name="thumbnail" accept="image/*" class="position-absolute w-100 h-100 opacity-0 cursor-pointer" style="z-index: 3;">
                            <div id="thumbnail-preview" class="position-absolute w-100 h-100 d-flex align-items-center justify-content-center border border-success bg-white rounded-3" style="pointer-events: none;">
                                @if ($article->thumbnail)
                                    <img src="{{ asset('storage/' . $article->thumbnail) }}" class="position-absolute w-100 h-100" style="object-fit: cover;">
                                @else
                                    <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" fill="none" viewBox="0 0 24 24" stroke="#36b37e" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 5v14m-7-7h14"/>
                                    </svg>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Right Column - Form Fields -->
                    <div class="col-md-6">
                        <div class="d-flex flex-column justify-content-between h-100">
                            <!-- Title -->
                            <div class="mb-3">
                                <label class="form-label text-secondary fw-medium">Article Title</label>
                                <input type="text" class="form-control border-success rounded-3" name="title" value="{{ old('title', $article->title) }}" required>
                            </div>

                            <!-- Author -->
                            <div class="mb-3">
                                <label class="form-label text-secondary fw-medium">Author</label>
                                <input type="text" class="form-control border-success rounded-3" name="author" value="{{ old('author', $article->author) }}" required>
                            </div>

                            <!-- Status -->
                            <div class="mb-3">
                                <label class="form-label text-secondary fw-medium">Publish Status</label>
                                <select name="status" class="form-select border-success rounded-3" required>
                                    <option value="Draft" {{ $article->status === 'Draft' ? 'selected' : '' }}>Draft</option>
                                    <option value="Published" {{ $article->status === 'Published' ? 'selected' : '' }}>Published</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Description -->
                <div class="mb-4">
                    <label class="form-label text-secondary fw-medium">Description</label>
                    <textarea class="form-control border-success rounded-3" name="description" rows="3">{{ old('description', $article->description) }}</textarea>
                </div>

                <!-- Dynamic Subheadings and Paragraphs -->
                <div id="subheading-container">
                    @foreach($article->subheadings as $subIndex => $subheading)
                        <div class="subheading-group border-0 mb-4">
                            <div class="">
                                <input type="hidden" name="subheadings[{{ $subIndex }}][id]" value="{{ $subheading->id }}">
                                <label class="form-label text-secondary fw-medium">Subheading</label>
                                <input type="text" name="subheadings[{{ $subIndex }}][title]" value="{{ $subheading->title }}" class="form-control border-success rounded-3 mb-3" required>

                                <div class="paragraph-container mb-3">
                                    @foreach($subheading->paragraphs as $paraIndex => $paragraph)
                                        <div class="mb-3">
                                            <input type="hidden" name="subheadings[{{ $subIndex }}][paragraphs][{{ $paraIndex }}][id]" value="{{ $paragraph->id }}">
                                            <label class="form-label text-secondary fw-medium">Paragraph</label>
                                            <textarea name="subheadings[{{ $subIndex }}][paragraphs][{{ $paraIndex }}][content]" class="form-control border-success rounded-3 mb-3" rows="5" required>{{ $paragraph->content }}</textarea>
                                        </div>
                                    @endforeach
                                </div>

                                <button type="button" class="btn btn-primary add-paragraph">
                                    <i class="fas fa-plus me-1"></i> Add Paragraph
                                </button>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="d-flex justify-content-center mb-4">
                    <button type="button" id="add-subheading" class="btn btn-primary px-4 py-2">
                        <i class="fas fa-plus me-1"></i> Add Subheading
                    </button>
                </div>

                <div class="d-flex justify-content-start">
                    <button type="submit" class="btn btn-success px-4 py-2">Update Article</button>
                    <a href="{{ route('admin.articles.manage') }}" class="btn btn-outline-secondary ms-2 px-4 py-2">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>

@push('styles')
<style>
    .form-control:focus, .form-select:focus {
        border-color: #24E491;
        box-shadow: 0 0 0 0.25rem rgba(36, 228, 145, 0.25);
    }
    
    .btn-primary {
        background-color: #5932EA;
        border-color: #5932EA;
    }
    
    .btn-primary:hover {
        background-color: #4920D5;
        border-color: #4920D5;
    }
    
    .btn-success {
        background-color: #24E491;
        border-color: #24E491;
    }
    
    .btn-success:hover {
        background-color: #1fb47a;
        border-color: #1fb47a;
    }
</style>
@endpush

@push('scripts')
<script>
    let subheadingIndex = {{ $article->subheadings->count() }};

    document.addEventListener('DOMContentLoaded', function () {
        const container = document.getElementById('subheading-container');
        const addSubheadingBtn = document.getElementById('add-subheading');

        // Preview uploaded image
        document.getElementById('thumbnail').addEventListener('change', function(e) {
            if (e.target.files && e.target.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const parent = document.getElementById('thumbnail').parentElement;
                    const overlay = parent.querySelector('div');
                    
                    // Create or update the preview image
                    let preview = parent.querySelector('img');
                    if (!preview) {
                        preview = document.createElement('img');
                        preview.classList.add('position-absolute', 'w-100', 'h-100');
                        preview.style.objectFit = 'cover';
                        parent.appendChild(preview);
                    }
                    
                    preview.src = e.target.result;
                    
                    // Hide the plus icon if it exists
                    const plusIcon = overlay.querySelector('svg');
                    if (plusIcon) {
                        plusIcon.style.display = 'none';
                    }
                }
                reader.readAsDataURL(e.target.files[0]);
            }
        });

        addSubheadingBtn.addEventListener('click', function () {
            let paragraphIndex = 0;
            const newSubheading = document.createElement('div');
            newSubheading.classList.add('subheading-group', 'border-0', 'mb-4');
            newSubheading.innerHTML = `
                <div class="">
                    <label class="form-label text-secondary fw-medium">Subheading</label>
                    <input type="text" name="subheadings[${subheadingIndex}][title]" class="form-control border-success rounded-3 mb-3" required>

                    <div class="paragraph-container mb-3">
                        <div class="mb-3">
                            <label class="form-label text-secondary fw-medium">Paragraph</label>
                            <textarea name="subheadings[${subheadingIndex}][paragraphs][${paragraphIndex}][content]" class="form-control border-success rounded-3 mb-3" rows="5" required></textarea>
                        </div>
                    </div>

                    <button type="button" class="btn btn-primary add-paragraph">
                        <i class="fas fa-plus me-1"></i> Add Paragraph
                    </button>
                </div>
            `;
            container.appendChild(newSubheading);
            subheadingIndex++;
        });

        container.addEventListener('click', function (e) {
            if (e.target.classList.contains('add-paragraph') || e.target.parentElement.classList.contains('add-paragraph')) {
                const subheadingGroup = e.target.closest('.subheading-group');
                const paragraphContainer = subheadingGroup.querySelector('.paragraph-container');
                const textareas = paragraphContainer.querySelectorAll('textarea');
                const newParagraphIndex = textareas.length;

                const nameSample = textareas[0].getAttribute('name');
                const subIndexMatch = nameSample.match(/subheadings\[(\d+)\]/);
                const subIndex = subIndexMatch ? subIndexMatch[1] : 0;

                const newParagraphDiv = document.createElement('div');
                newParagraphDiv.classList.add('mb-3');
                newParagraphDiv.innerHTML = `
                    <label class="form-label text-secondary fw-medium">Paragraph</label>
                    <textarea name="subheadings[${subIndex}][paragraphs][${newParagraphIndex}][content]" class="form-control border-success rounded-3 mb-3" rows="5" required></textarea>
                `;

                paragraphContainer.appendChild(newParagraphDiv);
            }
        });
    });
</script>
@endpush

@endsection