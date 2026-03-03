{{-- ======= Header ======= --}}
<header id="header" class="header d-flex align-items-center sticky-top">
    <div class="container position-relative d-flex align-items-center justify-content-between">

        {{-- Logo --}}
        <a href="{{ route('home', ['locale' => $currentLocale]) }}"
            class="logo d-flex align-items-center me-auto me-xl-0">
            <img src="{{ asset('company-landing/assets/img/WEB LOGO ORIGINAL.png') }}" alt="Veridian Solutions"
                style="max-height: 48px;">
        </a>

        {{-- Navigation Menu --}}
        <nav id="navmenu" class="navmenu">
            <ul>
                <li><a href="{{ route('home', ['locale' => $currentLocale]) }}#hero" @if(request()->routeIs('home'))
                class="active" @endif>Home</a></li>
                <li><a href="{{ route('home', ['locale' => $currentLocale]) }}#about">About</a></li>
                <li><a href="{{ route('home', ['locale' => $currentLocale]) }}#services">Services</a></li>

                {{-- Dropdown for Desktop only --}}
                <li class="dropdown d-none d-xl-block">
                    <a href="#"><span>More</span> <i class="bi bi-chevron-down toggle-dropdown"></i></a>
                    <ul>
                        <li><a href="{{ route('about', ['locale' => $currentLocale]) }}">About Us</a></li>
                        <li><a href="{{ route('about.team', ['locale' => $currentLocale]) }}">Our Team</a></li>
                        <li><a href="{{ route('home', ['locale' => $currentLocale]) }}#portfolio">Portfolio</a></li>
                        <li><a href="{{ route('home', ['locale' => $currentLocale]) }}#why-us">Why Us</a></li>
                        <li><a href="{{ route('home', ['locale' => $currentLocale]) }}#testimonials">Testimonials</a>
                        </li>
                        <li><a href="{{ route('blog.index', ['locale' => $currentLocale]) }}">Blog</a></li>
                    </ul>
                </li>

                {{-- Direct menu items for Mobile only --}}
                <li class="d-xl-none"><a href="{{ route('about', ['locale' => $currentLocale]) }}">About Us</a></li>
                <li class="d-xl-none"><a href="{{ route('about.team', ['locale' => $currentLocale]) }}">Our Team</a>
                </li>
                <li class="d-xl-none"><a
                        href="{{ route('home', ['locale' => $currentLocale]) }}#portfolio">Portfolio</a></li>
                <li class="d-xl-none"><a href="{{ route('home', ['locale' => $currentLocale]) }}#why-us">Why Us</a></li>
                <li class="d-xl-none"><a
                        href="{{ route('home', ['locale' => $currentLocale]) }}#testimonials">Testimonials</a></li>
                <li class="d-xl-none"><a href="{{ route('blog.index', ['locale' => $currentLocale]) }}">Blog</a></li>

                <li><a href="{{ route('home', ['locale' => $currentLocale]) }}#contact">Contact</a></li>

                {{-- Language switcher for mobile only (shown if > 1 active language) --}}
                @if($activeLanguages->count() > 1)
                    <li class="language-switcher d-xl-none">
                        <a href="#" class="lang-nav-link" data-languages='@json($activeLanguages)'
                            data-current="{{ $currentLocale }}">
                            <i class="bi bi-chevron-left lang-prev"></i>
                            <span class="lang-display">
                                <i class="bi bi-globe"></i>
                                <span class="lang-code">{{ strtoupper($currentLocale) }}</span>
                            </span>
                            <i class="bi bi-chevron-right lang-next"></i>
                        </a>
                    </li>
                @endif
            </ul>
        </nav>

        <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>

        {{-- Header Actions: Language Switcher + Button (Desktop only) --}}
        <div class="header-actions d-none d-xl-flex">
            @if($activeLanguages->count() > 1)
                <div class="language-switcher">
                    <a href="#" class="lang-nav-link" data-languages='@json($activeLanguages)'
                        data-current="{{ $currentLocale }}">
                        <i class="bi bi-chevron-left lang-prev"></i>
                        <span class="lang-display">
                            <i class="bi bi-globe"></i>
                            <span class="lang-code">{{ strtoupper($currentLocale) }}</span>
                        </span>
                        <i class="bi bi-chevron-right lang-next"></i>
                    </a>
                </div>
            @endif
            <a class="btn-getstarted contact-btn" href="{{ route('home', ['locale' => $currentLocale]) }}#contact">Get
                Started</a>
        </div>

        {{-- Get Started button for mobile --}}
        <a class="btn-getstarted contact-btn d-xl-none"
            href="{{ route('home', ['locale' => $currentLocale]) }}#contact">Get Started</a>

    </div>
</header>

{{-- Language Switcher JavaScript --}}
@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            document.querySelectorAll('.lang-nav-link').forEach(function (link) {
                var languages = JSON.parse(link.dataset.languages || '[]');
                var currentLocale = link.dataset.current;
                if (languages.length <= 1) return;

                var codes = languages.map(function (l) { return l.code; });
                var currentIndex = codes.indexOf(currentLocale);

                function switchLang(direction) {
                    currentIndex = (currentIndex + direction + codes.length) % codes.length;
                    var newLocale = codes[currentIndex];
                    // Replace locale segment in current URL path
                    var path = window.location.pathname;
                    var newPath = path.replace(/^\/[a-z]{2}(\/|$)/, '/' + newLocale + '$1');
                    window.location.href = newPath + window.location.hash;
                }

                var prevBtn = link.querySelector('.lang-prev');
                var nextBtn = link.querySelector('.lang-next');

                if (prevBtn) {
                    prevBtn.addEventListener('click', function (e) {
                        e.preventDefault();
                        e.stopPropagation();
                        switchLang(-1);
                    });
                }
                if (nextBtn) {
                    nextBtn.addEventListener('click', function (e) {
                        e.preventDefault();
                        e.stopPropagation();
                        switchLang(1);
                    });
                }

                link.addEventListener('click', function (e) {
                    e.preventDefault();
                });
            });
        });
    </script>
@endpush