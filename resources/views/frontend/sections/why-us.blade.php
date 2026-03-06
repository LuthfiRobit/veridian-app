<!-- ======= Why Us Section ======= -->
<section id="why-us" class="why-us section light-background">

    <!-- Section Title -->
    <div class="container section-title" data-aos="fade-up">
        <h2>{{ __('why_us.section_title') }}</h2>
        <p>{{ __('why_us.section_subtitle') }}</p>
    </div><!-- End Section Title -->

    <div class="container" data-aos="fade-up" data-aos-delay="100">

        <div class="row g-5">
            <div class="col-lg-5" data-aos="fade-right" data-aos-delay="200">
                <div class="sidebar-content">
                    <div class="badge-wrapper">
                        <span class="section-badge"><i class="bi bi-stars"></i> {{ __('why_us.badge') }}</span>
                    </div>
                    <h2>{{ __('why_us.sidebar_title') }}</h2>
                    <p class="description">{{ __('why_us.sidebar_description') }}</p>

                    <div class="stat-cards">
                        <div class="stat-card" data-aos="zoom-in" data-aos-delay="300">
                            <div class="stat-value">
                                <span class="purecounter" data-purecounter-start="0"
                                    data-purecounter-end="{{ (int) ($company->stat_projects ?? 500) }}"
                                    data-purecounter-duration="2">{{ (int) ($company->stat_projects ?? 500) }}</span>+
                            </div>
                            <div class="stat-text">{{ __('why_us.projects_completed') }}</div>
                        </div>
                        <div class="stat-card" data-aos="zoom-in" data-aos-delay="350">
                            <div class="stat-value">
                                <span class="purecounter" data-purecounter-start="0"
                                    data-purecounter-end="{{ (int) ($company->stat_satisfaction ?? 98) }}"
                                    data-purecounter-duration="2">{{ (int) ($company->stat_satisfaction ?? 98) }}</span>%
                            </div>
                            <div class="stat-text">{{ __('why_us.client_satisfaction') }}</div>
                        </div>
                        <div class="stat-card" data-aos="zoom-in" data-aos-delay="400">
                            <div class="stat-value">
                                <span class="purecounter" data-purecounter-start="0"
                                    data-purecounter-end="{{ (int) ($company->stat_languages ?? 50) }}"
                                    data-purecounter-duration="2">{{ (int) ($company->stat_languages ?? 50) }}</span>+
                            </div>
                            <div class="stat-text">{{ __('why_us.languages_supported') }}</div>
                        </div>
                    </div>

                    <div class="action-buttons">
                        <a href="{{ route('home', ['locale' => $currentLocale]) }}#contact"
                            class="btn-main contact-btn">{{ __('why_us.get_started_today') }}</a>
                        <a href="{{ route('home', ['locale' => $currentLocale]) }}#portfolio"
                            class="btn-outline">{{ __('why_us.explore_portfolio') }}</a>
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
                        <div class="feature-box {{ $isTopRated ? 'highlight' : '' }}" data-aos="fade-up"
                            data-aos-delay="{{ 250 + ($index * 50) }}">
                            @if($isTopRated)
                                <div class="feature-ribbon">{{ __('why_us.top_rated') }}</div>
                            @endif
                            <div class="feature-icon">
                                <i class="{{ $value->icon_class ?? 'bi bi-patch-check-fill' }}"></i>
                            </div>
                            <div class="feature-content">
                                <h4>{{ $translation?->title ?? __('why_us.fallback_title') }}</h4>
                                <p>{{ $translation?->description ?? __('why_us.fallback_desc') }}</p>
                                <a href="{{ route('home', ['locale' => $currentLocale]) }}#contact"
                                    class="feature-link contact-btn">{{ __('common.learn_more') }} <i
                                        class="bi bi-chevron-right"></i></a>
                            </div>
                        </div>
                    @empty
                        <div class="feature-box highlight" data-aos="fade-up" data-aos-delay="250">
                            <div class="feature-ribbon">Top Rated</div>
                            <div class="feature-icon">
                                <i class="bi bi-people-fill"></i>
                            </div>
                            <div class="feature-content">
                                <h4>{{ __('why_us.fallback_native_linguists') }}</h4>
                                <p>{{ __('why_us.fallback_native_linguists_desc') }}</p>
                                <a href="{{ route('home', ['locale' => $currentLocale]) }}#contact"
                                    class="feature-link contact-btn">{{ __('common.learn_more') }} <i
                                        class="bi bi-chevron-right"></i></a>
                            </div>
                        </div>
                    @endforelse
                </div>

                <div class="process-timeline" data-aos="fade-up" data-aos-delay="400">
                    <h5 class="timeline-title"><i class="bi bi-diagram-3-fill"></i>
                        {{ __('why_us.our_proven_process') }}</h5>
                    <div class="timeline-steps">
                        <div class="timeline-step">
                            <div class="step-marker">1</div>
                            <div class="step-info">
                                <strong>{{ __('why_us.step_analysis') }}</strong>
                                <span>{{ __('why_us.step_analysis_desc') }}</span>
                            </div>
                        </div>
                        <div class="timeline-connector"></div>
                        <div class="timeline-step">
                            <div class="step-marker">2</div>
                            <div class="step-info">
                                <strong>{{ __('why_us.step_translation') }}</strong>
                                <span>{{ __('why_us.step_translation_desc') }}</span>
                            </div>
                        </div>
                        <div class="timeline-connector"></div>
                        <div class="timeline-step">
                            <div class="step-marker">3</div>
                            <div class="step-info">
                                <strong>{{ __('why_us.step_quality') }}</strong>
                                <span>{{ __('why_us.step_quality_desc') }}</span>
                            </div>
                        </div>
                        <div class="timeline-connector"></div>
                        <div class="timeline-step">
                            <div class="step-marker">4</div>
                            <div class="step-info">
                                <strong>{{ __('why_us.step_delivery') }}</strong>
                                <span>{{ __('why_us.step_delivery_desc') }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

    </div>

</section><!-- /Why Us Section -->