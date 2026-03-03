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
                        <p>{{ $company->translate($currentLocale)?->footer_description ?? 'Professional translation, dubbing, subtitling, and localization services for global communication.' }}
                        </p>
                        <p class="mt-3"><strong>Phone:</strong> <span>{{ $company->phone ?? '+62 812-3456-7890' }}</span>
                        </p>
                        <p><strong>Email:</strong> <span>{{ $company->email ?? 'contact@veridian-solutions.com' }}</span>
                        </p>
                    @else
                        <p>Professional translation, dubbing, subtitling, and localization services for global
                            communication.</p>
                        <p class="mt-3"><strong>Phone:</strong> <span>+62 812-3456-7890</span></p>
                        <p><strong>Email:</strong> <span>contact@veridian-solutions.com</span></p>
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
                <h4>Quick Links</h4>
                <ul>
                    <li><a href="{{ route('home', ['locale' => $currentLocale]) }}#hero">Home</a></li>
                    <li><a href="{{ route('about', ['locale' => $currentLocale]) }}">About Us</a></li>
                    <li><a href="{{ route('home', ['locale' => $currentLocale]) }}#services">Services</a></li>
                    <li><a href="{{ route('home', ['locale' => $currentLocale]) }}#portfolio">Portfolio</a></li>
                    <li><a href="{{ route('home', ['locale' => $currentLocale]) }}#contact">Contact</a></li>
                </ul>
            </div>

            {{-- Our Services (dynamic from DB if available, fallback to static) --}}
            <div class="col-lg-2 col-md-3 footer-links">
                <h4>Our Services</h4>
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
                        <li><a href="{{ route('home', ['locale' => $currentLocale]) }}#services">Document Translation</a>
                        </li>
                        <li><a href="{{ route('home', ['locale' => $currentLocale]) }}#services">Professional Dubbing</a>
                        </li>
                        <li><a href="{{ route('home', ['locale' => $currentLocale]) }}#services">Video Subtitling</a></li>
                        <li><a href="{{ route('home', ['locale' => $currentLocale]) }}#services">Software Localization</a>
                        </li>
                    @endif
                </ul>
            </div>

            {{-- Newsletter --}}
            <div class="col-lg-4 col-md-12 footer-newsletter">
                <h4>Our Newsletter</h4>
                <p>Subscribe to receive updates on language industry trends and Veridian Solutions news!</p>
                <form action="#" method="post" class="php-email-form">
                    <div class="newsletter-form">
                        <input type="email" name="email" placeholder="Your Email">
                        <input type="submit" value="Subscribe">
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
                    <p>&copy; <span>Copyright</span> <strong class="sitename">Veridian Solutions</strong>. All Rights
                        Reserved.</p>
                </div>
            </div>
            <div class="col-md-6 order-1 order-md-2">
                <div class="legal-links">
                    <a href="#">Terms of Service</a>
                    <a href="#">Privacy Policy</a>
                    <a href="#">Cookies</a>
                </div>
            </div>
        </div>
    </div>

</footer>