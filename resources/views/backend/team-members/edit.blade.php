@extends('layouts.backend')

@section('title', 'Edit Team Member')

@push('styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/flag-icon-css/3.5.0/css/flag-icon.min.css">
@endpush

@section('content')
    <div class="page-header mb-3">
        <div class="page-block">
            <div class="row align-items-center">
                <div class="col-md-12">
                    <div class="page-header-title">
                        <h5 class="m-b-10">Edit Team Member</h5>
                    </div>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item">Content Management</li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.team-members.index') }}">Our Team</a></li>
                        <li class="breadcrumb-item">Edit</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <form action="{{ route('admin.team-members.update', $member->id_team_member) }}" method="POST"
        enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="row">

            {{-- LEFT: Translatable Content --}}
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-header">
                        <h5>Member Content</h5>
                    </div>
                    <div class="card-body">
                        {{-- Language Tabs --}}
                        <ul class="nav nav-tabs mb-3" id="languageTabs" role="tablist">
                            @foreach($sortedLanguages as $language)
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link {{ $loop->first ? 'active' : '' }}" id="tab-{{ $language->code }}"
                                        data-bs-toggle="tab" data-bs-target="#lang-{{ $language->code }}" type="button"
                                        role="tab">
                                        <i class="{{ $language->icon }}"></i> {{ $language->name }}
                                    </button>
                                </li>
                            @endforeach
                        </ul>

                        {{-- Tab Content --}}
                        <div class="tab-content" id="languageTabContent">
                            @foreach($sortedLanguages as $language)
                                @php $translation = $member->translate($language->code); @endphp
                                <div class="tab-pane fade {{ $loop->first ? 'show active' : '' }}"
                                    id="lang-{{ $language->code }}" role="tabpanel">

                                    <div class="mb-3">
                                        <label class="form-label" for="position_{{ $language->code }}">
                                            Position / Job Title ({{ $language->code }})
                                            @if($loop->first) <span class="text-danger">*</span> @endif
                                        </label>
                                        <input type="text"
                                            class="form-control @error('translations.' . $language->code . '.position') is-invalid @enderror"
                                            id="position_{{ $language->code }}"
                                            name="translations[{{ $language->code }}][position]"
                                            value="{{ old('translations.' . $language->code . '.position', $translation?->position) }}"
                                            @if($loop->first) required @endif>
                                        @error('translations.' . $language->code . '.position')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label" for="department_{{ $language->code }}">
                                            Department ({{ $language->code }})
                                        </label>
                                        <input type="text" class="form-control" id="department_{{ $language->code }}"
                                            name="translations[{{ $language->code }}][department]"
                                            value="{{ old('translations.' . $language->code . '.department', $translation?->department) }}">
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label" for="bio_{{ $language->code }}">
                                            Short Bio ({{ $language->code }})
                                        </label>
                                        <textarea class="form-control" id="bio_{{ $language->code }}"
                                            name="translations[{{ $language->code }}][bio]"
                                            rows="4">{{ old('translations.' . $language->code . '.bio', $translation?->bio) }}</textarea>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

            {{-- RIGHT: Settings --}}
            <div class="col-lg-4">
                <div class="card">
                    <div class="card-header">
                        <h5>Settings &amp; Publish</h5>
                    </div>
                    <div class="card-body">

                        <div class="mb-3">
                            <label for="name" class="form-label">Full Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name"
                                name="name" value="{{ old('name', $member->name) }}" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">Email Address</label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" id="email"
                                name="email" value="{{ old('email', $member->email) }}">
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Current Photo</label>
                            @if($member->photo_path)
                                <div class="mb-2">
                                    <img src="{{ Storage::url($member->photo_path) }}" alt="{{ $member->name }}"
                                        class="img-thumbnail rounded"
                                        style="max-height:80px; max-width:80px; object-fit:cover;">
                                </div>
                                <div class="form-check mb-2">
                                    <input class="form-check-input" type="checkbox" id="remove_photo" name="remove_photo"
                                        value="1">
                                    <label class="form-check-label text-danger" for="remove_photo">Remove current photo</label>
                                </div>
                            @else
                                <p class="text-muted small mb-2">No photo uploaded.</p>
                            @endif
                            <label for="photo"
                                class="form-label">{{ $member->photo_path ? 'Replace Photo' : 'Upload Photo' }}</label>
                            <input class="form-control @error('photo') is-invalid @enderror" type="file" id="photo"
                                name="photo" accept="image/*">
                            <small class="text-muted">Max 2MB.</small>
                            @error('photo')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <hr class="my-3">
                        <p class="form-label fw-semibold mb-2"><i class="ti ti-share me-1"></i> Social Links</p>

                        <div class="mb-3">
                            <label for="linkedin_url" class="form-label">LinkedIn URL</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="ti ti-brand-linkedin"></i></span>
                                <input type="url" class="form-control" id="linkedin_url" name="linkedin_url"
                                    value="{{ old('linkedin_url', $member->linkedin_url) }}"
                                    placeholder="https://linkedin.com/in/...">
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="twitter_url" class="form-label">Twitter / X URL</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="ti ti-brand-twitter"></i></span>
                                <input type="url" class="form-control" id="twitter_url" name="twitter_url"
                                    value="{{ old('twitter_url', $member->twitter_url) }}"
                                    placeholder="https://twitter.com/...">
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="github_url" class="form-label">GitHub URL</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="ti ti-brand-github"></i></span>
                                <input type="url" class="form-control" id="github_url" name="github_url"
                                    value="{{ old('github_url', $member->github_url) }}"
                                    placeholder="https://github.com/...">
                            </div>
                        </div>

                        <hr class="my-3">

                        <div class="mb-3">
                            <label for="sort_order" class="form-label">Sort Order</label>
                            <input type="number" class="form-control" id="sort_order" name="sort_order"
                                value="{{ old('sort_order', $member->sort_order) }}">
                        </div>

                        <div class="mb-3">
                            <label for="is_active" class="form-label">Status</label>
                            <select class="form-select" id="is_active" name="is_active">
                                <option value="1" {{ old('is_active', $member->is_active ? '1' : '0') == '1' ? 'selected' : '' }}>Active</option>
                                <option value="0" {{ old('is_active', $member->is_active ? '1' : '0') == '0' ? 'selected' : '' }}>Inactive</option>
                            </select>
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary">Save Changes</button>
                            <a href="{{ route('admin.team-members.index') }}" class="btn btn-secondary">Cancel</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection

@push('scripts')
    <script>
        $(document).ready(function () {
            // Disable file input when remove is checked
            $('#remove_photo').on('change', function () {
                $('#photo').prop('disabled', $(this).is(':checked'));
                if ($(this).is(':checked')) $('#photo').val('');
            });
        });
    </script>
@endpush