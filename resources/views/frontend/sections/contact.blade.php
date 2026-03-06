<!-- ======= Contact Section ======= -->
<section id="contact" class="contact section">

    <!-- Section Title -->
    <div class="container section-title" data-aos="fade-up">
        <h2>{{ __('contact.section_title') }}</h2>
        <p>{{ __('contact.section_subtitle') }}</p>
    </div><!-- End Section Title -->

    <div class="container" data-aos="fade-up" data-aos-delay="100">

        <div class="row gy-4">

            <div class="col-lg-4">
                <div class="info-item d-flex" data-aos="fade-up" data-aos-delay="300">
                    <i class="bi bi-geo-alt flex-shrink-0"></i>
                    <div>
                        <h3>{{ __('contact.address') }}</h3>
                        <p>{{ $company->address ?? __('contact.fallback_address') }}</p>
                    </div>
                </div><!-- End Info Item -->

                <div class="info-item d-flex" data-aos="fade-up" data-aos-delay="400">
                    <i class="bi bi-telephone flex-shrink-0"></i>
                    <div>
                        <h3>{{ __('contact.call_us') }}</h3>
                        <p>{{ $company->phone ?? '+62 812-3456-7890' }}</p>
                    </div>
                </div><!-- End Info Item -->

                <div class="info-item d-flex" data-aos="fade-up" data-aos-delay="500">
                    <i class="bi bi-envelope flex-shrink-0"></i>
                    <div>
                        <h3>{{ __('contact.email_us') }}</h3>
                        <p>{{ $company->email ?? 'contact@veridian-solutions.com' }}</p>
                    </div>
                </div><!-- End Info Item -->

                <div class="info-item d-flex" data-aos="fade-up" data-aos-delay="600">
                    <i class="bi bi-whatsapp flex-shrink-0"></i>
                    <div>
                        <h3>{{ __('contact.whatsapp') }}</h3>
                        <p><a href="https://wa.me/{{ $company->whatsapp ?? '6281234567890' }}"
                                class="contact-btn">{{ __('contact.chat_with_us') }}</a></p>
                    </div>
                </div><!-- End Info Item -->

            </div>

            <div class="col-lg-8">
                <div class="contact-form-wrapper" data-aos="fade-up" data-aos-delay="200">
                    <h3>{{ __('contact.form_title') }}</h3>
                    <p class="mb-4">{{ __('contact.form_subtitle') }}</p>
                    <form action="{{ route('contact.store', ['locale' => $currentLocale]) ?? '#' }}" method="post"
                        class="php-email-form">
                        @csrf
                        <div class="row gy-4">

                            <div class="col-md-6">
                                <input type="text" name="name" class="form-control"
                                    placeholder="{{ __('contact.placeholder_name') }}" required="">
                            </div>

                            <div class="col-md-6">
                                <input type="email" class="form-control" name="email"
                                    placeholder="{{ __('contact.placeholder_email') }}" required="">
                            </div>

                            <div class="col-md-12">
                                <input type="text" class="form-control" name="subject"
                                    placeholder="{{ __('contact.placeholder_subject') }}" required="">
                            </div>

                            <div class="col-md-12">
                                <select class="form-control" name="service" required="">
                                    <option value="">{{ __('contact.select_service') }}</option>
                                    @foreach($services as $service)
                                        @php $translation = $service->translate($currentLocale) ?? $service->translate(config('app.fallback_locale')); @endphp
                                        <option value="{{ $service->id_service }}">{{ $translation?->name }}</option>
                                    @endforeach
                                    <option value="other">{{ __('contact.other_service') }}</option>
                                </select>
                            </div>

                            <div class="col-md-12">
                                <textarea class="form-control" name="message" rows="6"
                                    placeholder="{{ __('contact.placeholder_message') }}" required=""></textarea>
                            </div>

                            <div class="col-md-12 text-center">
                                <button type="submit" class="btn btn-primary-custom" id="submit-contact-form">
                                    <span class="spinner-border spinner-border-sm d-none" role="status"
                                        aria-hidden="true"></span>
                                    <span class="btn-text">{{ __('contact.send_message') }}</span>
                                </button>
                            </div>

                        </div>
                    </form>
                </div>
            </div><!-- End Contact Form -->

        </div>

    </div>

</section><!-- /Contact Section -->