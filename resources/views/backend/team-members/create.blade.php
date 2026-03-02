@extends('layouts.backend')

@section('title', 'Add New Team Member')

@push('styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/flag-icon-css/3.5.0/css/flag-icon.min.css">
@endpush

@section('content')
    <div class="page-header mb-3">
        <div class="page-block">
            <div class="row align-items-center">
                <div class="col-md-12">
                    <div class="page-header-title">
                        <h5 class="m-b-10">Add New Team Member</h5>
                    </div>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item">Content Management</li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.team-members.index') }}">Our Team</a></li>
                        <li class="breadcrumb-item">Add New</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <form action="{{ route('admin.team-members.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="row">

            {{-- LEFT: Translatable Content --}}
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-header">
                        <h5>Member Content</h5>
                    </div>
                    <div class="card-body">
                        <div class="alert alert-warning d-flex align-items-center mb-3" role="alert">
                            <i class="ti ti-alert-triangle me-2 fs-4"></i>
                            <div>
                                <strong>Important:</strong> You must fill in the default language
                                ({{ $sortedLanguages->where('is_default', true)->first()->name }}) content first.
                                Other languages can be added later via Edit.
                            </div>
                        </div>

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
                                            value="{{ old('translations.' . $language->code . '.position') }}"
                                            placeholder="e.g. Senior Developer, UI Designer" @if($loop->first) required @endif>
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
                                            value="{{ old('translations.' . $language->code . '.department') }}"
                                            placeholder="e.g. Engineering, Marketing">
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label" for="bio_{{ $language->code }}">
                                            Short Bio ({{ $language->code }})
                                        </label>
                                        <textarea class="form-control" id="bio_{{ $language->code }}"
                                            name="translations[{{ $language->code }}][bio]" rows="4"
                                            placeholder="A short introduction about this member...">{{ old('translations.' . $language->code . '.bio') }}</textarea>
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
                                name="name" value="{{ old('name') }}" placeholder="e.g. John Doe" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">Email Address</label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" id="email"
                                name="email" value="{{ old('email') }}" placeholder="member@company.com">
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="photo" class="form-label">Photo / Avatar</label>
                            <input class="form-control @error('photo') is-invalid @enderror" type="file" id="photo"
                                name="photo" accept="image/*">
                            <small class="text-muted">Recommended: square image, max 2MB.</small>
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
                                    value="{{ old('linkedin_url') }}" placeholder="https://linkedin.com/in/...">
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="twitter_url" class="form-label">Twitter / X URL</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="ti ti-brand-twitter"></i></span>
                                <input type="url" class="form-control" id="twitter_url" name="twitter_url"
                                    value="{{ old('twitter_url') }}" placeholder="https://twitter.com/...">
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="github_url" class="form-label">GitHub URL</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="ti ti-brand-github"></i></span>
                                <input type="url" class="form-control" id="github_url" name="github_url"
                                    value="{{ old('github_url') }}" placeholder="https://github.com/...">
                            </div>
                        </div>

                        <hr class="my-3">

                        <div class="mb-3">
                            <label for="sort_order" class="form-label">Sort Order</label>
                            <input type="number" class="form-control" id="sort_order" name="sort_order"
                                value="{{ old('sort_order', 0) }}">
                            <small class="text-muted">Lower number = displayed first.</small>
                        </div>

                        <div class="mb-3">
                            <label for="is_active" class="form-label">Status</label>
                            <select class="form-select" id="is_active" name="is_active">
                                <option value="1" {{ old('is_active', '1') == '1' ? 'selected' : '' }}>Active</option>
                                <option value="0" {{ old('is_active') == '0' ? 'selected' : '' }}>Inactive</option>
                            </select>
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary">Save Team Member</button>
                            <a href="{{ route('admin.team-members.index') }}" class="btn btn-secondary">Cancel</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection