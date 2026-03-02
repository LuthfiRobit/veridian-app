@extends('layouts.backend')

@section('title', 'Company Profile')

@push('styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/flag-icon-css/3.5.0/css/flag-icon.min.css">
    <style>
        .section-hint {
            background: #f0f4ff;
            border-left: 3px solid #4680ff;
            padding: 8px 12px;
            margin-bottom: 16px;
            border-radius: 0 6px 6px 0;
            font-size: 13px;
            color: #5a6270;
        }

        .section-hint i {
            color: #4680ff;
            margin-right: 5px;
        }

        .section-hint strong {
            color: #333;
        }
    </style>
@endpush

@section('content')
    <div class="page-header mb-3">
        <div class="page-block">
            <div class="row align-items-center">
                <div class="col-md-12">
                    <div class="page-header-title">
                        <h5 class="m-b-10">Company Profile</h5>
                    </div>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item">Company</li>
                        <li class="breadcrumb-item">Profile</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <form action="{{ route('admin.company-profile.update') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        {{-- ═══════════════════════════════════════════════════════ --}}
        {{-- ROW 1: About (translatable) + Stats & Images sidebar --}}
        {{-- ═══════════════════════════════════════════════════════ --}}
        <div class="row">
            {{-- LEFT: Translatable Content --}}
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-header">
                        <h5><i class="ti ti-building me-2"></i>About Company</h5>
                    </div>
                    <div class="card-body">
                        <div class="section-hint">
                            <i class="ti ti-info-circle"></i>
                            Ditampilkan di: <strong>Homepage → About Section</strong> dan <strong>About Page → Company
                                Overview</strong>
                        </div>

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

                        <div class="tab-content" id="languageTabContent">
                            @foreach($sortedLanguages as $language)
                                @php $t = $profile->translate($language->code); @endphp
                                <div class="tab-pane fade {{ $loop->first ? 'show active' : '' }}"
                                    id="lang-{{ $language->code }}" role="tabpanel">

                                    <h6 class="text-primary mb-3"><i class="ti ti-info-circle me-1"></i> About Section</h6>

                                    <div class="mb-3">
                                        <label class="form-label">About Title ({{ $language->code }}) @if($loop->first)<span
                                        class="text-danger">*</span>@endif</label>
                                        <input type="text"
                                            class="form-control @error('translations.' . $language->code . '.about_title') is-invalid @enderror"
                                            name="translations[{{ $language->code }}][about_title]"
                                            value="{{ old('translations.' . $language->code . '.about_title', $t?->about_title) }}"
                                            @if($loop->first) required @endif>
                                        @error('translations.' . $language->code . '.about_title')<div class="invalid-feedback">
                                        {{ $message }}</div>@enderror
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">About Subtitle ({{ $language->code }})</label>
                                        <input type="text" class="form-control"
                                            name="translations[{{ $language->code }}][about_subtitle]"
                                            value="{{ old('translations.' . $language->code . '.about_subtitle', $t?->about_subtitle) }}">
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Lead Text ({{ $language->code }}) @if($loop->first)<span
                                        class="text-danger">*</span>@endif</label>
                                        <textarea
                                            class="form-control @error('translations.' . $language->code . '.about_lead_text') is-invalid @enderror"
                                            name="translations[{{ $language->code }}][about_lead_text]"
                                            rows="3">{{ old('translations.' . $language->code . '.about_lead_text', $t?->about_lead_text) }}</textarea>
                                        @error('translations.' . $language->code . '.about_lead_text')<div
                                        class="invalid-feedback">{{ $message }}</div>@enderror
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Description ({{ $language->code }})</label>
                                        <textarea class="form-control"
                                            name="translations[{{ $language->code }}][about_description]"
                                            rows="3">{{ old('translations.' . $language->code . '.about_description', $t?->about_description) }}</textarea>
                                    </div>

                                    <hr class="my-4">
                                    <h6 class="text-primary mb-2"><i class="ti ti-target me-1"></i> Mission & Vision</h6>
                                    <div class="section-hint mb-3">
                                        <i class="ti ti-info-circle"></i>
                                        Ditampilkan di: <strong>About Page → Mission & Vision Section</strong>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label">Mission Title ({{ $language->code }})
                                                    @if($loop->first)<span class="text-danger">*</span>@endif</label>
                                                <input type="text"
                                                    class="form-control @error('translations.' . $language->code . '.mission_title') is-invalid @enderror"
                                                    name="translations[{{ $language->code }}][mission_title]"
                                                    value="{{ old('translations.' . $language->code . '.mission_title', $t?->mission_title) }}"
                                                    @if($loop->first) required @endif>
                                                @error('translations.' . $language->code . '.mission_title')<div
                                                class="invalid-feedback">{{ $message }}</div>@enderror
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Mission Description ({{ $language->code }})
                                                    @if($loop->first)<span class="text-danger">*</span>@endif</label>
                                                <textarea
                                                    class="form-control @error('translations.' . $language->code . '.mission_description') is-invalid @enderror"
                                                    name="translations[{{ $language->code }}][mission_description]"
                                                    rows="4">{{ old('translations.' . $language->code . '.mission_description', $t?->mission_description) }}</textarea>
                                                @error('translations.' . $language->code . '.mission_description')<div
                                                class="invalid-feedback">{{ $message }}</div>@enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label">Vision Title ({{ $language->code }})
                                                    @if($loop->first)<span class="text-danger">*</span>@endif</label>
                                                <input type="text"
                                                    class="form-control @error('translations.' . $language->code . '.vision_title') is-invalid @enderror"
                                                    name="translations[{{ $language->code }}][vision_title]"
                                                    value="{{ old('translations.' . $language->code . '.vision_title', $t?->vision_title) }}"
                                                    @if($loop->first) required @endif>
                                                @error('translations.' . $language->code . '.vision_title')<div
                                                class="invalid-feedback">{{ $message }}</div>@enderror
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Vision Description ({{ $language->code }})
                                                    @if($loop->first)<span class="text-danger">*</span>@endif</label>
                                                <textarea
                                                    class="form-control @error('translations.' . $language->code . '.vision_description') is-invalid @enderror"
                                                    name="translations[{{ $language->code }}][vision_description]"
                                                    rows="4">{{ old('translations.' . $language->code . '.vision_description', $t?->vision_description) }}</textarea>
                                                @error('translations.' . $language->code . '.vision_description')<div
                                                class="invalid-feedback">{{ $message }}</div>@enderror
                                            </div>
                                        </div>
                                    </div>

                                    <hr class="my-4">
                                    <h6 class="text-primary mb-2"><i class="ti ti-layout-bottombar me-1"></i> Footer</h6>
                                    <div class="section-hint mb-3">
                                        <i class="ti ti-info-circle"></i>
                                        Ditampilkan di: <strong>Footer → deskripsi singkat di bawah logo</strong>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Footer Description ({{ $language->code }})</label>
                                        <textarea class="form-control"
                                            name="translations[{{ $language->code }}][footer_description]"
                                            rows="2">{{ old('translations.' . $language->code . '.footer_description', $t?->footer_description) }}</textarea>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

            {{-- RIGHT: Stats & Images --}}
            <div class="col-lg-4">
                <div class="card">
                    <div class="card-header">
                        <h5><i class="ti ti-chart-bar me-2"></i>Company Stats</h5>
                    </div>
                    <div class="card-body">
                        <div class="section-hint">
                            <i class="ti ti-info-circle"></i>
                            Ditampilkan di: <strong>Homepage → Hero & About</strong>, <strong>About Page</strong>
                        </div>
                        <div class="row g-3">
                            <div class="col-6">
                                <label class="form-label">Projects Done <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="stat_projects"
                                    value="{{ old('stat_projects', $profile->stat_projects) }}" required>
                            </div>
                            <div class="col-6">
                                <label class="form-label">Happy Clients <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="stat_clients"
                                    value="{{ old('stat_clients', $profile->stat_clients) }}" required>
                            </div>
                            <div class="col-6">
                                <label class="form-label">Retention <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="stat_retention"
                                    value="{{ old('stat_retention', $profile->stat_retention) }}" required>
                            </div>
                            <div class="col-6">
                                <label class="form-label">Experience <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="stat_experience"
                                    value="{{ old('stat_experience', $profile->stat_experience) }}" required>
                            </div>
                            <div class="col-6">
                                <label class="form-label">Languages <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="stat_languages"
                                    value="{{ old('stat_languages', $profile->stat_languages) }}" required>
                            </div>
                            <div class="col-6">
                                <label class="form-label">Satisfaction <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="stat_satisfaction"
                                    value="{{ old('stat_satisfaction', $profile->stat_satisfaction) }}" required>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header">
                        <h5><i class="ti ti-photo me-2"></i>About Images</h5>
                    </div>
                    <div class="card-body">
                        <div class="section-hint">
                            <i class="ti ti-info-circle"></i>
                            Ditampilkan di: <strong>Homepage & About Page → About Section</strong>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Main Image</label>
                            @if($profile->about_image_main)
                                <div class="mb-2">
                                    <img src="{{ Storage::url($profile->about_image_main) }}" alt="Main"
                                        class="img-thumbnail rounded" style="max-height:80px; object-fit:cover;">
                                </div>
                                <div class="form-check mb-2">
                                    <input class="form-check-input" type="checkbox" id="remove_about_image_main"
                                        name="remove_about_image_main" value="1">
                                    <label class="form-check-label text-danger" for="remove_about_image_main">Remove</label>
                                </div>
                            @endif
                            <input class="form-control" type="file" name="about_image_main" accept="image/*">
                            <small class="text-muted">Max 2MB. 600×400px</small>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Secondary Image</label>
                            @if($profile->about_image_secondary)
                                <div class="mb-2">
                                    <img src="{{ Storage::url($profile->about_image_secondary) }}" alt="Secondary"
                                        class="img-thumbnail rounded" style="max-height:80px; object-fit:cover;">
                                </div>
                                <div class="form-check mb-2">
                                    <input class="form-check-input" type="checkbox" id="remove_about_image_secondary"
                                        name="remove_about_image_secondary" value="1">
                                    <label class="form-check-label text-danger"
                                        for="remove_about_image_secondary">Remove</label>
                                </div>
                            @endif
                            <input class="form-control" type="file" name="about_image_secondary" accept="image/*">
                            <small class="text-muted">Max 2MB. 300×300px</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- ═══════════════════════════════════════════════════════ --}}
        {{-- ROW 2: Contact Info + Social Media (full width) --}}
        {{-- ═══════════════════════════════════════════════════════ --}}
        <div class="row">
            <div class="col-lg-6">
                <div class="card">
                    <div class="card-header">
                        <h5><i class="ti ti-address-book me-2"></i>Contact Info</h5>
                    </div>
                    <div class="card-body">
                        <div class="section-hint">
                            <i class="ti ti-info-circle"></i>
                            Ditampilkan di: <strong>Homepage → Contact Section</strong> dan <strong>Footer</strong>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Address</label>
                            <input type="text" class="form-control" name="address"
                                value="{{ old('address', $profile->address) }}" placeholder="Jakarta, Indonesia">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Phone</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="ti ti-phone"></i></span>
                                <input type="text" class="form-control" name="phone"
                                    value="{{ old('phone', $profile->phone) }}" placeholder="+62 812-3456-7890">
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="ti ti-mail"></i></span>
                                <input type="email" class="form-control" name="email"
                                    value="{{ old('email', $profile->email) }}" placeholder="contact@example.com">
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">WhatsApp</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="ti ti-brand-whatsapp"></i></span>
                                <input type="text" class="form-control" name="whatsapp"
                                    value="{{ old('whatsapp', $profile->whatsapp) }}" placeholder="6281234567890">
                            </div>
                            <small class="text-muted">Tanpa + atau spasi</small>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Google Maps URL</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="ti ti-map-pin"></i></span>
                                <input type="url" class="form-control" name="google_maps_url"
                                    value="{{ old('google_maps_url', $profile->google_maps_url) }}"
                                    placeholder="https://maps.google.com/...">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-6">
                <div class="card">
                    <div class="card-header">
                        <h5><i class="ti ti-share me-2"></i>Social Media</h5>
                    </div>
                    <div class="card-body">
                        <div class="section-hint">
                            <i class="ti ti-info-circle"></i>
                            Ditampilkan di: <strong>Footer → Social Links</strong>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Facebook</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="ti ti-brand-facebook"></i></span>
                                    <input type="url" class="form-control" name="social_facebook"
                                        value="{{ old('social_facebook', $profile->social_facebook) }}"
                                        placeholder="https://facebook.com/...">
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Instagram</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="ti ti-brand-instagram"></i></span>
                                    <input type="url" class="form-control" name="social_instagram"
                                        value="{{ old('social_instagram', $profile->social_instagram) }}"
                                        placeholder="https://instagram.com/...">
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Twitter / X</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="ti ti-brand-twitter"></i></span>
                                    <input type="url" class="form-control" name="social_twitter"
                                        value="{{ old('social_twitter', $profile->social_twitter) }}"
                                        placeholder="https://x.com/...">
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">LinkedIn</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="ti ti-brand-linkedin"></i></span>
                                    <input type="url" class="form-control" name="social_linkedin"
                                        value="{{ old('social_linkedin', $profile->social_linkedin) }}"
                                        placeholder="https://linkedin.com/company/...">
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">YouTube</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="ti ti-brand-youtube"></i></span>
                                    <input type="url" class="form-control" name="social_youtube"
                                        value="{{ old('social_youtube', $profile->social_youtube) }}"
                                        placeholder="https://youtube.com/@...">
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">TikTok</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="ti ti-brand-tiktok"></i></span>
                                    <input type="url" class="form-control" name="social_tiktok"
                                        value="{{ old('social_tiktok', $profile->social_tiktok) }}"
                                        placeholder="https://tiktok.com/@...">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- ═══════════════════════════════════════════════════════ --}}
        {{-- ROW 3: Publish (full width, bottom) --}}
        {{-- ═══════════════════════════════════════════════════════ --}}
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body py-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="d-flex align-items-center gap-3">
                                <label for="is_active" class="form-label mb-0 fw-semibold">Status</label>
                                <select class="form-select" id="is_active" name="is_active" style="width: auto;">
                                    <option value="1" {{ old('is_active', $profile->is_active ? '1' : '0') == '1' ? 'selected' : '' }}>Active</option>
                                    <option value="0" {{ old('is_active', $profile->is_active ? '1' : '0') == '0' ? 'selected' : '' }}>Inactive</option>
                                </select>
                            </div>
                            <button type="submit" class="btn btn-primary"><i class="ti ti-device-floppy me-1"></i> Save
                                Changes</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </form>
@endsection