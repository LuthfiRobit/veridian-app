@extends('layouts.landing')

@php
    $locale = app()->getLocale();
    $fallback = config('app.fallback_locale');
    $projectTrans = $project->translate($locale) ?? $project->translate($fallback);
    $categoryTrans = $project->category?->translate($locale) ?? $project->category?->translate($fallback);
@endphp

@section('title', $projectTrans?->meta_title ?? ($projectTrans?->title . ' | ' . ($company->company_name ?? __('meta.fallback_company_name'))))
@section('meta_description', Str::limit($projectTrans?->meta_desc ?? $projectTrans?->description ?? __('portfolio_detail.fallback_meta_desc'), 160))

@push('styles')
    <link href="{{ asset('company-landing/assets/css/portfolio-details.css') }}" rel="stylesheet">
@endpush

@section('body_class', 'portfolio-details-page')

@section('content')

    <!-- Page Title -->
    <div class="page-title page-title-animated">
        <div class="heading">
            <div class="container">
                <div class="row d-flex justify-content-center text-center">
                    <div class="col-lg-8">
                        <h1>{{ $projectTrans?->title }}</h1>
                        <p class="mb-0">{{ $projectTrans?->subtitle }}</p>
                    </div>
                </div>
            </div>
        </div>
        <nav class="breadcrumbs">
            <div class="container">
                <ol>
                    <li><a href="{{ route('home', ['locale' => $locale]) }}">{{ __('common.home') }}</a></li>
                    <li><a href="{{ route('home', ['locale' => $locale]) }}#portfolio">{{ __('common.portfolio') }}</a></li>
                    <li class="current">{{ $projectTrans?->title }}</li>
                </ol>
            </div>
        </nav>
    </div><!-- End Page Title -->

    <!-- Portfolio Details Section -->
    <section id="portfolio-details" class="portfolio-details section">

        <div class="container" data-aos="fade-up" data-aos-delay="100">

            <div class="row gy-5">
                <div class="col-lg-7" data-aos="fade-right" data-aos-delay="100">
                    <div class="hero-image-wrapper">
                        @if($project->images->count() > 0)
                            <div class="portfolio-slider swiper init-swiper">
                                <script type="application/json" class="swiper-config">
                                        {        
                                            "loop":         {{ $project->images->count() > 1 ? 'true' : 'false' }},
                                            "speed":         700,
                                            "autopla        y": {
                                                "delay":         4500
                                            },        
                                            "effect"        : "slide",
                                            "slidesP        erView": 1,
                                            "navigat        ion": {
                                                "nextEl"        : ".swiper-button-next",
                                                "prevEl"        : ".swiper-button-prev"
                                            }        
                                        }        
                                        </script>
                                <div class="swiper-wrapper">
                                    @foreach($project->images as $image)
                                        @php
                                            $imgTrans = $image->translate($locale) ?? $image->translate($fallback);
                                            $imgPath = str_replace('storage/', '', $image->image_path);
                                        @endphp
                                        <div class="swiper-slide">
                                            @if($imgPath && \Storage::disk('public')->exists($imgPath))
                                                <img src="{{ asset('storage/' . $imgPath) }}"
                                                    alt="{{ $imgTrans?->caption ?? $projectTrans?->title }}" class="img-fluid">
                                            @else
                                                <img src="https://ui-avatars.com/api/?name={{ urlencode($projectTrans?->title) }}&background=123a32&color=fff&size=800&font-size=0.1&length=2"
                                                    alt="{{ __('portfolio_detail.fallback_image_alt') }}" class="img-fluid rounded"
                                                    style="width:100%; height:400px; object-fit:cover;">
                                            @endif
                                        </div>
                                    @endforeach
                                </div>
                                <div class="swiper-button-prev"></div>
                                <div class="swiper-button-next"></div>
                            </div>
                        @else
                            {{-- Fallback Main Image if no slider items --}}
                            @php $thumbPath = str_replace('storage/', '', $project->image_thumbnail ?? ''); @endphp
                            @if($thumbPath && \Storage::disk('public')->exists($thumbPath))
                                <img src="{{ asset('storage/' . $thumbPath) }}" alt="{{ $projectTrans?->title }}"
                                    class="img-fluid rounded" style="width:100%; height:400px; object-fit:cover;">
                            @else
                                <img src="https://ui-avatars.com/api/?name={{ urlencode($projectTrans?->title) }}&background=123a32&color=fff&size=800&font-size=0.1&length=2"
                                    alt="{{ $projectTrans?->title }}" class="img-fluid rounded"
                                    style="width:100%; height:400px; object-fit:cover;">
                            @endif
                        @endif
                        <div class="floating-badge">
                            <i class="bi bi-patch-check"></i>
                            <span>{{ $categoryTrans?->name ?? __('portfolio.fallback_category') }}</span>
                        </div>
                    </div>
                </div><!-- End Image Column -->

                <div class="col-lg-5" data-aos="fade-left" data-aos-delay="200">
                    <div class="project-info-card">
                        <div class="project-category">
                            <span class="dot"></span>
                            <span>{{ $categoryTrans?->name ?? __('portfolio.fallback_category') }}</span>
                        </div>
                        <h1 class="project-title">{{ $projectTrans?->title }}</h1>
                        <p class="project-excerpt">{{ $projectTrans?->description }}</p>

                        <div class="meta-grid">
                            @if($project->client_name)
                                <div class="meta-item">
                                    <span class="meta-label">{{ __('portfolio_detail.client') }}</span>
                                    <span class="meta-value">{{ $project->client_name }}</span>
                                </div>
                            @endif
                            @if($project->completion_date)
                                <div class="meta-item">
                                    <span class="meta-label">{{ __('portfolio_detail.date') }}</span>
                                    <span
                                        class="meta-value">{{ \Carbon\Carbon::parse($project->completion_date)->format('F Y') }}</span>
                                </div>
                            @endif
                            @if($project->project_url)
                                <div class="meta-item">
                                    <span class="meta-label">{{ __('portfolio_detail.url') }}</span>
                                    <span class="meta-value"><a href="{{ $project->project_url }}" target="_blank"
                                            rel="noopener noreferrer">{{ __('portfolio_detail.visit_link') }} <i
                                                class="bi bi-box-arrow-up-right ps-1" style="font-size:0.8rem;"></i></a></span>
                                </div>
                            @endif
                        </div>

                        @php
                            $techStackRaw = $projectTrans?->tech_stack;
                            if (is_array($techStackRaw)) {
                                $techStacks = $techStackRaw;
                            } else {
                                $techStacks = array_filter(array_map('trim', explode("\n", (string) ($techStackRaw ?? ''))));
                            }
                        @endphp

                        <div class="tech-stack">
                            <span class="tech-label">{{ __('portfolio_detail.tech_specs') }}</span>
                            <div class="tech-icons">
                                @if(count($techStacks) > 0)
                                    @foreach($techStacks as $tech)
                                        <span class="tech-badge">{{ $tech }}</span>
                                    @endforeach
                                @else
                                    <span class="text-muted small">{{ __('common.no_data') }}</span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div><!-- End Info Column -->
            </div>

            <div class="stats-ribbon" data-aos="fade-up" data-aos-delay="300">
                @if($project->stats->isEmpty())
                    <div class="stat-box text-center w-100" style="border-right: none;">
                        <span class="stat-text">{{ __('common.no_stats_data') }}</span>
                    </div>
                @else
                    @foreach($project->stats as $stat)
                        @php
                            $statTrans = $stat->translate($locale) ?? $stat->translate($fallback);
                        @endphp
                        <div class="stat-box">
                            <span class="stat-number">{{ $stat->value }}</span>
                            <span class="stat-text">{{ $statTrans?->label }}</span>
                        </div>
                    @endforeach
                @endif
            </div>

            <div class="content-sections">
                <div class="row gy-5">
                    <div class="col-lg-8" data-aos="fade-up" data-aos-delay="100">
                        <div class="content-block">
                            <div class="block-header">
                                <span class="block-icon"><i class="bi bi-file-text"></i></span>
                                <h3>{{ __('portfolio_detail.project_overview') }}</h3>
                            </div>
                            {!! $projectTrans?->content !!}
                        </div>

                        <div class="challenge-solution" data-aos="fade-up" data-aos-delay="200">
                            <div class="row g-4">
                                <div class="col-md-6">
                                    <div class="cs-card challenge">
                                        <div class="cs-icon">
                                            <i class="bi bi-puzzle"></i>
                                        </div>
                                        <h4>{{ __('portfolio_detail.the_challenge') }}</h4>
                                        @if($projectTrans?->challenge)
                                            <div>{!! $projectTrans->challenge !!}</div>
                                        @else
                                            <p class="text-muted mb-0">{{ __('common.no_data') }}</p>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="cs-card solution">
                                        <div class="cs-icon">
                                            <i class="bi bi-check2-circle"></i>
                                        </div>
                                        <h4>{{ __('portfolio_detail.our_solution') }}</h4>
                                        @if($projectTrans?->solution)
                                            <div>{!! $projectTrans->solution !!}</div>
                                        @else
                                            <p class="text-muted mb-0">{{ __('common.no_data') }}</p>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="cs-card result">
                                        <div class="cs-icon">
                                            <i class="bi bi-trophy"></i>
                                        </div>
                                        <h4>{{ __('portfolio_detail.the_result') }}</h4>
                                        @if($projectTrans?->result)
                                            <div>{!! $projectTrans->result !!}</div>
                                        @else
                                            <p class="text-muted mb-0">{{ __('common.no_data') }}</p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div><!-- End Main Content Column -->

                    <div class="col-lg-4" data-aos="fade-up" data-aos-delay="200">
                        <div class="features-sidebar">
                            <h3 class="sidebar-title">{{ __('portfolio_detail.key_features') }}</h3>
                            <div class="feature-list">
                                @if($project->features->isEmpty())
                                    <div class="feature-item">
                                        <div class="feature-content w-100 text-center">
                                            <p class="text-muted mb-0">{{ __('common.no_data') }}</p>
                                        </div>
                                    </div>
                                @else
                                    @foreach($project->features as $feature)
                                        @php
                                            $fTrans = $feature->translate($locale) ?? $feature->translate($fallback);
                                        @endphp
                                        <div class="feature-item">
                                            <div class="feature-icon">
                                                <i class="bi {{ $feature->icon_class ?? 'bi-check-circle' }}"></i>
                                            </div>
                                            <div class="feature-content">
                                                <h5>{{ $fTrans?->title }}</h5>
                                                <p>{{ $fTrans?->description }}</p>
                                            </div>
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                        </div>
                    </div><!-- End Sidebar Column -->
                </div>
            </div>

            <div class="gallery-section" data-aos="fade-up" data-aos-delay="100">
                <div class="gallery-header">
                    <span class="section-label"><i class="bi bi-images"></i>
                        {{ __('portfolio_detail.project_gallery') }}</span>
                    <h3>{{ __('portfolio_detail.gallery_title') }}</h3>
                </div>
                <div class="row g-4">
                    @if($project->images->isEmpty())
                        <div class="col-12 text-center text-muted">{{ __('common.no_data') }}</div>
                    @else
                        @foreach($project->images as $index => $image)
                            @php
                                $imgTrans = $image->translate($locale) ?? $image->translate($fallback);
                                $galPath = str_replace('storage/', '', $image->image_path);
                                $galUrl = ($galPath && \Storage::disk('public')->exists($galPath))
                                    ? asset('storage/' . $galPath)
                                    : 'https://ui-avatars.com/api/?name=' . urlencode($projectTrans?->title ?? 'Gallery') . '&background=123a32&color=fff&size=800&font-size=0.1&length=2';
                            @endphp
                            @if($index == 0)
                                <div class="col-md-6">
                                    <div class="gallery-card large">
                                        <a href="{{ $galUrl }}" class="glightbox">
                                            <img src="{{ $galUrl }}"
                                                alt="{{ $imgTrans?->caption ?? __('portfolio_detail.gallery_image_alt') }}"
                                                class="img-fluid" loading="lazy">
                                            <div class="gallery-overlay">
                                                <i class="bi bi-zoom-in"></i>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                            @endif

                            @if($index == 1)
                                <div class="col-md-6">
                                    <div class="row g-4">
                            @endif

                                    @if($index >= 1)
                                        <div class="col-{{ $index == 1 ? '12' : '6' }}">
                                            <div class="gallery-card">
                                                <a href="{{ $galUrl }}" class="glightbox">
                                                    <img src="{{ $galUrl }}"
                                                        alt="{{ $imgTrans?->caption ?? __('portfolio_detail.gallery_image_alt') }}"
                                                        class="img-fluid" loading="lazy">
                                                    <div class="gallery-overlay">
                                                        <i class="bi bi-zoom-in"></i>
                                                    </div>
                                                </a>
                                            </div>
                                        </div>
                                    @endif

                                    @if($loop->last && $index >= 1)
                                            </div>
                                        </div>
                                    @endif
                        @endforeach
                    @endif
                </div>
            </div>

            <div class="navigation-bar" data-aos="fade-up" data-aos-delay="100">
                @if($previousProject)
                    @php
                        $prevTrans = $previousProject->translate($locale) ?? $previousProject->translate($fallback);
                    @endphp
                    <a href="{{ route('portfolio.show', ['locale' => $locale, 'slug' => $prevTrans?->slug]) }}"
                        class="nav-link prev">
                        <span class="nav-icon"><i class="bi bi-arrow-left-short"></i></span>
                        <span class="nav-text">{{ __('portfolio_detail.previous_project') }}</span>
                    </a>
                @else
                    <div class="nav-link prev" style="visibility:hidden;"></div>
                @endif

                <a href="{{ route('home', ['locale' => $locale]) }}#portfolio" class="nav-link center">
                    <span class="nav-icon"><i class="bi bi-grid-3x3-gap"></i></span>
                    <span class="nav-text">{{ __('portfolio_detail.view_all') }}</span>
                </a>

                @if($nextProject)
                    @php
                        $nextTrans = $nextProject->translate($locale) ?? $nextProject->translate($fallback);
                    @endphp
                    <a href="{{ route('portfolio.show', ['locale' => $locale, 'slug' => $nextTrans?->slug]) }}"
                        class="nav-link next">
                        <span class="nav-text">{{ __('portfolio_detail.next_project') }}</span>
                        <span class="nav-icon"><i class="bi bi-arrow-right-short"></i></span>
                    </a>
                @else
                    <div class="nav-link next" style="visibility:hidden;"></div>
                @endif
            </div>

        </div>

    </section><!-- /Portfolio Details Section -->

@endsection