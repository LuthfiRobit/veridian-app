{{-- ======= Footer ======= --}}
<footer id="footer" class="footer">

    <div class="container">
        <div class="row gy-4">

            {{-- Footer About --}}
            <div class="col-lg-4 col-md-6 footer-about">
                <a href="{{ route('home', ['locale' => $currentLocale]) }}" class="logo d-flex align-items-center">
                    <span class="sitename">Veridian<span style="color: var(--primary-light);">Solutions</span></span>
                </a>
                <div class="footer-contact pt-3">
                    @if(isset($company))
                        <p>{{ $company->translate($currentLocale)?->footer_description ?? __('footer.fallback_description') }}
                        </p>
                        <p class="mt-3"><strong>{{ __('footer.phone') }}</strong>
                            <span>{{ $company->phone ?? '+62 812-3456-7890' }}</span>
                        </p>
                        <p><strong>{{ __('footer.email') }}</strong> <span>{{ $company->email ??
                                'contact@veridian-solutions.com' }}</span>
                        </p>
                    @else
                        <p>{{ __('footer.fallback_description') }}</p>
                        <p class="mt-3"><strong>{{ __('footer.phone') }}</strong> <span>+62 812-3456-7890</span></p>
                        <p><strong>{{ __('footer.email') }}</strong> <span>contact@veridian-solutions.com</span></p>
                    @endif
                </div>
                <div class="social-links d-flex mt-4">
                    @if(isset($company))
                        @if($company->social_twitter)<a href="{{ $company->social_twitter }}" target="_blank"><i
                        class="bi bi-twitter-x"></i></a>@endif
                        @if($company->social_facebook)<a href="{{ $company->social_facebook }}" target="_blank"><i
                        class="bi bi-facebook"></i></a>@endif
                        @if($company->social_instagram)<a href="{{ $company->social_instagram }}" target="_blank"><i
                        class="bi bi-instagram"></i></a>@endif
                        @if($company->social_linkedin)<a href="{{ $company->social_linkedin }}" target="_blank"><i
                        class="bi bi-linkedin"></i></a>@endif
                        @if($company->social_youtube)<a href="{{ $company->social_youtube }}" target="_blank"><i
                        class="bi bi-youtube"></i></a>@endif
                        @if($company->social_tiktok)<a href="{{ $company->social_tiktok }}" target="_blank"><i
                        class="bi bi-tiktok"></i></a>@endif
                    @else
                        <a href="#"><i class="bi bi-twitter-x"></i></a>
                        <a href="#"><i class="bi bi-facebook"></i></a>
                        <a href="#"><i class="bi bi-instagram"></i></a>
                        <a href="#"><i class="bi bi-linkedin"></i></a>
                    @endif
                </div>
            </div>

            {{-- Quick Links --}}
            <div class="col-lg-2 col-md-3 footer-links">
                <h4>{{ __('footer.quick_links') }}</h4>
                <ul>
                    <li><a href="{{ route('home', ['locale' => $currentLocale]) }}#hero">{{ __('nav.home') }}</a></li>
                    <li><a href="{{ route('about', ['locale' => $currentLocale]) }}">{{ __('nav.about_us') }}</a></li>
                    <li><a
                            href="{{ route('home', ['locale' => $currentLocale]) }}#services">{{ __('nav.services') }}</a>
                    </li>
                    <li><a
                            href="{{ route('home', ['locale' => $currentLocale]) }}#portfolio">{{ __('nav.portfolio') }}</a>
                    </li>
                    <li><a href="{{ route('home', ['locale' => $currentLocale]) }}#contact">{{ __('nav.contact') }}</a>
                    </li>
                </ul>
            </div>

            {{-- Our Services (dynamic from DB if available, fallback to static) --}}
            <div class="col-lg-2 col-md-3 footer-links">
                <h4>{{ __('footer.our_services') }}</h4>
                <ul>
                    @if(isset($footerServices) && $footerServices->count())
                        @foreach($footerServices as $svc)
                            @php
                                $svcName = $svc->translate($currentLocale)?->name ?? $svc->translate()?->name ?? '';
                                $svcSlug = $svc->translate($currentLocale)?->slug ?? $svc->translate()?->slug ?? '#';
                            @endphp
                            <li><a
                                    href="{{ route('services.show', ['locale' => $currentLocale, 'slug' => $svcSlug]) }}">{{ $svcName }}</a>
                            </li>
                        @endforeach
                    @else
                        <li><a
                                href="{{ route('home', ['locale' => $currentLocale]) }}#services">{{ __('footer.fallback_service_1') }}</a>
                        </li>
                        <li><a
                                href="{{ route('home', ['locale' => $currentLocale]) }}#services">{{ __('footer.fallback_service_2') }}</a>
                        </li>
                        <li><a
                                href="{{ route('home', ['locale' => $currentLocale]) }}#services">{{ __('footer.fallback_service_3') }}</a>
                        </li>
                        <li><a
                                href="{{ route('home', ['locale' => $currentLocale]) }}#services">{{ __('footer.fallback_service_4') }}</a>
                        </li>
                    @endif
                </ul>
            </div>

            {{-- Newsletter --}}
            <div class="col-lg-4 col-md-12 footer-newsletter">
                <h4>{{ __('footer.our_newsletter') }}</h4>
                <p>{{ __('footer.newsletter_description') }}</p>
                <form action="#" method="post" class="php-email-form">
                    <div class="newsletter-form">
                        <input type="email" name="email" placeholder="{{ __('footer.placeholder_email') }}">
                        <input type="submit" value="{{ __('footer.subscribe') }}">
                    </div>
                </form>
            </div>

        </div>
    </div>

    {{-- Footer Bottom --}}
    <div class="container footer-bottom">
        <div class="row gy-3">
            <div class="col-md-6 order-2 order-md-1">
                <div class="copyright">
                    <p>&copy; <span>{{ __('footer.copyright') }}</span> <strong class="sitename">Veridian
                            Solutions</strong>. {{ __('footer.all_rights_reserved') }}</p>
                </div>
            </div>
            <div class="col-md-6 order-1 order-md-2">
                <div class="legal-links">
                    <a href="#">{{ __('footer.terms_of_service') }}</a>
                    <a href="#">{{ __('footer.privacy_policy') }}</a>
                    <a href="#">{{ __('footer.cookies') }}</a>
                </div>
            </div>
        </div>
    </div>

</footer>