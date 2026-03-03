<!-- ======= Contact Section ======= -->
<section id="contact" class="contact section">

    <!-- Section Title -->
    <div class="container section-title" data-aos="fade-up">
        <h2>Contact Us</h2>
        <p>Get in touch with our team to discuss your translation and localization needs</p>
    </div><!-- End Section Title -->

    <div class="container" data-aos="fade-up" data-aos-delay="100">

        <div class="row gy-4">

            <div class="col-lg-4">
                <div class="info-item d-flex" data-aos="fade-up" data-aos-delay="300">
                    <i class="bi bi-geo-alt flex-shrink-0"></i>
                    <div>
                        <h3>Address</h3>
                        <p>{{ $company->address ?? 'Jakarta, Indonesia' }}</p>
                    </div>
                </div><!-- End Info Item -->

                <div class="info-item d-flex" data-aos="fade-up" data-aos-delay="400">
                    <i class="bi bi-telephone flex-shrink-0"></i>
                    <div>
                        <h3>Call Us</h3>
                        <p>{{ $company->phone ?? '+62 812-3456-7890' }}</p>
                    </div>
                </div><!-- End Info Item -->

                <div class="info-item d-flex" data-aos="fade-up" data-aos-delay="500">
                    <i class="bi bi-envelope flex-shrink-0"></i>
                    <div>
                        <h3>Email Us</h3>
                        <p>{{ $company->email ?? 'contact@veridian-solutions.com' }}</p>
                    </div>
                </div><!-- End Info Item -->

                <div class="info-item d-flex" data-aos="fade-up" data-aos-delay="600">
                    <i class="bi bi-whatsapp flex-shrink-0"></i>
                    <div>
                        <h3>WhatsApp</h3>
                        <p><a href="https://wa.me/{{ $company->whatsapp ?? '6281234567890' }}" class="contact-btn">Chat
                                with Us</a></p>
                    </div>
                </div><!-- End Info Item -->

            </div>

            <div class="col-lg-8">
                <div class="contact-form-wrapper" data-aos="fade-up" data-aos-delay="200">
                    <h3>Send Us a Message</h3>
                    <p class="mb-4">Fill out the form below and we'll get back to you as soon as possible.</p>
                    <form action="{{ route('contact.store', ['locale' => $currentLocale]) ?? '#' }}" method="post"
                        class="php-email-form">
                        @csrf
                        <div class="row gy-4">

                            <div class="col-md-6">
                                <input type="text" name="name" class="form-control" placeholder="Your Name" required="">
                            </div>

                            <div class="col-md-6">
                                <input type="email" class="form-control" name="email" placeholder="Your Email"
                                    required="">
                            </div>

                            <div class="col-md-12">
                                <input type="text" class="form-control" name="subject" placeholder="Subject"
                                    required="">
                            </div>

                            <div class="col-md-12">
                                <select class="form-control" name="service" required="">
                                    <option value="">Select Service</option>
                                    @foreach($services as $service)
                                        @php $translation = $service->translate($currentLocale) ?? $service->translate(config('app.fallback_locale')); @endphp
                                        <option value="{{ $service->id_service }}">{{ $translation?->name }}</option>
                                    @endforeach
                                    <option value="other">Other</option>
                                </select>
                            </div>

                            <div class="col-md-12">
                                <textarea class="form-control" name="message" rows="6" placeholder="Message"
                                    required=""></textarea>
                            </div>

                            <div class="col-md-12 text-center">
                                <button type="submit" class="btn btn-primary-custom" id="submit-contact-form">
                                    <span class="spinner-border spinner-border-sm d-none" role="status"
                                        aria-hidden="true"></span>
                                    <span class="btn-text">Send Message</span>
                                </button>
                            </div>

                        </div>
                    </form>
                </div>
            </div><!-- End Contact Form -->

        </div>

    </div>

</section><!-- /Contact Section -->