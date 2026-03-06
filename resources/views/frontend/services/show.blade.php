@extends('layouts.landing')

@php
    $locale = app()->getLocale();
    $fallback = config('app.fallback_locale');
    $serviceTrans = $service->translate($locale) ?? $service->translate($fallback);
@endphp

@section('title', $serviceTrans?->meta_title ?? ($serviceTrans?->name . ' | Veridian Solutions'))
@section('meta_description', Str::limit($serviceTrans?->meta_desc ?? $serviceTrans?->short_desc ?? __('service_detail.fallback_meta_desc'), 160))

@push('styles')
    <link href="{{ asset('company-landing/assets/css/service-details.css') }}" rel="stylesheet">
@endpush

@section('content')

    <!-- Page Title -->
    <div class="page-title page-title-animated" data-aos="fade">
        <div class="heading">
            <div class="container">
                <div class="row d-flex justify-content-center text-center">
                    <div class="col-lg-8">
                        <span class="service-badge"><i class="bi {{ $service->icon_class ?? 'bi-file-earmark-text' }}"></i>
                            {{ $serviceTrans?->name }}</span>
                        <h1>{{ $serviceTrans?->name }}</h1>
                        <p class="mb-0">{{ $serviceTrans?->short_desc }}</p>
                    </div>
                </div>
            </div>
        </div>
        <nav class="breadcrumbs">
            <div class="container">
                <ol>
                    <li><a href="{{ route('home', ['locale' => $locale]) }}">{{ __('common.home') }}</a></li>
                    <li><a href="{{ route('home', ['locale' => $locale]) }}#services">{{ __('common.services') }}</a></li>
                    <li class="current">{{ $serviceTrans?->name }}</li>
                </ol>
            </div>
        </nav>
    </div><!-- End Page Title -->

    <!-- Service Details Section -->
    <section id="service-details" class="service-details section">

        <div class="container">

            <div class="row gy-5">

                <div class="col-lg-4" data-aos="fade-up" data-aos-delay="100">

                    <div class="service-box">
                        <h4>{{ __('service_detail.all_services') }}</h4>
                        <div class="services-list">
                            @foreach($allServices as $sidebarService)
                                @php
                                    $sTrans = $sidebarService->translate($locale) ?? $sidebarService->translate($fallback);
                                    $isActive = $sidebarService->id_service == $service->id_service;
                                @endphp
                                <a href="{{ route('services.show', ['locale' => $locale, 'slug' => $sTrans?->slug]) }}"
                                    class="{{ $isActive ? 'active' : '' }}">
                                    <i class="bi bi-arrow-right-circle"></i><span>{{ $sTrans?->name }}</span>
                                </a>
                            @endforeach
                        </div>
                    </div><!-- End Services List -->

                    <div class="service-box">
                        <h4>{{ __('service_detail.quick_contact') }}</h4>
                        <div class="download-catalog">
                            <a href="{{ route('home', ['locale' => $locale]) }}#contact" class="contact-btn"><i
                                    class="bi bi-chat-dots"></i><span>{{ __('service_detail.start_project') }}</span></a>
                        </div>
                        <div class="help-box d-flex flex-column justify-content-center align-items-center">
                            <i class="bi bi-headset"></i>
                            <h4>{{ __('service_detail.need_assistance') }}</h4>
                            <p class="d-flex align-items-center mt-2 mb-0"><i class="bi bi-telephone me-2"></i>
                                <span>{{ $company->whatsapp ?? '+62 812-3456-7890' }}</span>
                            </p>
                            <p class="d-flex align-items-center mt-1 mb-0"><i class="bi bi-envelope me-2"></i>
                                <span>{{ $company->email ?? 'contact@veridian-solutions.com' }}</span>
                            </p>
                        </div>
                    </div><!-- End Quick Contact -->

                </div>

                <div class="col-lg-8 ps-lg-5" data-aos="fade-up" data-aos-delay="200">

                    @php
                        $imagePath = $service->image_main;
                        if ($imagePath && \Str::startsWith($imagePath, 'storage/')) {
                            $imagePath = \Str::replaceFirst('storage/', '', $imagePath);
                        }
                    @endphp

                    @if($imagePath && \Storage::disk('public')->exists($imagePath))
                        <img src="{{ asset('storage/' . $imagePath) }}" alt="{{ $serviceTrans?->name }}"
                            class="img-fluid rounded" style="width:100%; height:300px; object-fit:cover;">
                    @else
                        <img src="https://ui-avatars.com/api/?name={{ urlencode($serviceTrans?->name) }}&background=123a32&color=fff&size=600&font-size=0.15&length=2"
                            alt="{{ $serviceTrans?->name }}" class="img-fluid rounded"
                            style="width:100%; height:300px; object-fit:cover;">
                    @endif

                    <!-- Content (CKEditor Output) -->
                    <div class="service-content-main mb-5">
                        {!! $serviceTrans?->content !!}
                    </div>

                    @if($service->processes->count() > 0)
                        <h4>{{ __('service_detail.our_process') }}</h4>
                        <div class="process-steps mb-5">
                            @foreach($service->processes as $index => $process)
                                @php
                                    $pTrans = $process->translate($locale) ?? $process->translate($fallback);
                                @endphp
                                <div class="step-item">
                                    <div class="step-number">{{ str_pad($process->step_number, 2, '0', STR_PAD_LEFT) }}</div>
                                    <div class="step-content">
                                        <h5>{{ $pTrans?->title }}</h5>
                                        <p>{{ $pTrans?->description }}</p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif

                    @if($service->benefits->count() > 0)
                        <h4>{{ __('service_detail.key_benefits') }}</h4>
                        <div class="features-list mb-5">
                            @foreach($service->benefits as $benefit)
                                @php
                                    $bTrans = $benefit->translate($locale) ?? $benefit->translate($fallback);
                                @endphp
                                <div class="feature-item">
                                    <i class="bi {{ $benefit->icon_class ?? 'bi-check-circle-fill' }}"></i>
                                    <div>
                                        <h5>{{ $bTrans?->title }}</h5>
                                        <p>{{ $bTrans?->description }}</p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif

                    @if($service->pricings->count() > 0)
                        <h4>{{ __('service_detail.pricing_packages') }}</h4>
                        <div class="pricing-tiers mb-5">
                            @foreach($service->pricings as $pricing)
                                @php
                                    $pricingTrans = $pricing->translate($locale) ?? $pricing->translate($fallback);
                                    // Handle both string and array formats reliably
                                    $rawFeatures = $pricingTrans?->features_list;
                                    if (is_array($rawFeatures)) {
                                        $features = $rawFeatures;
                                    } else {
                                        $features = array_filter(array_map('trim', explode("\n", (string) ($rawFeatures ?? ''))));
                                    }
                                @endphp
                                <div class="pricing-card {{ $pricing->is_featured ? 'featured' : '' }}">
                                    @if($pricing->is_featured)
                                        <div class="badge">{{ __('service_detail.most_popular') }}</div>
                                    @endif
                                    <h5>{{ $pricingTrans?->name }}</h5>

                                    @if($pricingTrans?->price_label)
                                        <div class="price">
                                            {{ $pricingTrans->price_label }}
                                            @if($pricingTrans->unit_label)
                                                <span class="price-unit">{{ $pricingTrans->unit_label }}</span>
                                            @endif
                                        </div>
                                    @endif

                                    <ul>
                                        @foreach($features as $feature)
                                            <li><i class="bi bi-check"></i> {{ $feature }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endforeach
                        </div>
                    @endif

                    <!-- CTA Section -->
                    <div class="cta-box">
                        <h4>{{ __('service_detail.cta_title') }}</h4>
                        <p>{{ __('service_detail.cta_description') }}</p>
                        <div class="cta-buttons">
                            <a href="{{ route('home', ['locale' => $locale]) }}#contact"
                                class="btn-cta-primary contact-btn">{{ __('service_detail.request_quote') }} <i
                                    class="bi bi-arrow-right"></i></a>
                            <a href="{{ route('home', ['locale' => $locale]) }}#portfolio"
                                class="btn-cta-secondary">{{ __('service_detail.view_case_studies') }}</a>
                        </div>
                    </div>

                </div>

            </div>

        </div>

    </section><!-- /Service Details Section -->

@endsection