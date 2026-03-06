@extends('layouts.landing')

@php
    $locale = app()->getLocale();
    $fallback = config('app.fallback_locale');
@endphp

@section('title', __('meta.blog_title'))
@section('meta_description', __('meta.blog_description'))

@section('body_class', 'blog-page')

@push('styles')
    <link href="{{ asset('company-landing/assets/css/blog.css') }}" rel="stylesheet">
@endpush

@section('content')

    <!-- Page Title -->
    <div class="page-title page-title-animated">
        <div class="heading">
            <div class="container">
                <div class="row d-flex justify-content-center text-center">
                    <div class="col-lg-8">
                        <span class="service-badge"><i class="bi bi-newspaper"></i> {{ __('blog.badge_label') }}</span>
                        <h1>{{ __('blog.page_title') }}</h1>
                        <p class="mb-0">{{ __('blog.page_subtitle') }}</p>
                    </div>
                </div>
            </div>
        </div>
        <nav class="breadcrumbs">
            <div class="container">
                <ol>
                    <li><a href="{{ route('home', ['locale' => $locale]) }}">{{ __('common.home') }}</a></li>
                    <li class="current">{{ __('common.blog') }}</li>
                </ol>
            </div>
        </nav>
    </div><!-- End Page Title -->

    <!-- Category Filters -->
    <section class="category-filters">
        <div class="container" data-aos="fade-up">
            <button class="filter-btn active" data-filter="all">{{ __('blog.all_posts') }}</button>
            @foreach($categories as $category)
                @php
                    $catTrans = $category->translate($locale) ?? $category->translate($fallback);
                @endphp
                <button class="filter-btn" data-filter="{{ Str::slug($catTrans?->name ?? 'category') }}">
                    {{ $catTrans?->name }}
                </button>
            @endforeach
        </div>
    </section>

    <!-- Blog Grid -->
    <section class="section">
        <div class="container">
            <div class="blog-grid" data-aos="fade-up" data-aos-delay="100">

                @if($posts->isEmpty())
                    <div class="col-12 text-center text-muted" style="grid-column: 1 / -1; padding: 40px;">
                        <h4>{{ __('blog.empty_state') }}</h4>
                    </div>
                @else
                    @foreach($posts as $post)
                        @php
                            $postTrans = $post->translate($locale) ?? $post->translate($fallback);
                            $catTrans = $post->category?->translate($locale) ?? $post->category?->translate($fallback);
                            $categorySlug = Str::slug($catTrans?->name ?? 'category');
                        @endphp

                        <!-- Blog Card -->
                        <div class="blog-card" data-category="{{ $categorySlug }}">
                            <div class="blog-card-image">
                                @php
                                    $featPath = $post->image_featured ? str_replace('storage/', '', $post->image_featured) : null;
                                @endphp
                                @if($featPath && \Storage::disk('public')->exists($featPath))
                                    <img src="{{ asset('storage/' . $featPath) }}" alt="{{ $postTrans?->title }}" loading="lazy">
                                @else
                                    <img src="https://ui-avatars.com/api/?name={{ urlencode($postTrans?->title) }}&background=123a32&color=fff&size=800&font-size=0.1"
                                        alt="{{ $postTrans?->title }}" loading="lazy">
                                @endif

                                @if($catTrans)
                                    <span class="blog-category-badge"
                                        style="background-color: {{ $post->category?->badge_color ?? 'var(--accent-color)' }}">{{ $catTrans->name }}</span>
                                @endif
                            </div>
                            <div class="blog-card-content">
                                <div class="blog-meta">
                                    <span><i class="bi bi-calendar"></i>
                                        {{ \Carbon\Carbon::parse($post->published_at)->format('M d, Y') }}</span>
                                    <span><i class="bi bi-person"></i>
                                        {{ $post->author?->name ?? __('blog.fallback_author') }}</span>
                                </div>
                                <h3><a
                                        href="{{ route('blog.show', ['locale' => $locale, 'slug' => $postTrans?->slug]) }}">{{ Str::limit($postTrans?->title, 60) }}</a>
                                </h3>
                                <p class="blog-excerpt">{{ Str::limit(strip_tags($postTrans?->content), 120) }}</p>
                                <a href="{{ route('blog.show', ['locale' => $locale, 'slug' => $postTrans?->slug]) }}"
                                    class="blog-read-more">
                                    <span>{{ __('blog.read_more') }}</span>
                                    <i class="bi bi-arrow-right"></i>
                                </a>
                            </div>
                        </div>
                    @endforeach
                @endif

            </div>

            @if($posts->hasPages())
                <div class="mt-5 d-flex justify-content-center">
                    {{ $posts->links() }}
                </div>
            @endif

            <!-- Newsletter CTA -->
            <div class="blog-cta" data-aos="zoom-in" data-aos-delay="200">
                <h3><i class="bi bi-envelope-heart"></i> {{ __('blog.stay_updated') }}</h3>
                <p>{{ __('blog.newsletter_description') }}</p>
                <a href="{{ route('home', ['locale' => $locale]) }}#contact"
                    class="blog-cta-button">{{ __('blog.subscribe_now') }}</a>
            </div>

        </div>
    </section>

@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const filterBtns = document.querySelectorAll('.filter-btn');
            const blogCards = document.querySelectorAll('.blog-card');

            filterBtns.forEach(btn => {
                btn.addEventListener('click', function () {
                    const filter = this.getAttribute('data-filter');

                    // Update active state
                    filterBtns.forEach(b => b.classList.remove('active'));
                    this.classList.add('active');

                    // Filter blog cards
                    blogCards.forEach(card => {
                        if (filter === 'all' || card.getAttribute('data-category') === filter) {
                            card.style.display = 'flex';
                        } else {
                            card.style.display = 'none';
                        }
                    });
                });
            });
        });
    </script>
@endpush