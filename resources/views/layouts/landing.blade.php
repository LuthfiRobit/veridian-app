<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>@yield('title', __('meta.default_title'))</title>
    <meta name="description" content="@yield('meta_description', __('meta.default_description'))">
    <meta name="keywords" content="@yield('meta_keywords', __('meta.default_keywords'))">

    <!-- Open Graph (Facebook / LinkedIn) -->
    <meta property="og:type" content="@yield('og_type', 'website')">
    <meta property="og:title" content="@yield('og_title', __('meta.default_title'))">
    <meta property="og:description" content="@yield('og_description', __('meta.default_description'))">
    <meta property="og:url" content="@yield('og_url', url()->current())">
    <meta property="og:image" content="@yield('og_image', asset('company-landing/assets/img/WEB-LOGO-ORIGINAL.png'))">
    <meta property="og:site_name" content="Veridian Solutions">
    <meta property="og:locale" content="{{ app()->getLocale() }}">

    <!-- Twitter Cards -->
    <meta name="twitter:card" content="@yield('twitter_card', 'summary_large_image')">
    <meta name="twitter:title" content="@yield('twitter_title', __('meta.default_title'))">
    <meta name="twitter:description" content="@yield('twitter_description', __('meta.default_description'))">
    <meta name="twitter:image"
        content="@yield('twitter_image', asset('company-landing/assets/img/WEB-LOGO-ORIGINAL.png'))">

    <!-- Canonical URL -->
    <link rel="canonical" href="@yield('canonical_url', url()->current())">

    <!-- Favicons -->
    <link href="{{ asset('company-landing/assets/img/WEB-LOGO-SMALL-NO-NAME.png') }}" rel="icon">
    <link href="{{ asset('company-landing/assets/img/WEB-LOGO-SMALL-NAME.png') }}" rel="apple-touch-icon">

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com" rel="preconnect">
    <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700;800&family=Open+Sans:wght@300;400;600&display=swap"
        rel="stylesheet">

    <!-- Vendor CSS Files -->
    <link href="{{ asset('company-landing/assets/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('company-landing/assets/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
    <link href="{{ asset('company-landing/assets/vendor/aos/aos.css') }}" rel="stylesheet">
    <link href="{{ asset('company-landing/assets/vendor/glightbox/css/glightbox.min.css') }}" rel="stylesheet">
    <link href="{{ asset('company-landing/assets/vendor/swiper/swiper-bundle.min.css') }}" rel="stylesheet">

    <!-- Main CSS File -->
    <link href="{{ asset('company-landing/assets/css/main.css') }}" rel="stylesheet">

    <!-- Veridian Solutions Custom CSS -->
    <link href="{{ asset('company-landing/assets/css/linguavoice.css') }}" rel="stylesheet">

    @stack('styles')
</head>

<body class="@yield('body_class', 'index-page')">

    {{-- Header Partial --}}
    @include('frontend.partials.header')

    <main class="main">
        @yield('content')
    </main>

    {{-- Footer Partial --}}
    @include('frontend.partials.footer')

    <!-- Scroll Top -->
    <a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center">
        <i class="bi bi-arrow-up-short"></i>
    </a>

    <!-- WhatsApp Floating Button -->
    @if(isset($company) && $company->whatsapp)
        <div class="whatsapp-float contact-btn" data-whatsapp="{{ $company->whatsapp }}">
            <i class="bi bi-whatsapp"></i>
        </div>
    @endif

    <!-- Preloader -->
    <div id="preloader"></div>

    <!-- Vendor JS Files -->
    <script src="{{ asset('company-landing/assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('company-landing/assets/vendor/aos/aos.js') }}"></script>
    <script src="{{ asset('company-landing/assets/vendor/glightbox/js/glightbox.min.js') }}"></script>
    <script src="{{ asset('company-landing/assets/vendor/imagesloaded/imagesloaded.pkgd.min.js') }}"></script>
    <script src="{{ asset('company-landing/assets/vendor/isotope-layout/isotope.pkgd.min.js') }}"></script>
    <script src="{{ asset('company-landing/assets/vendor/purecounter/purecounter_vanilla.js') }}"></script>
    <script src="{{ asset('company-landing/assets/vendor/swiper/swiper-bundle.min.js') }}"></script>

    <!-- Main JS File -->
    <script src="{{ asset('company-landing/assets/js/main.js') }}?v=1.1"></script>

    <!-- SweetAlert2 for notifications & WhatsApp -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    {{-- Locale Fallback Toast Notification --}}
    @if(session('locale_fallback'))
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                Swal.fire({
                    toast: true,
                    position: 'top-end',
                    icon: 'info',
                    title: '{{ session("locale_fallback") }}',
                    showConfirmButton: false,
                    timer: 5000,
                    timerProgressBar: true,
                });
            });
        </script>
    @endif

    {{-- WhatsApp SweetAlert Integration --}}
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const whatsappNumber = '{{ isset($company) ? ($company->whatsapp ?? "") : "" }}';
            if (!whatsappNumber) return;

            const whatsappMessage = encodeURIComponent(@json(__('swal.whatsapp_message')));
            const whatsappURL = `https://wa.me/${whatsappNumber}?text=${whatsappMessage}`;

            document.querySelectorAll('.contact-btn').forEach(function (button) {
                button.addEventListener('click', function (e) {
                    if (!this.hasAttribute('href') || this.getAttribute('href') === '#contact' || this.classList.contains('whatsapp-float')) {
                        e.preventDefault();
                        Swal.fire({
                            title: @json(__('swal.whatsapp_title')),
                            html: @json(__('swal.whatsapp_html')),
                            icon: 'info',
                            timer: 2000,
                            timerProgressBar: true,
                            showConfirmButton: false,
                            didOpen: function () { Swal.showLoading(); },
                            willClose: function () { window.open(whatsappURL, '_blank'); }
                        });
                    }
                });
            });
        });
    </script>

    @stack('scripts')

    {{-- AJAX Contact Form Submission --}}
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const contactForm = document.querySelector('.php-email-form');
            if (contactForm) {
                contactForm.addEventListener('submit', function (e) {
                    e.preventDefault();

                    const submitBtn = contactForm.querySelector('#submit-contact-form');
                    const spinner = submitBtn.querySelector('.spinner-border');
                    const btnText = submitBtn.querySelector('.btn-text');

                    // Loading state
                    submitBtn.disabled = true;
                    spinner.classList.remove('d-none');
                    btnText.textContent = @json(__('swal.sending'));

                    const formData = new FormData(contactForm);

                    fetch(contactForm.action, {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            'Accept': 'application/json'
                        }
                    })
                        .then(response => response.json().then(data => ({ status: response.status, body: data })))
                        .then(res => {
                            // Reset button state
                            submitBtn.disabled = false;
                            spinner.classList.add('d-none');
                            btnText.textContent = @json(__('contact.send_message'));

                            if (res.status === 200 && res.body.success) {
                                Swal.fire({
                                    icon: 'success',
                                    title: @json(__('swal.success_title')),
                                    text: res.body.message,
                                    confirmButtonColor: '#059669' // brand green
                                });
                                contactForm.reset();
                            } else if (res.status === 422) {
                                // Validation errors
                                let errorList = '';
                                for (const [key, messages] of Object.entries(res.body.errors)) {
                                    errorList += messages[0] + '<br>';
                                }
                                Swal.fire({
                                    icon: 'error',
                                    title: @json(__('swal.validation_failed')),
                                    html: errorList,
                                    confirmButtonColor: '#ef4444' // red
                                });
                            } else {
                                // Server error
                                Swal.fire({
                                    icon: 'error',
                                    title: @json(__('swal.oops')),
                                    text: res.body.message || @json(__('swal.something_went_wrong')),
                                    confirmButtonColor: '#ef4444'
                                });
                            }
                        })
                        .catch(error => {
                            // Network error
                            submitBtn.disabled = false;
                            spinner.classList.add('d-none');
                            btnText.textContent = @json(__('contact.send_message'));

                            Swal.fire({
                                icon: 'error',
                                title: @json(__('swal.network_error')),
                                text: @json(__('swal.network_error_text')),
                                confirmButtonColor: '#ef4444'
                            });
                        });
                });
            }
        });
    </script>
</body>

</html>