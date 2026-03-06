<!-- ======= Testimonials Section ======= -->
<section id="testimonials" class="testimonials section">

    <!-- Section Title -->
    <div class="container section-title" data-aos="fade-up">
        <h2>{{ __('testimonials.section_title') }}</h2>
        <p>{{ __('testimonials.section_subtitle') }}</p>
    </div><!-- End Section Title -->

    <div class="container" data-aos="fade-up" data-aos-delay="100">

        <div class="row">

            <!-- Left Sidebar -->
            <div class="col-lg-4" data-aos="fade-right" data-aos-delay="150">
                <div class="testimonials-sidebar">
                    <div class="avatar-stack">
                        @foreach($testimonials->take(4) as $testi)
                            @php
                                $avatarUrl = ($testi->avatar_path && \Storage::disk('public')->exists(str_replace('storage/', '', $testi->avatar_path)))
                                    ? asset('storage/' . str_replace('storage/', '', $testi->avatar_path))
                                    : 'https://ui-avatars.com/api/?name=' . urlencode($testi->client_name) . '&background=123a32&color=fff&size=150&font-size=0.33&length=2';
                            @endphp
                            <img src="{{ $avatarUrl }}" alt="{{ $testi->client_name }}" class="avatar" loading="lazy">
                        @endforeach
                        <span class="avatar-count">+{{ (int) ($company->stat_projects ?? 500) }}</span>
                    </div>
                    <div class="sidebar-content">
                        <span class="satisfied-badge"><i class="bi bi-heart-fill"></i>
                            {{ __('testimonials.satisfied_clients') }}</span>
                        <h3>{{ __('testimonials.sidebar_title') }}</h3>
                        <p>{{ __('testimonials.sidebar_description') }}</p>
                        <a href="{{ route('home', ['locale' => $currentLocale]) }}#contact"
                            class="btn-view-all contact-btn">{{ __('testimonials.get_started') }} <i
                                class="bi bi-arrow-right"></i></a>
                    </div>
                </div>
            </div><!-- End Left Sidebar -->

            <!-- Right Testimonials Slider -->
            <div class="col-lg-8" data-aos="fade-left" data-aos-delay="200">
                <div class="testimonials-carousel swiper init-swiper">
                    <script type="application/json" class="swiper-config">
                        {
                            "loop": true,
                            "speed": 700,
                            "autoplay": {
                                "delay": 5000
                            },
                            "slidesPerView": 1,
                            "spaceBetween": 24,
                            "pagination": {
                                "el": ".swiper-pagination",
                                "type": "bullets",
                                "clickable": true
                            },
                            "breakpoints": {
                                "768": {
                                    "slidesPerView": 2
                                }
                            }
                        }
                    </script>

                    <div class="swiper-wrapper">

                        @forelse($testimonials as $testimonial)
                            @php
                                $translation = $testimonial->translate($currentLocale) ?? $testimonial->translate(config('app.fallback_locale'));
                                $image = ($testimonial->avatar_path && \Storage::disk('public')->exists(str_replace('storage/', '', $testimonial->avatar_path)))
                                    ? asset('storage/' . str_replace('storage/', '', $testimonial->avatar_path))
                                    : 'https://ui-avatars.com/api/?name=' . urlencode($testimonial->client_name) . '&background=123a32&color=fff&size=150&font-size=0.33&length=2';
                            @endphp
                            <div class="swiper-slide">
                                <div class="testimonial-card">
                                    <div class="card-top">
                                        <div class="stars">
                                            @for($i = 0; $i < $testimonial->rating; $i++)
                                                <i class="bi bi-star-fill"></i>
                                            @endfor
                                        </div>
                                        <span class="quote-mark"><i class="bi bi-quote"></i></span>
                                    </div>
                                    <p class="testimonial-text">
                                        {{ $translation?->content ?? __('testimonials.fallback_content') }}
                                    </p>
                                    <div class="author-info">
                                        <img src="{{ $image }}" alt="{{ $testimonial->client_name }}" class="author-img"
                                            loading="lazy">
                                        <div class="author-details">
                                            <h5>{{ $testimonial->client_name }}</h5>
                                            <span>{{ $translation?->client_position ?? __('testimonials.fallback_position') }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div><!-- End Testimonial Card -->
                        @empty
                            <div class="swiper-slide">
                                <p class="text-muted">{{ __('testimonials.empty_state') }}</p>
                            </div>
                        @endforelse

                    </div>

                    <div class="swiper-pagination"></div>

                </div>
            </div><!-- End Right Testimonials Slider -->

        </div>

    </div>

</section><!-- /Testimonials Section -->