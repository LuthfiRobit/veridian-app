<!doctype html>
<html lang="id">

<head>
    <title>Login | Veridian CMS</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="description" content="Veridian Solutions CMS" />
    <meta name="author" content="Veridian Dev Team" />

    <link rel="icon" href="{{ asset('company-dashboard/assets/images/favicon.svg') }}" type="image/x-icon" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap"
        id="main-font-link" />
    <link rel="stylesheet" href="{{ asset('company-dashboard/assets/fonts/phosphor/duotone/style.css') }}" />
    <link rel="stylesheet" href="{{ asset('company-dashboard/assets/fonts/tabler-icons.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('company-dashboard/assets/fonts/feather.css') }}" />
    <link rel="stylesheet" href="{{ asset('company-dashboard/assets/fonts/fontawesome.css') }}" />
    <link rel="stylesheet" href="{{ asset('company-dashboard/assets/fonts/material.css') }}" />
    <link rel="stylesheet" href="{{ asset('company-dashboard/assets/css/style.css') }}" id="main-style-link" />
    <link rel="stylesheet" href="{{ asset('company-dashboard/assets/css/style-preset.css') }}" />
    <link rel="stylesheet" href="{{ asset('company-dashboard/assets/css/custom-style.css') }}" />

</head>

<body>
    <div class="loader-bg">
        <div class="loader-track">
            <div class="loader-fill"></div>
        </div>
    </div>

    <div class="auth-main">
        <div class="auth-wrapper v3">
            <div class="auth-form">
                <div class="card my-5">
                    <div class="card-body">
                        <a href="#" class="d-flex justify-content-center text-decoration-none">
                            <h3 class="m-0 fw-bold text-primary">VERIDIAN CMS</h3>
                        </a>
                        <div class="row">
                            <div class="d-flex justify-content-center">
                                <div class="auth-header">
                                    <h2 class="text-secondary mt-5"><b>Selamat Datang</b></h2>
                                    <p class="f-16 mt-2">Silahkan login untuk melanjutkan</p>
                                </div>
                            </div>
                        </div>

                        <h5 class="my-4 d-flex justify-content-center">Login dengan Email / Username</h5>

                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form action="{{ route('login.post') }}" method="POST">
                            @csrf
                            <div class="form-floating mb-3">
                                <input type="text" name="email" class="form-control" id="floatingInput"
                                    placeholder="Email address" value="{{ old('email') }}" required autofocus />
                                <label for="floatingInput">Email address</label>
                            </div>
                            <div class="form-floating mb-3">
                                <input type="password" name="password" class="form-control" id="floatingInput1"
                                    placeholder="Password" required />
                                <label for="floatingInput1">Password</label>
                            </div>
                            <div class="d-flex mt-1 justify-content-between">
                                <div class="form-check">
                                    <input class="form-check-input input-primary" type="checkbox" name="remember"
                                        id="customCheckc1" {{ old('remember') ? 'checked' : '' }} />
                                    <label class="form-check-label text-muted" for="customCheckc1">Ingat Saya</label>
                                </div>
                                <h5 class="text-secondary">Lupa Password?</h5>
                            </div>
                            <div class="d-grid mt-4">
                                <button type="submit" class="btn btn-secondary">Masuk</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="{{ asset('company-dashboard/assets/js/plugins/popper.min.js') }}"></script>
    <script src="{{ asset('company-dashboard/assets/js/plugins/simplebar.min.js') }}"></script>
    <script src="{{ asset('company-dashboard/assets/js/plugins/bootstrap.min.js') }}"></script>
    <script src="{{ asset('company-dashboard/assets/js/fonts/custom-font.js') }}"></script>
    <script src="{{ asset('company-dashboard/assets/js/script.js') }}"></script>
    <script src="{{ asset('company-dashboard/assets/js/theme.js') }}"></script>
    <script src="{{ asset('company-dashboard/assets/js/plugins/feather.min.js') }}"></script>

    <script>layout_change('light');</script>
    <script>layout_caption_change('true');</script>
    <script>layout_rtl_change('false');</script>
    <script>preset_change('preset-1');</script>

</body>

</html>