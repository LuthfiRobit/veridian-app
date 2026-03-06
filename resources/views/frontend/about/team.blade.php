@extends('layouts.landing')

@section('title', __('nav.our_team') . ' | ' . ($company->translate($currentLocale)?->name ?? __('meta.fallback_company_name')))
@section('meta_description', Str::limit($company->translate($currentLocale)?->about_description ?? __('meta.team_fallback_desc'), 160))

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
                        <span class="service-badge"><i class="bi bi-people"></i> {{ __('team.badge_label') }}</span>
                        <h1>{{ __('team.page_title') }}</h1>
                        <p class="mb-0">{{ __('team.page_subtitle') }}</p>
                    </div>
                </div>
            </div>
        </div>
        <nav class="breadcrumbs">
            <div class="container">
                <ol>
                    <li><a href="{{ route('home', ['locale' => $currentLocale]) }}">{{ __('common.home') }}</a></li>
                    <li><a href="{{ route('about', ['locale' => $currentLocale]) }}">{{ __('common.about') }}</a></li>
                    <li class="current">{{ __('nav.our_team') }}</li>
                </ol>
            </div>
        </nav>
    </div><!-- End Page Title -->

    <!-- Team Section -->
    <section class="team-section section">
        <div class="container">

            <!-- Section Intro -->
            <div class="section-intro text-center" data-aos="fade-up">
                <p class="lead">{{ __('team.section_intro') }}</p>
            </div>

            <!-- Team Grid -->
            <div class="team-grid" data-aos="fade-up" data-aos-delay="100">
                @forelse($teamMembers as $index => $member)
                    @php
                        $trans = $member->translate($currentLocale) ?? $member->translate(config('app.fallback_locale'));
                        $delay = 100 * (($index % 4) + 1);
                        $photoUrl = ($member->photo_path && \Storage::disk('public')->exists(str_replace('storage/', '', $member->photo_path)))
                            ? asset('storage/' . str_replace('storage/', '', $member->photo_path))
                            : 'https://ui-avatars.com/api/?name=' . urlencode($member->name) . '&background=123a32&color=fff&size=400&font-size=0.33&length=2';
                    @endphp
                    <div class="team-card" data-aos="zoom-in" data-aos-delay="{{ $delay }}">
                        <div class="team-image">
                            <img src="{{ $photoUrl }}" alt="{{ $member->name }}" class="img-fluid">
                            <div class="team-social">
                                @if($member->linkedin_url)
                                    <a href="{{ $member->linkedin_url }}" aria-label="LinkedIn" target="_blank"><i
                                            class="bi bi-linkedin"></i></a>
                                @endif
                                @if($member->email)
                                    <a href="mailto:{{ $member->email }}" aria-label="Email"><i class="bi bi-envelope"></i></a>
                                @endif
                                @if($member->twitter_url)
                                    <a href="{{ $member->twitter_url }}" aria-label="Twitter" target="_blank"><i
                                            class="bi bi-twitter-x"></i></a>
                                @endif
                                @if($member->github_url)
                                    <a href="{{ $member->github_url }}" aria-label="GitHub" target="_blank"><i
                                            class="bi bi-github"></i></a>
                                @endif
                            </div>
                        </div>
                        <div class="team-content">
                            <h3>{{ $member->name }}</h3>
                            <span class="team-role">{{ $trans?->position ?? __('team.fallback_position') }}</span>

                            @if($trans?->department)
                                <div class="team-expertise mb-2">
                                    <span class="expertise-tag">{{ $trans->department }}</span>
                                </div>
                            @endif
                            <p class="team-bio">{{ $trans?->bio ?? __('team.fallback_bio') }}</p>
                        </div>
                    </div>
                @empty
                    <div class="col-12 text-center text-muted">
                        <p>{{ __('team.empty_state') }}</p>
                    </div>
                @endforelse
            </div>

        </div>
    </section><!-- /Team Section -->

    <!-- CTA Section -->
    <section class="cta-section section" data-aos="fade-up">
        <div class="container">
            <div class="cta-box text-center">
                <h2>{{ __('team.cta_title') }}</h2>
                <p>{{ __('team.cta_description') }}</p>
                <a href="{{ route('home', ['locale' => $currentLocale]) }}#contact"
                    class="btn btn-primary-custom contact-btn">{{ __('team.cta_button') }}</a>
            </div>
        </div>
    </section>

@endsection