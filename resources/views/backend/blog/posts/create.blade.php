@extends('layouts.backend')

@section('title', 'Add New Blog Post')

@push('styles')
    <link href="https://cdn.jsdelivr.net/npm/tom-select@2.3.1/dist/css/tom-select.bootstrap5.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/flag-icon-css/3.5.0/css/flag-icon.min.css">
    <style>
        .ck-editor__editable_inline { min-height: 400px; }
        .ts-wrapper.form-control { padding: 0 !important; border: 1px solid #ced4da !important; }
        .ts-control { padding: 0.5625rem 0.75rem; border: none; }
    </style>
@endpush

@section('content')
    <div class="page-header mb-3">
        <div class="page-block">
            <div class="row align-items-center">
                <div class="col-md-12">
                    <div class="page-header-title">
                        <h5 class="m-b-10">Add New Blog Post</h5>
                    </div>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item">Content Management</li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.blog-posts.index') }}">Blog Posts</a></li>
                        <li class="breadcrumb-item">Add New</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <form action="{{ route('admin.blog-posts.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="row">
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-header">
                        <h5>Post Content</h5>
                    </div>
                    <div class="card-body">
                        {{-- Language Tabs --}}
                        <ul class="nav nav-tabs mb-3" id="languageTabs" role="tablist">
                            @foreach($sortedLanguages as $language)
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link {{ $loop->first ? 'active' : '' }}" id="tab-{{ $language->code }}"
                                        data-bs-toggle="tab" data-bs-target="#lang-{{ $language->code }}" type="button"
                                        role="tab" aria-controls="lang-{{ $language->code }}"
                                        aria-selected="{{ $loop->first ? 'true' : 'false' }}">
                                        <i class="{{ $language->icon }}"></i> {{ $language->name }}
                                    </button>
                                </li>
                            @endforeach
                        </ul>

                        {{-- Tab Content --}}
                        <div class="tab-content" id="languageTabContent">
                            @foreach($sortedLanguages as $language)
                                <div class="tab-pane fade {{ $loop->first ? 'show active' : '' }}"
                                    id="lang-{{ $language->code }}" role="tabpanel" aria-labelledby="tab-{{ $language->code }}">

                                    <div class="mb-3">
                                        <label for="title_{{ $language->code }}" class="form-label">Post Title
                                            ({{ $language->code }}) 
                                            @if($loop->first) <span class="text-danger">*</span> @endif
                                        </label>
                                        <input type="text"
                                            class="form-control @error('translations.' . $language->code . '.title') is-invalid @enderror"
                                            id="title_{{ $language->code }}" name="translations[{{ $language->code }}][title]"
                                            value="{{ old('translations.' . $language->code . '.title') }}" 
                                            @if($loop->first) required @endif>
                                        @error('translations.' . $language->code . '.title')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label for="slug_{{ $language->code }}" class="form-label">Slug
                                            ({{ $language->code }})
                                        </label>
                                        <input type="text"
                                            class="form-control @error('translations.' . $language->code . '.slug') is-invalid @enderror"
                                            id="slug_{{ $language->code }}" name="translations[{{ $language->code }}][slug]"
                                            value="{{ old('translations.' . $language->code . '.slug') }}">
                                        <small class="form-text text-muted">Leave empty to auto-generate from the title.</small>
                                        @error('translations.' . $language->code . '.slug')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label for="excerpt_{{ $language->code }}" class="form-label">Excerpt
                                            ({{ $language->code }})</label>
                                        <textarea class="form-control" id="excerpt_{{ $language->code }}"
                                            name="translations[{{ $language->code }}][excerpt]"
                                            rows="3">{{ old('translations.' . $language->code . '.excerpt') }}</textarea>
                                    </div>

                                    <div class="mb-3">
                                        <label for="content_{{ $language->code }}" class="form-label">Content
                                            ({{ $language->code }}) @if($loop->first) <span class="text-danger">*</span> @endif
                                        </label>
                                        <textarea class="form-control ckeditor-content" id="content_{{ $language->code }}"
                                            name="translations[{{ $language->code }}][content]">{{ old('translations.' . $language->code . '.content') }}</textarea>
                                    </div>

                                    <div class="mb-3">
                                        <label for="meta_title_{{ $language->code }}" class="form-label">Meta Title (SEO)
                                            ({{ $language->code }})</label>
                                        <input type="text" class="form-control" id="meta_title_{{ $language->code }}"
                                            name="translations[{{ $language->code }}][meta_title]"
                                            value="{{ old('translations.' . $language->code . '.meta_title') }}">
                                    </div>

                                    <div class="mb-3">
                                        <label for="meta_desc_{{ $language->code }}" class="form-label">Meta Description (SEO)
                                            ({{ $language->code }})</label>
                                        <textarea class="form-control" id="meta_desc_{{ $language->code }}"
                                            name="translations[{{ $language->code }}][meta_desc]"
                                            rows="2">{{ old('translations.' . $language->code . '.meta_desc') }}</textarea>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="card">
                    <div class="card-header">
                        <h5>Settings & Publish</h5>
                    </div>
                    <div class="card-body">
                        
                        <div class="mb-3">
                            <label class="form-label">Category <span class="text-danger">*</span></label>
                            <select name="id_blog_category" id="id_blog_category" class="form-control @error('id_blog_category') is-invalid @enderror" required>
                                <option value="">Select Category</option>
                                @foreach($categories as $id => $name)
                                    <option value="{{ $id }}" {{ old('id_blog_category') == $id ? 'selected' : '' }}>{{ $name }}</option>
                                @endforeach
                            </select>
                            @error('id_blog_category')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="status" class="form-label">Status <span class="text-danger">*</span></label>
                            <select class="form-select @error('status') is-invalid @enderror" id="status" name="status" required>
                                <option value="draft" {{ old('status', 'draft') == 'draft' ? 'selected' : '' }}>Draft</option>
                                <option value="published" {{ old('status') == 'published' ? 'selected' : '' }}>Published</option>
                            </select>
                            @error('status')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3" id="published_at_container" style="display: none;">
                            <label for="published_at" class="form-label">Publish Date (Optional)</label>
                            <input type="datetime-local" class="form-control @error('published_at') is-invalid @enderror" id="published_at" name="published_at"
                                value="{{ old('published_at') }}">
                            <small class="text-muted">Leave empty to publish immediately.</small>
                            @error('published_at')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="reading_time" class="form-label">Reading Time (Minutes)</label>
                            <input type="number" class="form-control @error('reading_time') is-invalid @enderror" id="reading_time" name="reading_time"
                                value="{{ old('reading_time', 0) }}" min="0">
                            @error('reading_time')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="image_featured" class="form-label">Featured Image</label>
                            <input type="file" class="form-control @error('image_featured') is-invalid @enderror" id="image_featured" name="image_featured" accept="image/*">
                            @error('image_featured')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary">Save Post</button>
                            <a href="{{ route('admin.blog-posts.index') }}" class="btn btn-secondary">Cancel</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection

@push('scripts')
    <script src="https://cdn.ckeditor.com/ckeditor5/38.0.1/classic/ckeditor.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/tom-select@2.3.1/dist/js/tom-select.complete.min.js"></script>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            // CKEditor
            const editors = document.querySelectorAll('.ckeditor-content');
            editors.forEach(editor => {
                ClassicEditor
                    .create(editor)
                    .catch(error => { console.error(error); });
            });

            // TomSelect
            new TomSelect("#id_blog_category", {
                create: false,
                sortField: { field: "text", direction: "asc" }
            });

            // Status Toggle for published_at
            const statusSelect = document.getElementById('status');
            const publishedAtContainer = document.getElementById('published_at_container');

            function togglePublishDate() {
                if (statusSelect.value === 'published') {
                    publishedAtContainer.style.display = 'block';
                } else {
                    publishedAtContainer.style.display = 'none';
                }
            }

            statusSelect.addEventListener('change', togglePublishDate);
            togglePublishDate(); // initial check
        });
    </script>
@endpush
