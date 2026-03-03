<!-- ======= Hero Section ======= -->
<section id="hero" class="hero section">

    <div class="container" data-aos="fade-up" data-aos-delay="100">

        <div class="row align-items-center gy-5">

            <div class="col-lg-6" data-aos="fade-right" data-aos-delay="200">
                <div class="hero-content">
                    <div class="hero-tag" data-aos="fade-up" data-aos-delay="250">
                        <span class="tag-dot"></span>
                        <span class="tag-text">
                            {{ $company->translate($currentLocale)?->hero_badge ?? 'Professional Language Solutions' }}
                        </span>
                    </div>

                    <h1 class="hero-headline" data-aos="fade-up" data-aos-delay="300">
                        {{ $company->translate($currentLocale)?->hero_title ?? 'Breaking Language Barriers for Global Success' }}
                    </h1>

                    <p class="hero-text" data-aos="fade-up" data-aos-delay="350">
                        {{ $company->translate($currentLocale)?->hero_description ?? 'Expert translation, dubbing, subtitling, and localization services that elevate your content across cultures and languages. Connect with audiences worldwide.' }}
                    </p>

                    <div class="hero-cta" data-aos="fade-up" data-aos-delay="400">
                        <a href="#services" class="cta-button">
                            <span>Explore Services</span>
                            <i class="bi bi-arrow-right"></i>
                        </a>
                        <a href="#contact" class="glightbox cta-link contact-btn">
                            <i class="bi bi-chat-dots"></i>
                            <span>Chat with Us</span>
                        </a>
                    </div>
                </div>
            </div>

            <div class="col-lg-6" data-aos="fade-left" data-aos-delay="300">
                <div class="stats-grid">
                    <div class="stat-card stat-card-primary" data-aos="zoom-in" data-aos-delay="350">
                        <div class="stat-icon-wrap">
                            <i class="bi bi-translate"></i>
                        </div>
                        <div class="stat-info">
                            <span class="stat-value">{{ $company->stat_projects ?? '500+' }}</span>
                            <span class="stat-title">Projects Translated</span>
                        </div>
                    </div>

                    <div class="stat-card" data-aos="zoom-in" data-aos-delay="400">
                        <div class="stat-icon-wrap">
                            <i class="bi bi-heart-fill"></i>
                        </div>
                        <div class="stat-info">
                            <span class="stat-value">{{ $company->stat_satisfaction ?? '98%' }}</span>
                            <span class="stat-title">Client Satisfaction</span>
                        </div>
                    </div>

                    <div class="stat-card" data-aos="zoom-in" data-aos-delay="450">
                        <div class="stat-icon-wrap">
                            <i class="bi bi-award-fill"></i>
                        </div>
                        <div class="stat-info">
                            <span class="stat-value">{{ $company->stat_experience ?? '15+' }}</span>
                            <span class="stat-title">Years Experience</span>
                        </div>
                    </div>

                    <div class="stat-card stat-card-accent" data-aos="zoom-in" data-aos-delay="500">
                        <div class="stat-icon-wrap">
                            <i class="bi bi-globe2"></i>
                        </div>
                        <div class="stat-info">
                            <span class="stat-value">{{ $company->stat_languages ?? '50+' }}</span>
                            <span class="stat-title">Languages Supported</span>
                        </div>
                    </div>
                </div>
            </div>

        </div>

    </div>

</section><!-- /Hero Section -->