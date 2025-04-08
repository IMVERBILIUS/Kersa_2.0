@extends('layouts.admin')

@section('content')
<div class="container mt-4">
    <h2>Edit Article</h2>
    <form action="{{ route('admin.articles.update', $article->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <!-- ========== ARTICLE FORM ========== -->
        <div class="mb-3">
            <label>Title</label>
            <input type="text" name="title" value="{{ old('title', $article->title) }}" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Description</label>
            <textarea name="description" class="form-control" rows="3" required>{{ old('description', $article->description) }}</textarea>
        </div>

        <div class="mb-3">
            <label>Status</label>
            <select name="status" class="form-select">
                <option value="Draft" {{ $article->status === 'Draft' ? 'selected' : '' }}>Draft</option>
                <option value="Published" {{ $article->status === 'Published' ? 'selected' : '' }}>Published</option>
            </select>
        </div>
        <div class="mb-3">
            <label>Author</label>
            <input type="text" name="author" value="{{ old('author', $article->author) }}" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Thumbnail</label><br>
            @if ($article->thumbnail)
                <img src="{{ asset('storage/' . $article->thumbnail) }}" width="100" class="mb-2">
            @endif
            <input type="file" name="thumbnail" class="form-control">
        </div>

        <hr>

        <!-- ========== SUBHEADING & PARAGRAPH SECTION ========== -->
        <h5>Subheadings & Paragraphs</h5>
        <div id="subheading-container">
            @foreach($article->subheadings as $subIndex => $subheading)
                <div class="subheading-block border p-3 mb-3">
                    <input type="hidden" name="subheadings[{{ $subIndex }}][id]" value="{{ $subheading->id }}">
                    <div class="mb-2">
                        <label>Subheading Title</label>
                        <input type="text" name="subheadings[{{ $subIndex }}][title]" class="form-control" value="{{ $subheading->title }}">
                    </div>

                    <div class="paragraphs-container">
                        @foreach($subheading->paragraphs as $paraIndex => $paragraph)
                            <div class="paragraph-block mb-2">
                                <input type="hidden" name="subheadings[{{ $subIndex }}][paragraphs][{{ $paraIndex }}][id]" value="{{ $paragraph->id }}">
                                <textarea name="subheadings[{{ $subIndex }}][paragraphs][{{ $paraIndex }}][content]" class="form-control" rows="2">{{ $paragraph->content }}</textarea>
                                <button type="button" class="btn btn-sm btn-danger mt-1" onclick="this.parentElement.remove()">Remove Paragraph</button>
                            </div>
                        @endforeach
                    </div>

                    <button type="button" class="btn btn-secondary btn-sm add-paragraph-btn mt-2">+ Add Paragraph</button>
                    <button type="button" class="btn btn-danger btn-sm float-end mt-2" onclick="this.closest('.subheading-block').remove()">Remove Subheading</button>
                </div>
            @endforeach
        </div>

        <button type="button" id="add-subheading-btn" class="btn btn-primary mt-3">+ Add Subheading</button>

        <div class="mt-4">
            <button type="submit" class="btn btn-success">Update Article</button>
            <a href="{{ route('admin.articles.manage') }}" class="btn btn-secondary">Cancel</a>
        </div>
    </form>
</div>

<!-- TEMPLATE -->
<template id="subheading-template">
    <div class="subheading-block border p-3 mb-3">
        <div class="mb-2">
            <label>Subheading Title</label>
            <input type="text" name="__NAME__[title]" class="form-control">
        </div>
        <div class="paragraphs-container"></div>
        <button type="button" class="btn btn-secondary btn-sm add-paragraph-btn mt-2">+ Add Paragraph</button>
        <button type="button" class="btn btn-danger btn-sm float-end mt-2" onclick="this.closest('.subheading-block').remove()">Remove Subheading</button>
    </div>
</template>

<template id="paragraph-template">
    <div class="paragraph-block mb-2">
        <textarea name="__NAME__[content]" class="form-control" rows="2"></textarea>
        <button type="button" class="btn btn-danger btn-sm mt-1" onclick="this.parentElement.remove()">Remove Paragraph</button>
    </div>
</template>

<script>
    let subIndex = {{ $article->subheadings->count() }};

    document.getElementById('add-subheading-btn').addEventListener('click', () => {
        const template = document.getElementById('subheading-template').innerHTML;
        const html = template.replaceAll('__NAME__', `subheadings[${subIndex}]`);
        const wrapper = document.createElement('div');
        wrapper.innerHTML = html;
        document.getElementById('subheading-container').appendChild(wrapper.firstElementChild);
        subIndex++;
    });

    document.addEventListener('click', function (e) {
        if (e.target && e.target.classList.contains('add-paragraph-btn')) {
            const container = e.target.closest('.subheading-block');
            const paraContainer = container.querySelector('.paragraphs-container');
            let paraCount = paraContainer.children.length;
            let subIndex = Array.from(container.parentElement.children).indexOf(container);
            let template = document.getElementById('paragraph-template').innerHTML;
            let html = template.replaceAll('__NAME__', `subheadings[${subIndex}][paragraphs][${paraCount}]`);
            let wrapper = document.createElement('div');
            wrapper.innerHTML = html;
            paraContainer.appendChild(wrapper.firstElementChild);
        }
    });
</script>
@endsection
