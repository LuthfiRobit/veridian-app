<!-- ======= About Section ======= -->
<section id="about" class="about section">

    <div class="container" data-aos="fade-up" data-aos-delay="100">

        <div class="row gy-5 align-items-center">

            <div class="col-xl-6" data-aos="fade-right" data-aos-delay="200">
                <div class="about-images-wrapper">
                    <div class="image-main">
                        @if(isset($company) && $company->about_image_main && \Storage::disk('public')->exists($company->about_image_main))
                            <img src="{{ asset('storage/' . $company->about_image_main) }}" alt="{{ __('alt.team_image') }}"
                                class="img-fluid" style="border-radius: 20px;">
                        @else
                            <img src="https://ui-avatars.com/api/?name={{ urlencode($company->company_name ?? 'About') }}&background=123a32&color=fff&size=800&font-size=0.1&length=2"
                                alt="{{ __('alt.team_image') }}" class="img-fluid" style="border-radius: 20px;">
                        @endif
                    </div>
                    <div class="image-offset">
                        @if(isset($company) && $company->about_image_secondary && \Storage::disk('public')->exists($company->about_image_secondary))
                            <img src="{{ asset('storage/' . $company->about_image_secondary) }}"
                                alt="{{ __('alt.translation_services') }}" class="img-fluid" style="border-radius: 20px;">
                        @else
                            <img src="https://ui-avatars.com/api/?name={{ urlencode($company->company_name ?? 'Services') }}&background=123a32&color=fff&size=800&font-size=0.1&length=2"
                                alt="{{ __('alt.translation_services') }}" class="img-fluid" style="border-radius: 20px;">
                        @endif
                    </div>
                    <div class="experience-badge">
                        <span class="years purecounter" data-purecounter-start="0"
                            data-purecounter-end="{{ (int) ($company->stat_experience ?? 15) }}"
                            data-purecounter-duration="1">{{ (int) ($company->stat_experience ?? 15) }}</span>
                        <span class="text">{{ __('about.years_of_excellence') }}</span>
                    </div>
                    <div class="shape-pattern"></div>
                </div>
            </div>

            <div class="col-xl-6" data-aos="fade-left" data-aos-delay="300">
                <div class="about-content">
                    <div class="section-subtitle">{{ __('about.section_subtitle') }}</div>
                    <h2>{{ $company->translate($currentLocale)?->about_title ?? __('about.fallback_title') }}
                    </h2>
                    <p class="lead-text">
                        {{ $company->translate($currentLocale)?->about_description ?? __('about.fallback_description') }}
                    </p>

                    <div class="features-grid mt-4">
                        <div class="feature-card">
                            <i class="bi bi-check-circle-fill"></i>
                            <span>{{ __('about.native_linguists') }}</span>
                        </div>
                        <div class="feature-card">
                            <i class="bi bi-check-circle-fill"></i>
                            <span>{{ __('about.iso_certified') }}</span>
                        </div>
                        <div class="feature-card">
                            <i class="bi bi-check-circle-fill"></i>
                            <span>{{ __('about.fast_turnaround') }}</span>
                        </div>
                        <div class="feature-card">
                            <i class="bi bi-check-circle-fill"></i>
                            <span>{{ __('about.support_24_7') }}</span>
                        </div>
                    </div>

                    <div class="stats-row">
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

                    <div class="action-buttons">
                        <a href="{{ route('about', ['locale' => $currentLocale]) }}" class="btn btn-primary-custom">
                            {{ __('about.learn_more') }} <i class="bi bi-arrow-right"></i>
                        </a>
                        <div class="contact-info">
                            <div class="icon-box">
                                <i class="bi bi-whatsapp"></i>
                            </div>
                            <div class="text">
                                <span>{{ __('about.whatsapp_us') }}</span>
                                <a href="https://wa.me/{{ $company->whatsapp ?? '6281234567890' }}"
                                    class="contact-btn">{{ $company->phone ?? '+62 812-3456-7890' }}</a>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

        </div>

    </div>

</section><!-- /About Section -->