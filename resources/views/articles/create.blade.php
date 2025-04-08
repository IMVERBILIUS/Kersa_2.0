@extends('layouts.admin')

@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4">Add New Article</h1>

    <form action="{{ route('admin.articles.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        {{-- Title --}}
        <div class="mb-3">
            <label class="form-label">Article Title</label>
            <input type="text" class="form-control" name="title" required>
        </div>

        {{-- Description --}}
        <div class="mb-3">
            <label class="form-label">Description</label>
            <textarea class="form-control" name="description" rows="3"></textarea>
        </div>

        {{-- Thumbnail --}}
        <div class="mb-3">
            <label class="form-label">Thumbnail</label>
            <input type="file" class="form-control" name="thumbnail" accept="image/*">
        </div>

        {{-- Status --}}
        <div class="mb-3">
            <label class="form-label">Publish Status</label>
            <select name="status" class="form-select" required>
                <option value="Draft">Draft</option>
                <option value="Published">Published</option>
            </select>
        </div>

        {{-- Author --}}
        <div class="mb-3">
            <label class="form-label">Author</label>
            <input type="text" class="form-control" name="author" required>
        </div>

        {{-- Dynamic Subheadings and Paragraphs --}}
        <div id="subheading-container">
            <div class="subheading-group border p-3 mb-3">
                <label class="form-label">Subheading</label>
                <input type="text" name="subheadings[0][title]" class="form-control mb-2" required>

                <div class="paragraph-container">
                    <label class="form-label">Paragraph</label>
                    <textarea name="subheadings[0][paragraphs][0][content]" class="form-control mb-2" required></textarea>
                </div>

                <button type="button" class="btn btn-sm btn-outline-primary add-paragraph">+ Add Paragraph</button>
            </div>
        </div>

        <button type="button" id="add-subheading" class="btn btn-outline-success mb-3">+ Add Subheading</button>

        <div>
            <button type="submit" class="btn btn-success">Save Article</button>
            <a href="{{ route('admin.articles.manage') }}" class="btn btn-secondary">Cancel</a>
        </div>
    </form>
</div>

{{-- Scripts --}}
@push('scripts')
<script>
    let subheadingIndex = 1;

    document.addEventListener('DOMContentLoaded', function () {
        const container = document.getElementById('subheading-container');
        const addSubheadingBtn = document.getElementById('add-subheading');

        addSubheadingBtn.addEventListener('click', function () {
            let paragraphIndex = 0;
            const newSubheading = document.createElement('div');
            newSubheading.classList.add('subheading-group', 'border', 'p-3', 'mb-3');
            newSubheading.innerHTML = `
                <label class="form-label">Subheading</label>
                <input type="text" name="subheadings[${subheadingIndex}][title]" class="form-control mb-2" required>

                <div class="paragraph-container">
                    <label class="form-label">Paragraph</label>
                    <textarea name="subheadings[${subheadingIndex}][paragraphs][${paragraphIndex}][content]" class="form-control mb-2" required></textarea>
                </div>

                <button type="button" class="btn btn-sm btn-outline-primary add-paragraph">+ Add Paragraph</button>
            `;
            container.appendChild(newSubheading);
            subheadingIndex++;
        });

        container.addEventListener('click', function (e) {
            if (e.target.classList.contains('add-paragraph')) {
                const subheadingGroup = e.target.closest('.subheading-group');
                const paragraphContainer = subheadingGroup.querySelector('.paragraph-container');
                const textareas = paragraphContainer.querySelectorAll('textarea');
                const newParagraphIndex = textareas.length;

                const nameSample = textareas[0].getAttribute('name');
                const subIndexMatch = nameSample.match(/subheadings\[(\d+)\]/);
                const subIndex = subIndexMatch ? subIndexMatch[1] : 0;

                const newTextarea = document.createElement('textarea');
                newTextarea.classList.add('form-control', 'mb-2');
                newTextarea.setAttribute('name', `subheadings[${subIndex}][paragraphs][${newParagraphIndex}][content]`);
                newTextarea.required = true;

                paragraphContainer.appendChild(newTextarea);
            }
        });
    });
</script>
@endpush

@endsection
