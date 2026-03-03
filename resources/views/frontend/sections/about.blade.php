<!-- ======= About Section ======= -->
<section id="about" class="about section">

    <div class="container" data-aos="fade-up" data-aos-delay="100">

        <div class="row gy-5 align-items-center">

            <div class="col-xl-6" data-aos="fade-right" data-aos-delay="200">
                <div class="about-images-wrapper">
                    <div class="image-main">
                        <img src="{{ isset($company) && $company->about_image_1 ? asset('storage/' . $company->about_image_1) : asset('company-landing/assets/img/about/about-5.webp') }}"
                            alt="Veridian Solutions team" class="img-fluid" style="border-radius: 20px;">
                    </div>
                    <div class="image-offset">
                        <img src="{{ isset($company) && $company->about_image_2 ? asset('storage/' . $company->about_image_2) : asset('company-landing/assets/img/about/about-square-3.webp') }}"
                            alt="Translation services" class="img-fluid" style="border-radius: 20px;">
                    </div>
                    <div class="experience-badge">
                        <span class="years purecounter" data-purecounter-start="0"
                            data-purecounter-end="{{ (int) ($company->stat_experience ?? 15) }}"
                            data-purecounter-duration="1">{{ (int) ($company->stat_experience ?? 15) }}</span>
                        <span class="text">Years of<br>Excellence</span>
                    </div>
                    <div class="shape-pattern"></div>
                </div>
            </div>

            <div class="col-xl-6" data-aos="fade-left" data-aos-delay="300">
                <div class="about-content">
                    <div class="section-subtitle">Who We Are</div>
                    <h2>{{ $company->translate($currentLocale)?->about_title ?? 'Empowering Global Communication Through Expert Language Services' }}
                    </h2>
                    <p class="lead-text">
                        {{ $company->translate($currentLocale)?->about_description ?? 'Veridian Solutions is your trusted partner for professional translation, dubbing, subtitling, and localization services. We bridge language gaps to help businesses and individuals communicate effectively across borders.' }}
                    </p>

                    <div class="features-grid mt-4">
                        <div class="feature-card">
                            <i class="bi bi-check-circle-fill"></i>
                            <span>Native Linguists</span>
                        </div>
                        <div class="feature-card">
                            <i class="bi bi-check-circle-fill"></i>
                            <span>ISO Certified</span>
                        </div>
                        <div class="feature-card">
                            <i class="bi bi-check-circle-fill"></i>
                            <span>Fast Turnaround</span>
                        </div>
                        <div class="feature-card">
                            <i class="bi bi-check-circle-fill"></i>
                            <span>24/7 Support</span>
                        </div>
                    </div>

                    <div class="stats-row">
                        <div class="stat-box">
                            <span class="number purecounter" data-purecounter-start="0"
                                data-purecounter-end="{{ (int) ($company->stat_projects ?? 500) }}"
                                data-purecounter-duration="1">{{ (int) ($company->stat_projects ?? 500) }}</span>
                            <span class="label">Projects Done</span>
                        </div>
                        <div class="stat-box">
                            <span class="number purecounter" data-purecounter-start="0" data-purecounter-end="200"
                                data-purecounter-duration="1">200</span>
                            <span class="label">Happy Clients</span>
                        </div>
                        <div class="stat-box">
                            <span class="number purecounter" data-purecounter-start="0"
                                data-purecounter-end="{{ (int) ($company->stat_satisfaction ?? 95) }}"
                                data-purecounter-duration="1">{{ (int) ($company->stat_satisfaction ?? 95) }}%</span>
                            <span class="label">Retention</span>
                        </div>
                    </div>

                    <div class="action-buttons">
                        <a href="{{ route('about', ['locale' => $currentLocale]) }}" class="btn btn-primary-custom">
                            Learn More About Us <i class="bi bi-arrow-right"></i>
                        </a>
                        <div class="contact-info">
                            <div class="icon-box">
                                <i class="bi bi-whatsapp"></i>
                            </div>
                            <div class="text">
                                <span>WhatsApp Us</span>
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