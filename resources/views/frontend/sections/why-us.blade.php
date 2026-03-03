<!-- ======= Why Us Section ======= -->
<section id="why-us" class="why-us section light-background">

    <!-- Section Title -->
    <div class="container section-title" data-aos="fade-up">
        <h2>Why Choose Veridian Solutions</h2>
        <p>Industry-leading expertise and commitment to excellence in every project</p>
    </div><!-- End Section Title -->

    <div class="container" data-aos="fade-up" data-aos-delay="100">

        <div class="row g-5">
            <div class="col-lg-5" data-aos="fade-right" data-aos-delay="200">
                <div class="sidebar-content">
                    <div class="badge-wrapper">
                        <span class="section-badge"><i class="bi bi-stars"></i> Our Difference</span>
                    </div>
                    <h2>Transform Your Global Communication Strategy</h2>
                    <p class="description">We combine linguistic expertise with cultural intelligence to deliver
                        translations that truly resonate. Our certified native linguists and ISO-certified processes
                        ensure accuracy and quality in every project.</p>

                    <div class="stat-cards">
                        <div class="stat-card" data-aos="zoom-in" data-aos-delay="300">
                            <div class="stat-value">
                                <span class="purecounter" data-purecounter-start="0"
                                    data-purecounter-end="{{ (int) ($company->stat_projects ?? 500) }}"
                                    data-purecounter-duration="2">{{ (int) ($company->stat_projects ?? 500) }}</span>+
                            </div>
                            <div class="stat-text">Projects Completed</div>
                        </div>
                        <div class="stat-card" data-aos="zoom-in" data-aos-delay="350">
                            <div class="stat-value">
                                <span class="purecounter" data-purecounter-start="0"
                                    data-purecounter-end="{{ (int) ($company->stat_satisfaction ?? 98) }}"
                                    data-purecounter-duration="2">{{ (int) ($company->stat_satisfaction ?? 98) }}</span>%
                            </div>
                            <div class="stat-text">Client Satisfaction</div>
                        </div>
                        <div class="stat-card" data-aos="zoom-in" data-aos-delay="400">
                            <div class="stat-value">
                                <span class="purecounter" data-purecounter-start="0"
                                    data-purecounter-end="{{ (int) ($company->stat_languages ?? 50) }}"
                                    data-purecounter-duration="2">{{ (int) ($company->stat_languages ?? 50) }}</span>+
                            </div>
                            <div class="stat-text">Languages Supported</div>
                        </div>
                    </div>

                    <div class="action-buttons">
                        <a href="{{ route('home', ['locale' => $currentLocale]) }}#contact"
                            class="btn-main contact-btn">Get Started Today</a>
                        <a href="{{ route('home', ['locale' => $currentLocale]) }}#portfolio"
                            class="btn-outline">Explore Portfolio</a>
                    </div>
                </div>
            </div>

            <div class="col-lg-7" data-aos="fade-left" data-aos-delay="200">
                <div class="features-grid">
                    @forelse($coreValues as $index => $value)
                        @php
                            $translation = $value->translate($currentLocale) ?? $value->translate(config('app.fallback_locale'));
                            $isTopRated = $index === 0; // Highlight the first core value as an example
                        @endphp
                        <div class="feature-box {{ $isTopRated ? 'highlight' : '' }}" data-aos="fade-up" data-aos-delay="{{ 250 + ($index * 50) }}">
                            @if($isTopRated)
                                <div class="feature-ribbon">Top Rated</div>
                            @endif
                            <div class="feature-icon">
                                <i class="{{ $value->icon_class ?? 'bi bi-patch-check-fill' }}"></i>
                            </div>
                            <div class="feature-content">
                                <h4>{{ $translation?->title ?? 'Value Title' }}</h4>
                                <p>{{ $translation?->description ?? 'Value description here.' }}</p>
                                <a href="{{ route('home', ['locale' => $currentLocale]) }}#contact"
                                    class="feature-link contact-btn">Learn More <i class="bi bi-chevron-right"></i></a>
                            </div>
                        </div>
                    @empty
                        <div class="feature-box highlight" data-aos="fade-up" data-aos-delay="250">
                            <div class="feature-ribbon">Top Rated</div>
                            <div class="feature-icon">
                                <i class="bi bi-people-fill"></i>
                            </div>
                            <div class="feature-content">
                                <h4>Native Linguists</h4>
                                <p>Our team consists of certified native speakers ensuring cultural authenticity and
                                    accuracy in every translation project.</p>
                                <a href="{{ route('home', ['locale' => $currentLocale]) }}#contact"
                                    class="feature-link contact-btn">Learn More <i class="bi bi-chevron-right"></i></a>
                            </div>
                        </div>
                    @endforelse
                </div>

                <div class="process-timeline" data-aos="fade-up" data-aos-delay="400">
                    <h5 class="timeline-title"><i class="bi bi-diagram-3-fill"></i> Our Proven Process</h5>
                    <div class="timeline-steps">
                        <div class="timeline-step">
                            <div class="step-marker">1</div>
                            <div class="step-info">
                                <strong>Analysis</strong>
                                <span>Understanding your needs</span>
                            </div>
                        </div>
                        <div class="timeline-connector"></div>
                        <div class="timeline-step">
                            <div class="step-marker">2</div>
                            <div class="step-info">
                                <strong>Translation</strong>
                                <span>Expert linguists at work</span>
                            </div>
                        </div>
                        <div class="timeline-connector"></div>
                        <div class="timeline-step">
                            <div class="step-marker">3</div>
                            <div class="step-info">
                                <strong>Quality Check</strong>
                                <span>Rigorous QA process</span>
                            </div>
                        </div>
                        <div class="timeline-connector"></div>
                        <div class="timeline-step">
                            <div class="step-marker">4</div>
                            <div class="step-info">
                                <strong>Delivery</strong>
                                <span>Final product</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

    </div>

</section><!-- /Why Us Section -->