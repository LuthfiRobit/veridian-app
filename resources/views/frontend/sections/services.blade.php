<!-- ======= Services Section ======= -->
<section id="services" class="services section">

    <!-- Section Title -->
    <div class="container section-title" data-aos="fade-up">
        <h2>{{ __('services.section_title') }}</h2>
        <p>{{ __('services.section_subtitle') }}</p>
    </div><!-- End Section Title -->

    <div class="container" data-aos="fade-up" data-aos-delay="100">

        <div class="row g-4">
            
            @forelse($services as $index => $service)
                @php 
                    $delay = ($index + 1) * 100;
                    $isFeatured = $index == 1; // Mark 2nd item as featured for design variety
                    $translation = $service->translate($currentLocale) ?? $service->translate(config('app.fallback_locale'));
                @endphp
                <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="{{ $delay }}">
                    <div class="service-card {{ $isFeatured ? 'featured' : '' }}">
                        @if($isFeatured)
                        <div class="featured-badge">
                            <i class="bi bi-star-fill"></i>
                            <span>{{ __('services.badge_popular') }}</span>
                        </div>
                        @endif
                        <div class="icon-wrapper">
                            <i class="{{ $service->icon_class ?? 'bi bi-file-earmark-text' }}"></i>
                        </div>
                        <h3>{{ $translation?->name ?? __('services.fallback_name') }}</h3>
                        <p>{{ Str::limit($translation?->short_desc ?? __('services.fallback_desc'), 100) }}</p>
                        <a href="{{ route('services.show', ['locale' => $currentLocale, 'slug' => $translation?->slug ?? '#']) }}" class="service-link">
                            <span>{{ __('services.learn_more') }}</span>
                            <i class="bi bi-arrow-right"></i>
                        </a>
                    </div>
                </div>
            @empty
                <!-- Fallback Static Cards -->
                <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="100">
                    <div class="service-card">
                        <div class="icon-wrapper"><i class="bi bi-file-earmark-text"></i></div>
                        <h3>{{ __('services.fallback_card_title_1') }}</h3>
                        <p>{{ __('services.fallback_card_desc_1') }}</p>
                        <a href="#" class="service-link"><span>Learn More</span> <i class="bi bi-arrow-right"></i></a>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="200">
                    <div class="service-card featured">
                        <div class="featured-badge"><i class="bi bi-star-fill"></i><span>{{ __('services.badge_popular') }}</span></div>
                        <div class="icon-wrapper"><i class="bi bi-mic-fill"></i></div>
                        <h3>{{ __('services.fallback_card_title_2') }}</h3>
                        <p>{{ __('services.fallback_card_desc_2') }}</p>
                        <a href="#" class="service-link"><span>Learn More</span> <i class="bi bi-arrow-right"></i></a>
                    </div>
                </div>
                <!-- Add 2 more if needed... -->
            @endforelse

        </div>

    </div>

</section><!-- /Services Section -->
