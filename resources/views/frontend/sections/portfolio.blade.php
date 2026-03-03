<!-- ======= Portfolio Section ======= -->
<section id="portfolio" class="portfolio section">

    <!-- Section Title -->
    <div class="container section-title" data-aos="fade-up">
        <h2>Our Portfolio</h2>
        <p>Showcasing our expertise across diverse language projects and industries</p>
    </div><!-- End Section Title -->

    <div class="container" data-aos="fade-up" data-aos-delay="100">

        <div class="isotope-layout" data-default-filter="*" data-layout="fitRows" data-sort="original-order">

            <div class="filters-wrapper" data-aos="fade-up" data-aos-delay="100">
                <ul class="portfolio-filters isotope-filters">
                    <li data-filter="*" class="filter-active">All Projects</li>
                    @foreach($portfolioCategories as $category)
                        @php
                            $catTrans = $category->translate($currentLocale) ?? $category->translate(config('app.fallback_locale'));
                        @endphp
                        <li data-filter=".filter-{{ $category->id_project_category }}">
                            {{ $catTrans?->name ?? 'Category ' . $category->id_project_category }}
                        </li>
                    @endforeach
                </ul>
            </div>

            <div class="row g-4 isotope-container" data-aos="fade-up" data-aos-delay="200">

                @forelse($projects as $project)
                    @php
                        $translation = $project->translate($currentLocale) ?? $project->translate(config('app.fallback_locale'));
                        $catTranslation = $project->category?->translate($currentLocale) ?? $project->category?->translate(config('app.fallback_locale'));
                        $image = $project->images->first()?->image_path;
                        $imageUrl = $image ? asset('storage/' . $image) : asset('company-landing/assets/img/portfolio/portfolio-1.webp');
                    @endphp
                    <div class="col-lg-4 col-md-6 portfolio-item isotope-item filter-{{ $project->id_project_category }}">
                        <div class="project-card {{ $project->is_featured ? 'featured' : '' }}">
                            <div class="image-wrapper">
                                <img src="{{ $imageUrl }}" alt="{{ $translation?->title }}" class="img-fluid"
                                    loading="lazy">
                                <div class="hover-overlay">
                                    <div class="overlay-actions">
                                        <a href="{{ $imageUrl }}" class="glightbox action-btn" data-gallery="portfolio">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                        <a href="{{ route('home', ['locale' => $currentLocale]) }}#contact"
                                            class="action-btn contact-btn">
                                            <i class="bi bi-chat-dots"></i>
                                        </a>
                                    </div>
                                </div>
                                <span class="category-badge">{{ $catTranslation?->name ?? 'Project' }}</span>
                                @if($project->is_featured)
                                    <span class="featured-badge"><i class="bi bi-star-fill"></i> Featured</span>
                                @endif
                            </div>
                            <div class="project-info">
                                <h3><a
                                        href="{{ route('portfolio.show', ['locale' => $currentLocale, 'slug' => $translation?->slug ?? '#']) }}">{{ $translation?->title ?? 'Project Title' }}</a>
                                </h3>
                                <p>{{ Str::limit($translation?->short_description ?? 'Project description', 80) }}</p>
                                <div class="project-meta">
                                    <div class="tech-tags">
                                        <span>{{ Str::limit($translation?->source_language . '→' . $translation?->target_language, 15) }}</span>
                                    </div>
                                    <span
                                        class="year">{{ $project->completion_date ? \Carbon\Carbon::parse($project->completion_date)->format('Y') : '' }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12 text-center text-muted">
                        <p>No projects available yet.</p>
                    </div>
                @endforelse

            </div><!-- End Portfolio Container -->

        </div>

        <div class="cta-section" data-aos="zoom-in" data-aos-delay="300">
            <div class="cta-content">
                <span class="cta-label"><i class="bi bi-lightning-charge-fill"></i> Ready to Start?</span>
                <h3>Let's Bring Your Content to a Global Audience</h3>
                <p>Partner with us to deliver your message accurately and effectively across languages and cultures.</p>
                <div class="cta-buttons">
                    <a href="{{ route('home', ['locale' => $currentLocale]) }}#contact"
                        class="btn-cta-primary contact-btn">Start Your Project <i class="bi bi-arrow-right"></i></a>
                    <a href="{{ route('home', ['locale' => $currentLocale]) }}#services" class="btn-cta-secondary"><i
                            class="bi bi-collection"></i> View All Services</a>
                </div>
            </div>
            <div class="cta-decoration">
                <div class="floating-shape shape-1"></div>
                <div class="floating-shape shape-2"></div>
                <div class="floating-shape shape-3"></div>
            </div>
        </div>

    </div>

</section><!-- /Portfolio Section -->