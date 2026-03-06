<!-- ======= Portfolio Section ======= -->
<section id="portfolio" class="portfolio section">

    <!-- Section Title -->
    <div class="container section-title" data-aos="fade-up">
        <h2>{{ __('portfolio.section_title') }}</h2>
        <p>{{ __('portfolio.section_subtitle') }}</p>
    </div><!-- End Section Title -->

    <div class="container" data-aos="fade-up" data-aos-delay="100">

        <div class="isotope-layout" data-default-filter="*" data-layout="fitRows" data-sort="original-order">

            <div class="filters-wrapper" data-aos="fade-up" data-aos-delay="100">
                <ul class="portfolio-filters isotope-filters">
                    <li data-filter="*" class="filter-active">{{ __('portfolio.all_projects') }}</li>
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
                        if ($image && \Str::startsWith($image, 'storage/')) {
                            $image = \Str::replaceFirst('storage/', '', $image);
                        }
                        $imageUrl = ($image && \Storage::disk('public')->exists($image))
                            ? asset('storage/' . $image)
                            : 'https://ui-avatars.com/api/?name=' . urlencode($translation?->title ?? 'Project') . '&background=123a32&color=fff&size=800&font-size=0.1&length=2';
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
                                <span
                                    class="category-badge">{{ $catTranslation?->name ?? __('portfolio.fallback_category') }}</span>
                                @if($project->is_featured)
                                    <span class="featured-badge"><i class="bi bi-star-fill"></i>
                                        {{ __('portfolio.featured') }}</span>
                                @endif
                            </div>
                            <div class="project-info">
                                <h3><a
                                        href="{{ route('portfolio.show', ['locale' => $currentLocale, 'slug' => $translation?->slug ?? '#']) }}">{{ $translation?->title ?? __('portfolio.fallback_title') }}</a>
                                </h3>
                                <p>{{ Str::limit($translation?->short_description ?? __('portfolio.fallback_desc'), 80) }}
                                </p>
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
                        <p>{{ __('portfolio.empty_state') }}</p>
                    </div>
                @endforelse

            </div><!-- End Portfolio Container -->

        </div>

        <div class="cta-section" data-aos="zoom-in" data-aos-delay="300">
            <div class="cta-content">
                <span class="cta-label"><i class="bi bi-lightning-charge-fill"></i>
                    {{ __('portfolio.cta_label') }}</span>
                <h3>{{ __('portfolio.cta_title') }}</h3>
                <p>{{ __('portfolio.cta_description') }}</p>
                <div class="cta-buttons">
                    <a href="{{ route('home', ['locale' => $currentLocale]) }}#contact"
                        class="btn-cta-primary contact-btn">{{ __('portfolio.start_project') }} <i
                            class="bi bi-arrow-right"></i></a>
                    <a href="{{ route('home', ['locale' => $currentLocale]) }}#services" class="btn-cta-secondary"><i
                            class="bi bi-collection"></i> {{ __('portfolio.view_all_services') }}</a>
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