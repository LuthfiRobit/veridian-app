@extends('layouts.landing')

{{-- Meta Tags --}}
@section('meta_title', $company->translate($currentLocale)?->name ?? 'Veridian Solutions - Professional Language Services')
@section('meta_description', Str::limit($company->translate($currentLocale)?->about_description ?? 'Professional translation, dubbing, subtitling, and localization services.', 160))
@section('meta_image', $company->logo_image_path ? asset('storage/' . $company->logo_image_path) : asset('company-landing/assets/img/WEB LOGO ORIGINAL.png'))

@section('content')

    {{-- 1. Hero Section --}}
    @include('frontend.sections.hero')

    {{-- 2. About Section --}}
    @include('frontend.sections.about')

    {{-- 3. Services Section --}}
    @include('frontend.sections.services')

    {{-- 4. Portfolio Section --}}
    @include('frontend.sections.portfolio')

    {{-- 5. Why Us Section --}}
    @include('frontend.sections.why-us')

    {{-- 6. Testimonials Section --}}
    @include('frontend.sections.testimonials')

    {{-- 7. Contact Section --}}
    @include('frontend.sections.contact')

@endsection

@push('scripts')
    {{-- Any home-specific scripts can go here --}}
    {{-- Currently, Swiper and Isotope are handled globally in main.js, but if we need specific init, it's here --}}
@endpush