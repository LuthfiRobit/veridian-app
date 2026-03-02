@extends('layouts.backend')

@section('title', 'Edit Testimonial')

@push('styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/flag-icon-css/3.5.0/css/flag-icon.min.css">
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">
@endpush

@section('content')
    <div class="page-header mb-3">
        <div class="page-block">
            <div class="row align-items-center">
                <div class="col-md-12">
                    <div class="page-header-title">
                        <h5 class="m-b-10">Edit Testimonial</h5>
                    </div>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item">Content Management</li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.testimonials.index') }}">Testimonials</a></li>
                        <li class="breadcrumb-item">Edit</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <form action="{{ route('admin.testimonials.update', $testimonial->id_testimonial) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="row">
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-header">
                        <h5>Testimonial Content</h5>
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
                                @php $translation = $testimonial->translate($language->code); @endphp
                                <div class="tab-pane fade {{ $loop->first ? 'show active' : '' }}"
                                    id="lang-{{ $language->code }}" role="tabpanel" aria-labelledby="tab-{{ $language->code }}">

                                    <div class="mb-3">
                                        <label for="client_position_{{ $language->code }}" class="form-label">
                                            Client Position / Title ({{ $language->code }})
                                        </label>
                                        <input type="text"
                                            class="form-control @error('translations.' . $language->code . '.client_position') is-invalid @enderror"
                                            id="client_position_{{ $language->code }}"
                                            name="translations[{{ $language->code }}][client_position]"
                                            value="{{ old('translations.' . $language->code . '.client_position', $translation?->client_position) }}"
                                            placeholder="e.g. CEO, Marketing Director">
                                        @error('translations.' . $language->code . '.client_position')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label for="content_{{ $language->code }}" class="form-label">
                                            Review Content ({{ $language->code }})
                                            @if($loop->first) <span class="text-danger">*</span> @endif
                                        </label>
                                        <textarea class="form-control summernote @error('translations.' . $language->code . '.content') is-invalid @enderror"
                                            id="content_{{ $language->code }}"
                                            name="translations[{{ $language->code }}][content]"
                                            @if($loop->first) required @endif>{{ old('translations.' . $language->code . '.content', $translation?->content) }}</textarea>
                                        @error('translations.' . $language->code . '.content')
                                            <div class="invalid-feedback d-block">{{ $message }}</div>
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
                        <h5>Settings & Publish</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label for="client_name" class="form-label">Client Name <span class="text-danger">*</span></label>
                            <input type="text"
                                class="form-control @error('client_name') is-invalid @enderror"
                                id="client_name" name="client_name"
                                value="{{ old('client_name', $testimonial->client_name) }}"
                                required>
                            @error('client_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="id_project" class="form-label">Related Project</label>
                            <select class="form-select @error('id_project') is-invalid @enderror" id="id_project" name="id_project">
                                <option value="">— No Project —</option>
                                @foreach($projects as $project)
                                    <option value="{{ $project->id_project }}" {{ old('id_project', $testimonial->id_project) == $project->id_project ? 'selected' : '' }}>
                                        {{ $project->title }}
                                    </option>
                                @endforeach
                            </select>
                            @error('id_project')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="rating" class="form-label">Rating <span class="text-danger">*</span></label>
                            <select class="form-select @error('rating') is-invalid @enderror" id="rating" name="rating">
                                @for($i = 5; $i >= 1; $i--)
                                    <option value="{{ $i }}" {{ old('rating', $testimonial->rating) == $i ? 'selected' : '' }}>
                                        {{ $i }} Star{{ $i > 1 ? 's' : '' }}
                                    </option>
                                @endfor
                            </select>
                            @error('rating')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Current Avatar</label>
                            @if($testimonial->avatar_path)
                                <div class="mb-2">
                                    <img src="{{ Storage::url($testimonial->avatar_path) }}"
                                        alt="{{ $testimonial->client_name }}"
                                        class="img-thumbnail rounded"
                                        style="max-height:80px; max-width:80px; object-fit:cover;">
                                </div>
                                <div class="form-check mb-2">
                                    <input class="form-check-input" type="checkbox" id="remove_avatar" name="remove_avatar" value="1">
                                    <label class="form-check-label text-danger" for="remove_avatar">Remove current avatar</label>
                                </div>
                            @else
                                <p class="text-muted small mb-2">No avatar uploaded.</p>
                            @endif
                            <label for="avatar" class="form-label">{{ $testimonial->avatar_path ? 'Replace Avatar' : 'Upload Avatar' }}</label>
                            <input class="form-control @error('avatar') is-invalid @enderror"
                                type="file" id="avatar" name="avatar" accept="image/*">
                            <small class="text-muted">Max 2MB.</small>
                            @error('avatar')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="sort_order" class="form-label">Sort Order</label>
                            <input type="number" class="form-control" id="sort_order" name="sort_order"
                                value="{{ old('sort_order', $testimonial->sort_order) }}">
                        </div>

                        <div class="mb-3">
                            <label for="is_active" class="form-label">Status</label>
                            <select class="form-select" id="is_active" name="is_active">
                                <option value="1" {{ old('is_active', $testimonial->is_active ? '1' : '0') == '1' ? 'selected' : '' }}>Active</option>
                                <option value="0" {{ old('is_active', $testimonial->is_active ? '1' : '0') == '0' ? 'selected' : '' }}>Inactive</option>
                            </select>
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary">Save Changes</button>
                            <a href="{{ route('admin.testimonials.index') }}" class="btn btn-secondary">Cancel</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>
    <script>
        $(document).ready(function () {
            $('.summernote').summernote({
                height: 180,
                toolbar: [
                    ['style', ['bold', 'italic', 'underline', 'clear']],
                    ['font', ['strikethrough']],
                    ['para', ['ul', 'ol', 'paragraph']],
                    ['view', ['fullscreen', 'codeview']],
                ]
            });

            // Disable file input when "Remove" is checked
            $('#remove_avatar').on('change', function () {
                $('#avatar').prop('disabled', $(this).is(':checked'));
                if ($(this).is(':checked')) $('#avatar').val('');
            });
        });
    </script>
@endpush
