@extends('layouts.backend')

@section('title', 'Add New Project')

@push('styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/flag-icon-css/3.5.0/css/flag-icon.min.css">
    <style>
        .ck-editor__editable_inline {
            min-height: 300px;
        }
    </style>
@endpush

@section('content')
    <div class="page-header mb-3">
        <div class="page-block">
            <div class="row align-items-center">
                <div class="col-md-12">
                    <div class="page-header-title">
                        <h5 class="m-b-10">Add New Project</h5>
                    </div>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item">Content Management</li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.projects.index') }}">Projects</a></li>
                        <li class="breadcrumb-item">Add New</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <form action="{{ route('admin.projects.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="row">
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-header">
                        <h5>Project Content</h5>
                    </div>
                    <div class="card-body">
                        <div class="alert alert-warning d-flex align-items-center mb-3" role="alert">
                            <i class="ti ti-alert-triangle me-2 fs-4"></i>
                            <div>
                                <strong>Important:</strong> Fill in the default language
                                ({{ $sortedLanguages->where('is_default', true)->first()->name }}) first.
                            </div>
                        </div>

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
                                        <label class="form-label">Project Title ({{ $language->code }}) @if($loop->first) <span
                                        class="text-danger">*</span> @endif</label>
                                        <input type="text"
                                            class="form-control @error('translations.' . $language->code . '.title') is-invalid @enderror"
                                            name="translations[{{ $language->code }}][title]"
                                            value="{{ old('translations.' . $language->code . '.title') }}" @if($loop->first)
                                            required @endif>
                                        @error('translations.' . $language->code . '.title')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Subtitle ({{ $language->code }})</label>
                                        <input type="text"
                                            class="form-control @error('translations.' . $language->code . '.subtitle') is-invalid @enderror"
                                            name="translations[{{ $language->code }}][subtitle]"
                                            value="{{ old('translations.' . $language->code . '.subtitle') }}">
                                        @error('translations.' . $language->code . '.subtitle')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Brief Description ({{ $language->code }})</label>
                                        <textarea
                                            class="form-control @error('translations.' . $language->code . '.description') is-invalid @enderror"
                                            name="translations[{{ $language->code }}][description]"
                                            rows="3">{{ old('translations.' . $language->code . '.description') }}</textarea>
                                        @error('translations.' . $language->code . '.description')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Full Content ({{ $language->code }})</label>
                                        <textarea
                                            class="form-control ckeditor-content @error('translations.' . $language->code . '.content') is-invalid @enderror"
                                            name="translations[{{ $language->code }}][content]">{{ old('translations.' . $language->code . '.content') }}</textarea>
                                        @error('translations.' . $language->code . '.content')
                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="row">
                                        <div class="col-md-4 mb-3">
                                            <label class="form-label">Challenge ({{ $language->code }})</label>
                                            <textarea
                                                class="form-control @error('translations.' . $language->code . '.challenge') is-invalid @enderror"
                                                name="translations[{{ $language->code }}][challenge]"
                                                rows="3">{{ old('translations.' . $language->code . '.challenge') }}</textarea>
                                            @error('translations.' . $language->code . '.challenge')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label class="form-label">Solution ({{ $language->code }})</label>
                                            <textarea
                                                class="form-control @error('translations.' . $language->code . '.solution') is-invalid @enderror"
                                                name="translations[{{ $language->code }}][solution]"
                                                rows="3">{{ old('translations.' . $language->code . '.solution') }}</textarea>
                                            @error('translations.' . $language->code . '.solution')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label class="form-label">Result ({{ $language->code }})</label>
                                            <textarea
                                                class="form-control @error('translations.' . $language->code . '.result') is-invalid @enderror"
                                                name="translations[{{ $language->code }}][result]"
                                                rows="3">{{ old('translations.' . $language->code . '.result') }}</textarea>
                                            @error('translations.' . $language->code . '.result')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Meta Title (SEO) ({{ $language->code }})</label>
                                        <input type="text"
                                            class="form-control @error('translations.' . $language->code . '.meta_title') is-invalid @enderror"
                                            name="translations[{{ $language->code }}][meta_title]"
                                            value="{{ old('translations.' . $language->code . '.meta_title') }}">
                                        @error('translations.' . $language->code . '.meta_title')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Meta Description (SEO) ({{ $language->code }})</label>
                                        <textarea
                                            class="form-control @error('translations.' . $language->code . '.meta_desc') is-invalid @enderror"
                                            name="translations[{{ $language->code }}][meta_desc]"
                                            rows="2">{{ old('translations.' . $language->code . '.meta_desc') }}</textarea>
                                        @error('translations.' . $language->code . '.meta_desc')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
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
                        <h5>Project Details</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="form-label">Category</label>
                            <select class="form-select @error('id_project_category') is-invalid @enderror"
                                name="id_project_category">
                                <option value="">Select Category</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id_project_category }}" {{ old('id_project_category') == $category->id_project_category ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('id_project_category')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Client Name</label>
                            <input type="text" class="form-control @error('client_name') is-invalid @enderror"
                                name="client_name" value="{{ old('client_name') }}">
                            @error('client_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Completion Date</label>
                            <input type="date" class="form-control @error('completion_date') is-invalid @enderror"
                                name="completion_date" value="{{ old('completion_date') }}">
                            @error('completion_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Project URL</label>
                            <input type="url" class="form-control @error('project_url') is-invalid @enderror"
                                name="project_url" value="{{ old('project_url') }}" placeholder="https://example.com">
                            @error('project_url')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Status</label>
                            <select class="form-select" name="is_active">
                                <option value="1" {{ old('is_active', '1') == '1' ? 'selected' : '' }}>Active</option>
                                <option value="0" {{ old('is_active') == '0' ? 'selected' : '' }}>Inactive</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Featured?</label>
                            <select class="form-select" name="is_featured">
                                <option value="0" {{ old('is_featured', '0') == '0' ? 'selected' : '' }}>No</option>
                                <option value="1" {{ old('is_featured') == '1' ? 'selected' : '' }}>Yes</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Sort Order</label>
                            <input type="number" class="form-control @error('sort_order') is-invalid @enderror"
                                name="sort_order" value="{{ old('sort_order', 0) }}">
                            @error('sort_order')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Thumbnail Image</label>
                            <input type="file" class="form-control @error('image_thumbnail') is-invalid @enderror"
                                name="image_thumbnail">
                            @error('image_thumbnail')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary">Save Project</button>
                            <a href="{{ route('admin.projects.index') }}" class="btn btn-secondary">Cancel</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection

@push('scripts')
    <script src="https://cdn.ckeditor.com/ckeditor5/38.0.1/classic/ckeditor.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const editors = document.querySelectorAll('.ckeditor-content');
            editors.forEach(editor => {
                ClassicEditor.create(editor).catch(error => console.error(error));
            });
        });
    </script>
@endpush