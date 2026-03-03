<!-- ======= Services Section ======= -->
<section id="services" class="services section">

    <!-- Section Title -->
    <div class="container section-title" data-aos="fade-up">
        <h2>Our Services</h2>
        <p>Comprehensive language solutions tailored to your global communication needs</p>
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
                            <span>Popular</span>
                        </div>
                        @endif
                        <div class="icon-wrapper">
                            <i class="{{ $service->icon_class ?? 'bi bi-file-earmark-text' }}"></i>
                        </div>
                        <h3>{{ $translation?->name ?? 'Service Name' }}</h3>
                        <p>{{ Str::limit($translation?->short_desc ?? 'Service description', 100) }}</p>
                        <a href="{{ route('services.show', ['locale' => $currentLocale, 'slug' => $translation?->slug ?? '#']) }}" class="service-link">
                            <span>Learn More</span>
                            <i class="bi bi-arrow-right"></i>
                        </a>
                    </div>
                </div>
            @empty
                <!-- Fallback Static Cards -->
                <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="100">
                    <div class="service-card">
                        <div class="icon-wrapper"><i class="bi bi-file-earmark-text"></i></div>
                        <h3>Document Translation</h3>
                        <p>Accurate translation of legal, technical, and business documents by certified linguists.</p>
                        <a href="#" class="service-link"><span>Learn More</span> <i class="bi bi-arrow-right"></i></a>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="200">
                    <div class="service-card featured">
                        <div class="featured-badge"><i class="bi bi-star-fill"></i><span>Popular</span></div>
                        <div class="icon-wrapper"><i class="bi bi-mic-fill"></i></div>
                        <h3>Professional Dubbing</h3>
                        <p>High-quality voice-over and dubbing services for videos, films, and multimedia content.</p>
                        <a href="#" class="service-link"><span>Learn More</span> <i class="bi bi-arrow-right"></i></a>
                    </div>
                </div>
                <!-- Add 2 more if needed... -->
            @endforelse

        </div>

    </div>

</section><!-- /Services Section -->
