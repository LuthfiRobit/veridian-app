@extends('layouts.backend')

@section('title', 'Add New Service')

@push('styles')
    <link href="https://cdn.jsdelivr.net/npm/tom-select@2.3.1/dist/css/tom-select.bootstrap5.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/flag-icon-css/3.5.0/css/flag-icon.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
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
                        <h5 class="m-b-10">Add New Service</h5>
                    </div>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item">Content Management</li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.services.index') }}">Services</a></li>
                        <li class="breadcrumb-item">Add New</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <form action="{{ route('admin.services.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="row">
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-header">
                        <h5>Service Content</h5>
                    </div>
                    <div class="card-body">
                        {{-- Important Notice --}}
                        <div class="alert alert-warning d-flex align-items-center mb-3" role="alert">
                            <i class="ti ti-alert-triangle me-2 fs-4"></i>
                            <div>
                                <strong>Important:</strong> You must fill in the default language ({{ $sortedLanguages->where('is_default', true)->first()->name }}) content first. 
                                Other language translations can be added later via the Edit function.
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
                                        <label for="name_{{ $language->code }}" class="form-label">Service Name
                                            ({{ $language->code }}) 
                                            @if($loop->first) <span class="text-danger">*</span> @endif
                                        </label>
                                        <input type="text"
                                            class="form-control @error('translations.' . $language->code . '.name') is-invalid @enderror"
                                            id="name_{{ $language->code }}" name="translations[{{ $language->code }}][name]"
                                            value="{{ old('translations.' . $language->code . '.name') }}" 
                                            @if($loop->first) required @endif>
                                        @error('translations.' . $language->code . '.name')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label for="short_desc_{{ $language->code }}" class="form-label">Short Description
                                            ({{ $language->code }})</label>
                                        <textarea class="form-control" id="short_desc_{{ $language->code }}"
                                            name="translations[{{ $language->code }}][short_desc]"
                                            rows="3">{{ old('translations.' . $language->code . '.short_desc') }}</textarea>
                                    </div>

                                    <div class="mb-3">
                                        <label for="content_{{ $language->code }}" class="form-label">Content
                                            ({{ $language->code }})</label>
                                        <textarea class="form-control ckeditor-content" id="content_{{ $language->code }}"
                                            name="translations[{{ $language->code }}][content]">{{ old('translations.' . $language->code . '.content') }}</textarea>
                                    </div>

                                    <div class="mb-3">
                                        <label for="meta_title_{{ $language->code }}" class="form-label">Meta Title (SEO)
                                            ({{ $language->code }})</label>
                                        <input type="text" class="form-control" id="meta_title_{{ $language->code }}"
                                            name="translations[{{ $language->code }}][meta_title]"
                                            value="{{ old('translations.' . $language->code . '.meta_title') }}"
                                            placeholder="Leave empty to use service name">
                                    </div>

                                    <div class="mb-3">
                                        <label for="meta_desc_{{ $language->code }}" class="form-label">Meta Description (SEO)
                                            ({{ $language->code }})</label>
                                        <textarea class="form-control" id="meta_desc_{{ $language->code }}"
                                            name="translations[{{ $language->code }}][meta_desc]"
                                            rows="2"
                                            placeholder="Leave empty to use short description">{{ old('translations.' . $language->code . '.meta_desc') }}</textarea>
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
                            <label for="is_active" class="form-label">Status</label>
                            <select class="form-select" id="is_active" name="is_active">
                                <option value="1" {{ old('is_active', '1') == '1' ? 'selected' : '' }}>Active</option>
                                <option value="0" {{ old('is_active') == '0' ? 'selected' : '' }}>Inactive</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="sort_order" class="form-label">Sort Order</label>
                            <input type="number" class="form-control" id="sort_order" name="sort_order"
                                value="{{ old('sort_order', 0) }}">
                        </div>

                        <div class="mb-3">
                            <label for="icon_class" class="form-label">Icon Class</label>
                            <select id="icon_class" name="icon_class" class="form-control"
                                placeholder="Select Icon"></select>
                            <small class="text-muted">Type to search Bootstrap Icons (e.g. bi-gear)</small>
                        </div>

                        <div class="mb-3">
                            <label for="image_main" class="form-label">Main Image</label>
                            <input type="file" class="form-control @error('image_main') is-invalid @enderror" id="image_main" name="image_main">
                            @error('image_main')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary">Save Service</button>
                            <a href="{{ route('admin.services.index') }}" class="btn btn-secondary">Cancel</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection

@push('scripts')
    {{-- CKEditor --}}
    <script src="https://cdn.ckeditor.com/ckeditor5/38.0.1/classic/ckeditor.js"></script>
    {{-- Tom Select --}}
    <script src="https://cdn.jsdelivr.net/npm/tom-select@2.3.1/dist/js/tom-select.complete.min.js"></script>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            // Initialize CKEditor for each language content area
            const editors = document.querySelectorAll('.ckeditor-content');
            editors.forEach(editor => {
                ClassicEditor
                    .create(editor)
                    .catch(error => {
                        console.error(error);
                    });
            });

            // Comprehensive Bootstrap Icons List
            const bootstrapIcons = [
                // General & Web
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

            // Transform for Tom Select options
            const iconOptions = bootstrapIcons.map(icon => ({ value: 'bi ' + icon, text: 'bi ' + icon }));

            // Initialize Tom Select for Icon
            new TomSelect("#icon_class", {
                maxOptions: null,
                options: iconOptions,
                create: true, // Allow user to type new icons not in list
                sortField: {
                    field: "text",
                    direction: "asc"
                },
                placeholder: "Select or Type Icon Class",
                plugins: ['dropdown_input'],
                render: {
                    option: function (data, escape) {
                        return '<div><i class="' + escape(data.value) + '"></i> ' + escape(data.text) + '</div>';
                    },
                    item: function (data, escape) {
                        return '<div><i class="' + escape(data.value) + '"></i> ' + escape(data.text) + '</div>';
                    }
                }
            });
        });
    </script>
@endpush