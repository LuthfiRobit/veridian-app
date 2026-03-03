<!-- ======= Testimonials Section ======= -->
<section id="testimonials" class="testimonials section">

    <!-- Section Title -->
    <div class="container section-title" data-aos="fade-up">
        <h2>Testimonials</h2>
        <p>What our clients say about working with Veridian Solutions</p>
    </div><!-- End Section Title -->

    <div class="container" data-aos="fade-up" data-aos-delay="100">

        <div class="row">

            <!-- Left Sidebar -->
            <div class="col-lg-4" data-aos="fade-right" data-aos-delay="150">
                <div class="testimonials-sidebar">
                    <div class="avatar-stack">
                        @foreach($testimonials->take(4) as $testi)
                            @php
                                $avatarUrl = $testi->avatar_path ? asset('storage/' . $testi->avatar_path) : asset('company-landing/assets/img/person/person-m-' . ($loop->iteration) . '.webp');
                            @endphp
                            <img src="{{ $avatarUrl }}" alt="{{ $testi->client_name }}" class="avatar" loading="lazy">
                        @endforeach
                        <span class="avatar-count">+{{ (int) ($company->stat_projects ?? 500) }}</span>
                    </div>
                    <div class="sidebar-content">
                        <span class="satisfied-badge"><i class="bi bi-heart-fill"></i> Satisfied Clients</span>
                        <h3>Discover What Our Clients Say About Us</h3>
                        <p>Professional translation services trusted by businesses worldwide for accuracy and cultural
                            excellence.</p>
                        <a href="{{ route('home', ['locale' => $currentLocale]) }}#contact"
                            class="btn-view-all contact-btn">Get Started <i class="bi bi-arrow-right"></i></a>
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
                                $image = $testimonial->avatar_path ? asset('storage/' . $testimonial->avatar_path) : asset('company-landing/assets/img/person/person-m-1.webp');
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
                                    <p class="testimonial-text">{{ $translation?->content ?? 'Excellent service!' }}</p>
                                    <div class="author-info">
                                        <img src="{{ $image }}" alt="{{ $testimonial->client_name }}" class="author-img"
                                            loading="lazy">
                                        <div class="author-details">
                                            <h5>{{ $testimonial->client_name }}</h5>
                                            <span>{{ $translation?->client_position ?? 'Client' }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div><!-- End Testimonial Card -->
                        @empty
                            <div class="swiper-slide">
                                <p class="text-muted">No testimonials available yet.</p>
                            </div>
                        @endforelse

                    </div>

                    <div class="swiper-pagination"></div>

                </div>
            </div><!-- End Right Testimonials Slider -->

        </div>

    </div>

</section><!-- /Testimonials Section -->