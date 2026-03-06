@extends('layouts.landing')

@section('title', ($company->translate($currentLocale)?->name ?? __('nav.about_us')) . ' | ' . ($company->translate($currentLocale)?->name ?? __('meta.fallback_company_name')))
@section('meta_description', Str::limit($company->translate($currentLocale)?->about_description ?? __('meta.fallback_about_desc'), 160))

@push('styles')
    <link href="{{ asset('company-landing/assets/css/team.css') }}" rel="stylesheet">
@endpush

@section('content')

    <!-- Page Title -->
    <div class="page-title page-title-animated" data-aos="fade">
        <div class="heading">
            <div class="container">
                <div class="row d-flex justify-content-center text-center">
                    <div class="col-lg-8">
                        <span class="service-badge"><i class="bi bi-info-circle"></i> {{ __('nav.about_us') }}</span>
                        <h1>{{ $company->translate($currentLocale)?->about_title ?? __('about_page.fallback_title') }}</h1>
                        <p class="mb-0">
                            {{ Str::limit($company->translate($currentLocale)?->about_description ?? __('about_page.fallback_breadcrumb_desc'), 120) }}
                        </p>
                    </div>
                </div>
            </div>
        </div>
        <nav class="breadcrumbs">
            <div class="container">
                <ol>
                    <li><a href="{{ route('home', ['locale' => $currentLocale]) }}">{{ __('common.home') }}</a></li>
                    <li class="current">{{ __('nav.about_us') }}</li>
                </ol>
            </div>
        </nav>
    </div><!-- End Page Title -->

    <!-- Company Overview Section -->
    <section class="about-overview section">
        <div class="container" data-aos="fade-up">
            <div class="row gy-5 align-items-center">
                <div class="col-xl-6">
                    <div class="about-images-wrapper">
                        <div class="image-main">
                            @if($company->about_image_main && \Storage::disk('public')->exists($company->about_image_main))
                                <img src="{{ asset('storage/' . $company->about_image_main) }}"
                                    alt="Veridian Solutions Team" class="img-fluid" style="border-radius: 20px;">
                            @else
                                <img src="https://ui-avatars.com/api/?name={{ urlencode($company->company_name ?? 'About') }}&background=123a32&color=fff&size=800&font-size=0.1&length=2"
                                    alt="Veridian Solutions Team" class="img-fluid" style="border-radius: 20px;">
                            @endif
                        </div>
                        <div class="image-offset">
                            @if($company->about_image_secondary && \Storage::disk('public')->exists($company->about_image_secondary))
                                <img src="{{ asset('storage/' . $company->about_image_secondary) }}"
                                    alt="Translation Services" class="img-fluid" style="border-radius: 20px;">
                            @else
                                <img src="https://ui-avatars.com/api/?name={{ urlencode($company->company_name ?? 'Services') }}&background=123a32&color=fff&size=800&font-size=0.1&length=2"
                                    alt="Translation Services" class="img-fluid" style="border-radius: 20px;">
                            @endif
                        </div>
                        <div class="experience-badge">
                            <span class="years purecounter" data-purecounter-start="0"
                                data-purecounter-end="{{ (int) ($company->stat_experience ?? 15) }}"
                                data-purecounter-duration="1">{{ (int) ($company->stat_experience ?? 15) }}</span>
                            <span class="text">{{ __('about.years_of_excellence') }}</span>
                        </div>
                    </div>
                </div>

                <div class="col-xl-6">
                    <div class="about-content">
                        <div class="section-subtitle">{{ __('about.section_subtitle') }}</div>
                        <h2>{{ $company->translate($currentLocale)?->about_title ?? __('about.fallback_title') }}</h2>
                        <p class="lead-text">
                            {{ $company->translate($currentLocale)?->about_description ?? __('about.fallback_description') }}
                        </p>

                        <div class="stats-row mt-4">
                            <div class="stat-box">
                                <span class="number purecounter" data-purecounter-start="0"
                                    data-purecounter-end="{{ (int) ($company->stat_projects ?? 500) }}"
                                    data-purecounter-duration="1">{{ (int) ($company->stat_projects ?? 500) }}</span>
                                <span class="label">{{ __('about.projects_done') }}</span>
                            </div>
                            <div class="stat-box">
                                <span class="number purecounter" data-purecounter-start="0" data-purecounter-end="200"
                                    data-purecounter-duration="1">200</span>
                                <span class="label">{{ __('about.happy_clients') }}</span>
                            </div>
                            <div class="stat-box">
                                <span class="number purecounter" data-purecounter-start="0"
                                    data-purecounter-end="{{ (int) ($company->stat_satisfaction ?? 95) }}"
                                    data-purecounter-duration="1">{{ (int) ($company->stat_satisfaction ?? 95) }}%</span>
                                <span class="label">{{ __('about.retention') }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Mission & Vision Section (Static for now as there's no DB model for Mission/Vision) -->
    <section class="mission-vision section">
        <div class="container" data-aos="fade-up">
            <div class="row gy-4">
                <div class="col-lg-6">
                    <div class="mission-card">
                        <div class="card-icon">
                            <i class="bi bi-bullseye"></i>
                        </div>
                        <div class="card-content">
                            <h3>{{ $company->translate($currentLocale)?->mission_title ?? __('about_page.our_mission') }}</h3>
                            <p>{{ $company->translate($currentLocale)?->mission_description ?? __('about_page.mission_text') }}</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="vision-card">
                        <div class="card-icon">
                            <i class="bi bi-eye"></i>
                        </div>
                        <div class="card-content">
                            <h3>{{ $company->translate($currentLocale)?->vision_title ?? __('about_page.our_vision') }}</h3>
                            <p>{{ $company->translate($currentLocale)?->vision_description ?? __('about_page.vision_text') }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Core Values Section -->
    <section class="values-section section">
        <div class="container">
            <div class="section-header text-center" data-aos="fade-up">
                <div class="section-subtitle">{{ __('about_page.what_drives_us') }}</div>
                <h2>{{ __('about_page.our_core_values') }}</h2>
                <p class="lead-text">{{ __('about_page.core_values_subtitle') }}</p>
            </div>

            <div class="values-grid" data-aos="fade-up" data-aos-delay="100">
                @forelse($coreValues as $index => $value)
                    @php
                        $valTrans = $value->translate($currentLocale) ?? $value->translate(config('app.fallback_locale'));
                        $delay = 100 * (($index % 3) + 1);
                    @endphp
                    <div class="value-card" data-aos="zoom-in" data-aos-delay="{{ $delay }}">
                        <div class="value-icon">
                            <i class="{{ $value->icon_class ?? 'bi bi-shield-check' }}"></i>
                        </div>
                        <h4>{{ $valTrans?->title ?? __('about_page.fallback_value_title') }}</h4>
                        <p>{{ $valTrans?->description ?? __('about_page.fallback_value_desc') }}</p>
                    </div>
                @empty
                    <div class="col-12 text-center text-muted">
                        <p>{{ __('common.no_data') }}</p>
                    </div>
                @endforelse
            </div>
        </div>
    </section>

    <!-- Company Timeline Section -->
    <section class="timeline-section section">
        <div class="container">
            <div class="section-header text-center" data-aos="fade-up">
                <div class="section-subtitle">{{ __('about_page.our_journey') }}</div>
                <h2>{{ __('about_page.company_timeline') }}</h2>
                <p class="lead-text">{{ __('about_page.timeline_subtitle') }}</p>
            </div>

            <div class="timeline" data-aos="fade-up" data-aos-delay="100">
                @forelse($timelines as $index => $timeline)
                    @php
                        $timeTrans = $timeline->translate($currentLocale) ?? $timeline->translate(config('app.fallback_locale'));
                        $alignmentClass = $index % 2 == 0 ? 'left' : 'right';
                    @endphp
                    <div class="timeline-item {{ $alignmentClass }}">
                        <div class="timeline-marker">
                            <span class="year">{{ $timeline->year }}</span>
                        </div>
                        <div class="timeline-content">
                            <div class="timeline-icon">
                                <i class="{{ $timeline->icon_class ?? 'bi bi-flag' }}"></i>
                            </div>
                            <h4>{{ $timeTrans?->title ?? 'Milestone Title' }}</h4>
                            <p>{{ $timeTrans?->description ?? 'Milestone description...' }}</p>
                        </div>
                    </div>
                @empty
                    <p class="text-center text-muted col-12">{{ __('common.no_data') }}</p>
                @endforelse
            </div>
        </div>
    </section>

    <!-- Certifications Section -->
    <section class="certifications-section section">
        <div class="container">
            <div class="section-header text-center" data-aos="fade-up">
                <div class="section-subtitle">{{ __('about_page.quality_trust') }}</div>
                <h2>{{ __('about_page.certifications_title') }}</h2>
                <p class="lead-text">{{ __('about_page.certifications_subtitle') }}</p>
            </div>

            <div class="certifications-grid" data-aos="fade-up" data-aos-delay="100">
                @forelse($certifications as $index => $cert)
                    @php
                        $certTrans = $cert->translate($currentLocale) ?? $cert->translate(config('app.fallback_locale'));
                        $delay = 100 * (($index % 4) + 1);
                    @endphp
                    <div class="cert-card" data-aos="zoom-in" data-aos-delay="{{ $delay }}">
                        <div class="cert-icon">
                            <i class="{{ $cert->icon_class ?? 'bi bi-patch-check' }}"></i>
                        </div>
                        <h5>{{ $certTrans?->name ?? __('about_page.fallback_cert_name') }}</h5>
                        <p>{{ $certTrans?->description ?? __('about_page.fallback_cert_desc') }}</p>
                    </div>
                @empty
                    <div class="col-12 text-center text-muted">
                        <p>{{ __('common.no_data') }}</p>
                    </div>
                @endforelse
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="cta-section section" data-aos="fade-up">
        <div class="container">
            <div class="cta-box text-center">
                <h2>{{ __('about_page.ready_to_work') }}</h2>
                <p>{{ __('about_page.ready_to_work_desc') }}</p>
                <div class="cta-buttons">
                    <a href="{{ route('home', ['locale' => $currentLocale]) }}#contact"
                        class="btn btn-primary-custom contact-btn">{{ __('common.get_started') }}</a>
                    <a href="{{ route('about.team', ['locale' => $currentLocale]) }}"
                        class="btn btn-secondary-outline">{{ __('about_page.meet_our_team') }}</a>
                </div>
            </div>
        </div>
    </section>

@endsection