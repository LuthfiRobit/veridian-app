@extends('layouts.backend')

@section('title', 'Edit Project')

@push('styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/flag-icon-css/3.5.0/css/flag-icon.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    <link href="https://cdn.jsdelivr.net/npm/tom-select@2.3.1/dist/css/tom-select.bootstrap5.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/responsive/2.2.9/css/responsive.bootstrap5.min.css" rel="stylesheet">
    <style>
        .ck-editor__editable_inline {
            min-height: 300px;
        }

        /* Tom Select Bootstrap 5 Tweaks */
        .ts-wrapper.form-control {
            padding: 0 !important;
            border: 1px solid #ced4da !important;
        }

        .ts-control {
            padding: 0.5625rem 0.75rem;
            border: none;
        }
    </style>
@endpush

@section('content')
    <div class="page-header mb-3">
        <div class="page-block">
            <div class="row align-items-center">
                <div class="col-md-12">
                    <div class="page-header-title">
                        <h5 class="m-b-10">Edit Project</h5>
                    </div>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item">Content Management</li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.projects.index') }}">Projects</a></li>
                        <li class="breadcrumb-item">Edit Project</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <form action="{{ route('admin.projects.update', $project->id_project) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="row">
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-header">
                        <h5>Project Content</h5>
                    </div>
                    <div class="card-body">
                        <div class="alert alert-info d-flex align-items-center mb-3" role="alert">
                            <i class="ti ti-info-circle me-2 fs-4"></i>
                            <div>
                                You can now add or update translations for all active languages.
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
                                @php
                                    $translation = $project->translations->where('locale', $language->code)->first();
                                @endphp
                                <div class="tab-pane fade {{ $loop->first ? 'show active' : '' }}"
                                    id="lang-{{ $language->code }}" role="tabpanel" aria-labelledby="tab-{{ $language->code }}">

                                    <div class="mb-3">
                                        <label class="form-label">Project Title ({{ $language->code }}) @if($loop->first) <span
                                        class="text-danger">*</span> @endif</label>
                                        <input type="text" class="form-control @error('translations.' . $language->code . '.title') is-invalid @enderror"
                                            name="translations[{{ $language->code }}][title]"
                                            value="{{ old('translations.' . $language->code . '.title', $translation->title ?? '') }}"
                                            @if($loop->first) required @endif>
                                        @error('translations.' . $language->code . '.title')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Subtitle ({{ $language->code }})</label>
                                        <input type="text" class="form-control @error('translations.' . $language->code . '.subtitle') is-invalid @enderror"
                                            name="translations[{{ $language->code }}][subtitle]"
                                            value="{{ old('translations.' . $language->code . '.subtitle', $translation->subtitle ?? '') }}">
                                        @error('translations.' . $language->code . '.subtitle')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Brief Description ({{ $language->code }})</label>
                                        <textarea class="form-control @error('translations.' . $language->code . '.description') is-invalid @enderror" name="translations[{{ $language->code }}][description]"
                                            rows="3">{{ old('translations.' . $language->code . '.description', $translation->description ?? '') }}</textarea>
                                        @error('translations.' . $language->code . '.description')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Full Content ({{ $language->code }})</label>
                                        <textarea class="form-control ckeditor-content @error('translations.' . $language->code . '.content') is-invalid @enderror"
                                            name="translations[{{ $language->code }}][content]">{{ old('translations.' . $language->code . '.content', $translation->content ?? '') }}</textarea>
                                        @error('translations.' . $language->code . '.content')
                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="row">
                                        <div class="col-md-4 mb-3">
                                            <label class="form-label">Challenge ({{ $language->code }})</label>
                                            <textarea class="form-control @error('translations.' . $language->code . '.challenge') is-invalid @enderror" name="translations[{{ $language->code }}][challenge]"
                                                rows="3">{{ old('translations.' . $language->code . '.challenge', $translation->challenge ?? '') }}</textarea>
                                            @error('translations.' . $language->code . '.challenge')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label class="form-label">Solution ({{ $language->code }})</label>
                                            <textarea class="form-control @error('translations.' . $language->code . '.solution') is-invalid @enderror" name="translations[{{ $language->code }}][solution]"
                                                rows="3">{{ old('translations.' . $language->code . '.solution', $translation->solution ?? '') }}</textarea>
                                            @error('translations.' . $language->code . '.solution')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label class="form-label">Result ({{ $language->code }})</label>
                                            <textarea class="form-control @error('translations.' . $language->code . '.result') is-invalid @enderror" name="translations[{{ $language->code }}][result]"
                                                rows="3">{{ old('translations.' . $language->code . '.result', $translation->result ?? '') }}</textarea>
                                            @error('translations.' . $language->code . '.result')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Meta Title (SEO) ({{ $language->code }})</label>
                                        <input type="text" class="form-control @error('translations.' . $language->code . '.meta_title') is-invalid @enderror"
                                            name="translations[{{ $language->code }}][meta_title]"
                                            value="{{ old('translations.' . $language->code . '.meta_title', $translation->meta_title ?? '') }}">
                                        @error('translations.' . $language->code . '.meta_title')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Meta Description (SEO) ({{ $language->code }})</label>
                                        <textarea class="form-control @error('translations.' . $language->code . '.meta_desc') is-invalid @enderror" name="translations[{{ $language->code }}][meta_desc]"
                                            rows="2">{{ old('translations.' . $language->code . '.meta_desc', $translation->meta_desc ?? '') }}</textarea>
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
                            <select class="form-select @error('id_project_category') is-invalid @enderror" name="id_project_category">
                                <option value="">Select Category</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id_project_category }}" {{ old('id_project_category', $project->id_project_category) == $category->id_project_category ? 'selected' : '' }}>
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
                            <input type="text" class="form-control @error('client_name') is-invalid @enderror" name="client_name"
                                value="{{ old('client_name', $project->client_name) }}">
                            @error('client_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Completion Date</label>
                            <input type="date" class="form-control @error('completion_date') is-invalid @enderror" name="completion_date"
                                value="{{ old('completion_date', $project->completion_date ? $project->completion_date->format('Y-m-d') : '') }}">
                            @error('completion_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Project URL</label>
                            <input type="url" class="form-control @error('project_url') is-invalid @enderror" name="project_url"
                                value="{{ old('project_url', $project->project_url) }}" placeholder="https://example.com">
                            @error('project_url')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Status</label>
                            <select class="form-select" name="is_active">
                                <option value="1" {{ old('is_active', $project->is_active) == '1' ? 'selected' : '' }}>Active
                                </option>
                                <option value="0" {{ old('is_active', $project->is_active) == '0' ? 'selected' : '' }}>
                                    Inactive</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Featured?</label>
                            <select class="form-select" name="is_featured">
                                <option value="0" {{ old('is_featured', $project->is_featured) == '0' ? 'selected' : '' }}>No
                                </option>
                                <option value="1" {{ old('is_featured', $project->is_featured) == '1' ? 'selected' : '' }}>Yes
                                </option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Sort Order</label>
                            <input type="number" class="form-control @error('sort_order') is-invalid @enderror" name="sort_order"
                                value="{{ old('sort_order', $project->sort_order) }}">
                            @error('sort_order')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Thumbnail Image</label>
                            @if($project->image_thumbnail)
                                <div class="mb-2">
                                    <img src="{{ asset($project->image_thumbnail) }}" alt="Thumbnail" class="img-thumbnail"
                                        style="max-height: 100px;">
                                </div>
                            @endif
                            <input type="file" class="form-control @error('image_thumbnail') is-invalid @enderror" name="image_thumbnail">
                            @error('image_thumbnail')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary">Update Project</button>
                            <a href="{{ route('admin.projects.index') }}" class="btn btn-secondary">Cancel</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>

    <hr class="my-2">

    <!-- Child Modules Accordion -->
    <div class="row pb-2">
        <div class="col-12">
            <h4 class="mb-3">Project Assets & Details</h4>
            <div class="accordion" id="projectAssets">

                <!-- Images / Gallery -->
                <div class="accordion-item">
                    <h2 class="accordion-header" id="headingImages">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                            data-bs-target="#collapseImages" aria-expanded="false" aria-controls="collapseImages">
                            <i class="ti ti-photo me-2"></i> Project Gallery
                        </button>
                    </h2>
                    <div id="collapseImages" class="accordion-collapse collapse" aria-labelledby="headingImages"
                        data-bs-parent="#projectAssets">
                        <div class="accordion-body">
                            @include('backend.projects.partials._images')
                        </div>
                    </div>
                </div>

                <!-- Stats -->
                <div class="accordion-item">
                    <h2 class="accordion-header" id="headingStats">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                            data-bs-target="#collapseStats" aria-expanded="false" aria-controls="collapseStats">
                            <i class="ti ti-chart-bar me-2"></i> Project Stats
                        </button>
                    </h2>
                    <div id="collapseStats" class="accordion-collapse collapse" aria-labelledby="headingStats"
                        data-bs-parent="#projectAssets">
                        <div class="accordion-body">
                            @include('backend.projects.partials._stats')
                        </div>
                    </div>
                </div>

                <!-- Features -->
                <div class="accordion-item">
                    <h2 class="accordion-header" id="headingFeatures">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                            data-bs-target="#collapseFeatures" aria-expanded="false" aria-controls="collapseFeatures">
                            <i class="ti ti-list-check me-2"></i> Project Features
                        </button>
                    </h2>
                    <div id="collapseFeatures" class="accordion-collapse collapse" aria-labelledby="headingFeatures"
                        data-bs-parent="#projectAssets">
                        <div class="accordion-body">
                            @include('backend.projects.partials._features')
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection

@push('scripts')
    {{-- Libraries --}}
    <script src="https://cdn.ckeditor.com/ckeditor5/38.0.1/classic/ckeditor.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.2.9/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.2.9/js/responsive.bootstrap5.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/tom-select@2.3.1/dist/js/tom-select.complete.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/tom-select@2.3.1/dist/js/tom-select.complete.min.js"></script>

    <script>
        // Global Config
        const projectId = "{{ $project->id_project }}";
        const csrfToken = "{{ csrf_token() }}";
        const defaultLangCode = "{{ $sortedLanguages->first()->code ?? 'en' }}";

        // Setup CSRF Token
        $.ajaxSetup({
            headers: { 'X-CSRF-TOKEN': csrfToken }
        });

        // Validation Error Handler
        window.handleAjaxValidationErrors = function (formId, xhr) {
            const form = $(formId);
            form.find('.is-invalid').removeClass('is-invalid');
            form.find('.invalid-feedback').remove();

            if (xhr.status === 422) {
                const errors = xhr.responseJSON.errors;
                for (let key in errors) {
                    let inputName = key;
                    if (key.includes('.')) {
                        inputName = key.replace(/\.([^.]+)/g, '[$1]');
                    }
                    let input = form.find(`[name="${inputName}"]`);
                    if (input.length > 0) {
                        input.addClass('is-invalid');
                        input.after(`<div class="invalid-feedback">${errors[key][0]}</div>`);
                    } else {
                        toastr.error(errors[key][0]);
                    }
                }
            } else {
                toastr.error(xhr.responseJSON.error || 'An unexpected error occurred.');
            }
        };

        window.clearValidationErrors = function (formId) {
            const form = $(formId);
            form.find('.is-invalid').removeClass('is-invalid');
            form.find('.invalid-feedback').remove();
        };

        // Initialize CKEditor
        document.addEventListener("DOMContentLoaded", function () {
            const editors = document.querySelectorAll('.ckeditor-content');
            editors.forEach(editor => {
                ClassicEditor.create(editor).catch(error => console.error(error));
            });

            // Bootstrap Icons for TomSelect
            const bootstrapIcons = [
                "bi-activity", "bi-alarm", "bi-alarm-fill", "bi-archive", "bi-archive-fill",
                "bi-arrow-down", "bi-arrow-left", "bi-arrow-right", "bi-arrow-up",
                "bi-award", "bi-award-fill", "bi-bag", "bi-bag-fill", "bi-bag-check",
                "bi-bank", "bi-basket", "bi-basket-fill", "bi-bell", "bi-bell-fill",
                "bi-book", "bi-book-fill", "bi-bookmark", "bi-bookmark-fill", "bi-box",
                "bi-briefcase", "bi-briefcase-fill", "bi-bug", "bi-bug-fill",
                "bi-building", "bi-calculator", "bi-calendar", "bi-calendar-date",
                "bi-camera", "bi-camera-video", "bi-cart", "bi-cart-fill", "bi-chat",
                "bi-chat-dots", "bi-check", "bi-check-circle", "bi-check-circle-fill",
                "bi-cloud", "bi-cloud-arrow-down", "bi-cloud-arrow-up", "bi-code",
                "bi-code-slash", "bi-gear", "bi-gear-fill", "bi-globe", "bi-graph-up",
                "bi-grid", "bi-heart", "bi-heart-fill", "bi-house", "bi-house-door",
                "bi-image", "bi-info-circle", "bi-laptop", "bi-layers", "bi-layout-text-window",
                "bi-lightbulb", "bi-link", "bi-list", "bi-lock", "bi-lock-fill",
                "bi-map", "bi-megaphone", "bi-menu-button", "bi-mic", "bi-moon",
                "bi-music-note", "bi-newspaper", "bi-palette", "bi-paperclip", "bi-pen",
                "bi-pencil", "bi-people", "bi-people-fill", "bi-person", "bi-person-circle",
                "bi-phone", "bi-pie-chart", "bi-pin", "bi-play", "bi-play-circle",
                "bi-power", "bi-printer", "bi-puzzle", "bi-question-circle", "bi-search",
                "bi-share", "bi-shield", "bi-shield-check", "bi-shield-lock", "bi-shop",
                "bi-signpost", "bi-sliders", "bi-speaker", "bi-star", "bi-star-fill",
                "bi-sun", "bi-table", "bi-tag", "bi-tags", "bi-terminal", "bi-textarea",
                "bi-tools", "bi-trash", "bi-trophy", "bi-truck", "bi-tv", "bi-unlock",
                "bi-upload", "bi-user", "bi-wallet", "bi-watch", "bi-wifi", "bi-window",
                "bi-wrench", "bi-x", "bi-x-circle", "bi-zoom-in", "bi-zoom-out",
                // Brand
                "bi-facebook", "bi-twitter", "bi-instagram", "bi-linkedin", "bi-youtube",
                "bi-github", "bi-google", "bi-whatsapp", "bi-telegram", "bi-messenger",
                "bi-slack", "bi-skype", "bi-windows", "bi-apple", "bi-android"
            ];
            window.iconOptions = bootstrapIcons.map(icon => ({ value: 'bi ' + icon, text: 'bi ' + icon }));
        });
    </script>

    @include('backend.projects.scripts._images-js')
    @include('backend.projects.scripts._stats-js')
    @include('backend.projects.scripts._features-js')
@endpush