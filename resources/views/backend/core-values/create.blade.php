@extends('layouts.backend')

@section('title', 'Add Core Value')

@push('styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/flag-icon-css/3.5.0/css/flag-icon.min.css">
    <link href="https://cdn.jsdelivr.net/npm/tom-select@2.3.1/dist/css/tom-select.bootstrap5.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    <style>
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
                        <h5 class="m-b-10">Add Core Value</h5>
                    </div>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item">Company</li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.core-values.index') }}">Core Values</a></li>
                        <li class="breadcrumb-item">Add New</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <form action="{{ route('admin.core-values.store') }}" method="POST">
        @csrf
        <div class="row">
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-header">
                        <h5>Translatable Content</h5>
                    </div>
                    <div class="card-body">
                        <div class="alert alert-warning d-flex align-items-center mb-3" role="alert">
                            <i class="ti ti-alert-triangle me-2 fs-4"></i>
                            <div>
                                <strong>Important:</strong> You must fill in the default language
                                ({{ $sortedLanguages->where('is_default', true)->first()->name }}) content first.
                            </div>
                        </div>

                        <ul class="nav nav-tabs mb-3" role="tablist">
                            @foreach($sortedLanguages as $language)
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link {{ $loop->first ? 'active' : '' }}" data-bs-toggle="tab"
                                        data-bs-target="#lang-{{ $language->code }}" type="button" role="tab">
                                        <i class="{{ $language->icon }}"></i> {{ $language->name }}
                                    </button>
                                </li>
                            @endforeach
                        </ul>

                        <div class="tab-content">
                            @foreach($sortedLanguages as $language)
                                <div class="tab-pane fade {{ $loop->first ? 'show active' : '' }}"
                                    id="lang-{{ $language->code }}" role="tabpanel">
                                    <div class="mb-3">
                                        <label class="form-label">Title ({{ $language->code }}) @if($loop->first)<span
                                        class="text-danger">*</span>@endif</label>
                                        <input type="text"
                                            class="form-control @error('translations.' . $language->code . '.title') is-invalid @enderror"
                                            name="translations[{{ $language->code }}][title]"
                                            value="{{ old('translations.' . $language->code . '.title') }}"
                                            placeholder="e.g. Accuracy & Quality" @if($loop->first) required @endif>
                                        @error('translations.' . $language->code . '.title')<div class="invalid-feedback">
                                        {{ $message }}</div>@enderror
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Description ({{ $language->code }}) @if($loop->first)<span
                                        class="text-danger">*</span>@endif</label>
                                        <textarea
                                            class="form-control @error('translations.' . $language->code . '.description') is-invalid @enderror"
                                            name="translations[{{ $language->code }}][description]" rows="4"
                                            placeholder="Describe this core value...">{{ old('translations.' . $language->code . '.description') }}</textarea>
                                        @error('translations.' . $language->code . '.description')<div class="invalid-feedback">
                                        {{ $message }}</div>@enderror
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
                            <label class="form-label">Icon <span class="text-danger">*</span></label>
                            <select id="icon_class" name="icon_class" class="form-control"
                                placeholder="Select Icon"></select>
                            <small class="text-muted">Type to search Bootstrap Icons (e.g. bi-shield)</small>
                            @error('icon_class')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Sort Order</label>
                            <input type="number" class="form-control" name="sort_order" value="{{ old('sort_order', 0) }}">
                            <small class="text-muted">Lower = displayed first</small>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Status</label>
                            <select class="form-select" name="is_active">
                                <option value="1" {{ old('is_active', '1') == '1' ? 'selected' : '' }}>Active</option>
                                <option value="0" {{ old('is_active') == '0' ? 'selected' : '' }}>Inactive</option>
                            </select>
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary">Save Core Value</button>
                            <a href="{{ route('admin.core-values.index') }}" class="btn btn-secondary">Cancel</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/tom-select@2.3.1/dist/js/tom-select.complete.min.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
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
                "bi-facebook", "bi-twitter", "bi-instagram", "bi-linkedin", "bi-youtube",
                "bi-github", "bi-google", "bi-whatsapp", "bi-telegram", "bi-messenger",
                "bi-slack", "bi-skype", "bi-windows", "bi-apple", "bi-android",
                "bi-patch-check", "bi-patch-check-fill", "bi-flag", "bi-flag-fill",
                "bi-hand-thumbs-up", "bi-hand-thumbs-up-fill", "bi-clock", "bi-clock-fill",
                "bi-eye", "bi-eye-fill", "bi-translate", "bi-journal-text",
                "bi-diagram-3", "bi-diagram-3-fill", "bi-speedometer", "bi-speedometer2"
            ];

            const iconOptions = bootstrapIcons.map(icon => ({ value: 'bi ' + icon, text: 'bi ' + icon }));

            new TomSelect("#icon_class", {
                maxOptions: null,
                options: iconOptions,
                items: {!! json_encode([old('icon_class', 'bi bi-shield-check')]) !!},
                create: true,
                sortField: { field: "text", direction: "asc" },
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