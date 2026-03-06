@extends('layouts.landing')

@php
    $locale = app()->getLocale();
    $fallback = config('app.fallback_locale');
    $postTrans = $post->translate($locale) ?? $post->translate($fallback);
    $catTrans = $post->category?->translate($locale) ?? $post->category?->translate($fallback);
@endphp

@section('title', $postTrans?->title . ' | Veridian Solutions Blog')
@section('meta_description', Str::limit(strip_tags($postTrans?->content), 150))
{{-- Fallback image for OG --}}
@php $ogFeatPath = $post->image_featured ? str_replace('storage/', '', $post->image_featured) : null; @endphp
@if($ogFeatPath && \Storage::disk('public')->exists($ogFeatPath))
@section('og_image', asset('storage/' . $ogFeatPath))
@endif

@section('body_class', 'blog-post-page')

@push('styles')
    <link href="{{ asset('company-landing/assets/css/blog.css') }}" rel="stylesheet">
@endpush

@section('content')

    <!-- Page Title -->
    <div class="page-title page-title-animated" data-aos="fade">
        <div class="heading">
            <div class="container">
                <div class="row d-flex justify-content-center text-center">
                    <div class="col-lg-10">
                        @if($catTrans)
                            <span class="service-badge"
                                style="background-color: {{ $post->category?->badge_color ?? 'var(--accent-color)' }}">{{ $catTrans->name }}</span>
                        @endif
                        <h1>{{ $postTrans?->title }}</h1>
                        <div class="blog-post-meta">
                            <span><i class="bi bi-calendar"></i>
                                {{ \Carbon\Carbon::parse($post->published_at)->format('F d, Y') }}</span>
                            <span><i class="bi bi-eye"></i> {{ $post->views_count }} {{ __('blog.views') }}</span>
                            <span><i class="bi bi-person"></i>
                                {{ $post->author?->name ?? __('blog.fallback_author') }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <nav class="breadcrumbs">
            <div class="container">
                <ol>
                    <li><a href="{{ route('home', ['locale' => $locale]) }}">{{ __('common.home') }}</a></li>
                    <li><a href="{{ route('blog.index', ['locale' => $locale]) }}">{{ __('common.blog') }}</a></li>
                    <li class="current">{{ Str::limit($postTrans?->title, 40) }}</li>
                </ol>
            </div>
        </nav>
    </div><!-- End Page Title -->

    <div class="container">
        <div class="blog-featured-image" data-aos="zoom-in">
            @php $showFeatPath = $post->image_featured ? str_replace('storage/', '', $post->image_featured) : null; @endphp
            @if($showFeatPath && \Storage::disk('public')->exists($showFeatPath))
                <img src="{{ asset('storage/' . $showFeatPath) }}" alt="{{ $postTrans?->title }}" class="img-fluid">
            @else
                <img src="https://ui-avatars.com/api/?name={{ urlencode($postTrans?->title) }}&background=123a32&color=fff&size=1200x600&font-size=0.1"
                    alt="{{ $postTrans?->title }}" class="img-fluid">
            @endif
        </div>
    </div>

    <div class="blog-content-wrapper">
        <article class="blog-content" data-aos="fade-up">
            {!! $postTrans?->content !!}
        </article>

        @if($post->author)
            <div class="author-bio" data-aos="fade-up">
                @php $authorAvatar = $post->author->avatar ? str_replace('storage/', '', $post->author->avatar) : null; @endphp
                @if($authorAvatar && \Storage::disk('public')->exists($authorAvatar))
                    <img src="{{ asset('storage/' . $authorAvatar) }}" alt="{{ $post->author->name }}" class="author-avatar">
                @else
                    <img src="https://ui-avatars.com/api/?name={{ urlencode($post->author->name) }}&background=random"
                        alt="{{ $post->author->name }}" class="author-avatar">
                @endif
                <div class="author-info">
                    <h5>{{ $post->author->name }}</h5>
                    <p class="author-role">{{ $post->author->author_title ?? __('blog_detail.fallback_author_role') }}</p>
                    <p class="author-description">{{ $post->author->author_bio ?? '' }}</p>
                </div>
            </div>
        @endif

        <div class="related-posts" data-aos="fade-up">
            <h3>{{ __('blog_detail.related_articles') }}</h3>
            <div class="related-posts-grid">
                @forelse($relatedPosts as $related)
                    @php
                        $relTrans = $related->translate($locale) ?? $related->translate($fallback);
                    @endphp
                    <div class="related-post-card">
                        <div class="related-post-image">
                            @php $relFeatPath = $related->image_featured ? str_replace('storage/', '', $related->image_featured) : null; @endphp
                            @if($relFeatPath && \Storage::disk('public')->exists($relFeatPath))
                                <img src="{{ asset('storage/' . $relFeatPath) }}" alt="{{ $relTrans?->title }}">
                            @else
                                <img src="https://ui-avatars.com/api/?name={{ urlencode($relTrans?->title) }}&background=123a32&color=fff&size=500&font-size=0.1"
                                    alt="{{ $relTrans?->title }}">
                            @endif
                        </div>
                        <div class="related-post-content">
                            <h4><a
                                    href="{{ route('blog.show', ['locale' => $locale, 'slug' => $relTrans?->slug]) }}">{{ Str::limit($relTrans?->title, 50) }}</a>
                            </h4>
                            <p class="related-post-meta"><i class="bi bi-calendar"></i>
                                {{ \Carbon\Carbon::parse($related->published_at)->format('M d, Y') }}</p>
                        </div>
                    </div>
                @empty
                    <p class="text-muted">{{ __('blog_detail.no_related') }}</p>
                @endforelse
            </div>
        </div>

        <div class="blog-cta" data-aos="zoom-in">
            <h3>{{ __('blog_detail.cta_title') }}</h3>
            <p>{{ __('blog_detail.cta_description') }}</p>
            <a href="{{ route('home', ['locale' => $locale]) }}#contact"
                class="blog-cta-button">{{ __('blog_detail.cta_button') }}</a>
        </div>
    </div>

@endsection