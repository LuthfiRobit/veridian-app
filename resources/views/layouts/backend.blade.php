<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <title>@yield('title', 'Dashboard') | Veridian CMS</title>
    <!-- [Meta] -->
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="description" content="Veridian Solutions Content Management System" />
    <meta name="author" content="Veridian Dev Team" />
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- [Favicon] icon -->
    <link rel="icon" href="{{ asset('company-dashboard/assets/images/favicon.svg') }}" type="image/x-icon" />
    <!-- [Google Font] Family -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap"
        id="main-font-link" />
    <!-- [Tabler Icons] -->
    <link rel="stylesheet" href="{{ asset('company-dashboard/assets/fonts/tabler-icons.min.css') }}" />
    <!-- [Feather Icons] -->
    <link rel="stylesheet" href="{{ asset('company-dashboard/assets/fonts/feather.css') }}" />
    <!-- [Font Awesome Icons] -->
    <link rel="stylesheet" href="{{ asset('company-dashboard/assets/fonts/fontawesome.css') }}" />
    <!-- [Material Icons] -->
    <link rel="stylesheet" href="{{ asset('company-dashboard/assets/fonts/material.css') }}" />
    <!-- [Template CSS Files] -->
    <link rel="stylesheet" href="{{ asset('company-dashboard/assets/css/style.css') }}" id="main-style-link" />
    <link rel="stylesheet" href="{{ asset('company-dashboard/assets/css/style-preset.css') }}" />
    <!-- [Custom CSS] -->
    <!-- [Custom CSS] -->
    <link rel="stylesheet" href="{{ asset('company-dashboard/assets/css/custom-style.css') }}" />
    <!-- Tom Select Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/tom-select@2.3.1/dist/css/tom-select.bootstrap5.min.css" rel="stylesheet">
    <!-- Flag Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/flag-icon-css/3.5.0/css/flag-icon.min.css">
    <!-- Toastr -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <style>
        /* Tom Select Bootstrap 5 Tweaks */
        .ts-wrapper.form-control {
            padding: 0 !important;
            border: 1px solid #ced4da !important;
        }

        .ts-control {
            padding: 0.5625rem 0.75rem;
            border: 1px solid #ced4da;
            border-radius: 0.375rem;
        }

        .ts-control.focus {
            border-color: #86b7fe;
            box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.25);
        }

        /* Dropdown Z-Index for Modal */
        .ts-dropdown {
            z-index: 1056 !important;
            /* Higher than Bootstrap Modal (1055) */
        }

        /* Flex Alignment for Icons */
        .ts-dropdown .option,
        .ts-control .item {
            display: flex;
            align-items: center;
        }

        .ts-dropdown .option i,
        .ts-control .item i {
            margin-right: 10px;
            font-size: 1.2em;
        }
    </style>

    @stack('styles')
</head>

<body>
    <!-- [ Pre-loader ] start -->
    <div class="loader-bg">
        <div class="loader-track">
            <div class="loader-fill"></div>
        </div>
    </div>
    <!-- [ Pre-loader ] End -->

    <!-- [ Sidebar Menu ] start -->
    <nav class="pc-sidebar">
        <div class="navbar-wrapper">
            <div class="m-header">
                <a href="{{ route('admin.dashboard') }}" class="b-brand text-primary">
                    <h3 class="m-0 fw-bold text-primary">Veridian CMS</h3>
                </a>
            </div>
            <div class="navbar-content">
                <ul class="pc-navbar">
                    <li class="pc-item pc-caption"><label>Overview</label><i class="ti ti-dashboard"></i></li>
                    <li class="pc-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                        <a href="{{ route('admin.dashboard') }}" class="pc-link">
                            <span class="pc-micon"><i class="ti ti-dashboard"></i></span>
                            <span class="pc-mtext">Dashboard</span>
                        </a>
                    </li>

                    <li class="pc-item pc-caption"><label>Content Management</label><i class="ti ti-layout-grid"></i>
                    </li>

                    {{-- Services --}}
                    <li class="pc-item {{ request()->routeIs('admin.services.*') ? 'active' : '' }}">
                        <a href="{{ route('admin.services.index') }}" class="pc-link">
                            <span class="pc-micon"><i class="ti ti-briefcase"></i></span>
                            <span class="pc-mtext">Services</span>
                        </a>
                    </li>

                    {{-- Projects --}}
                    <li
                        class="pc-item pc-hasmenu {{ request()->routeIs('admin.project-categories.*') || request()->routeIs('admin.projects.*') ? 'active pc-trigger' : '' }}">
                        <a href="#!" class="pc-link">
                            <span class="pc-micon"><i class="ti ti-presentation"></i></span>
                            <span class="pc-mtext">Portfolio</span>
                            <span class="pc-arrow"><i class="ti ti-chevron-right"></i></span>
                        </a>
                        <ul class="pc-submenu">
                            <li class="pc-item {{ request()->routeIs('admin.project-categories.*') ? 'active' : '' }}">
                                <a class="pc-link" href="{{ route('admin.project-categories.index') }}">Categories</a>
                            </li>
                            <li class="pc-item {{ request()->routeIs('admin.projects.*') ? 'active' : '' }}">
                                <a class="pc-link" href="{{ route('admin.projects.index') }}">Projects</a>
                            </li>
                        </ul>
                    </li>

                    {{-- Testimonials --}}
                    <li class="pc-item {{ request()->routeIs('admin.testimonials.*') ? 'active' : '' }}">
                        <a href="{{ route('admin.testimonials.index') }}" class="pc-link">
                            <span class="pc-micon"><i class="ti ti-heart"></i></span>
                            <span class="pc-mtext">Testimonials</span>
                        </a>
                    </li>

                    {{-- Our Team --}}
                    <li class="pc-item {{ request()->routeIs('admin.team-members.*') ? 'active' : '' }}">
                        <a href="{{ route('admin.team-members.index') }}" class="pc-link">
                            <span class="pc-micon"><i class="ti ti-users"></i></span>
                            <span class="pc-mtext">Our Team</span>
                        </a>
                    </li>

                    {{-- Inquiries --}}
                    <li class="pc-item {{ request()->routeIs('admin.inquiries.*') ? 'active' : '' }}">
                        <a href="{{ route('admin.inquiries.index') }}" class="pc-link">
                            <span class="pc-micon"><i class="ti ti-mail"></i></span>
                            <span class="pc-mtext">Inquiries</span>
                        </a>
                    </li>

                    {{-- Company --}}
                    <li
                        class="pc-item pc-hasmenu {{ request()->routeIs('admin.company-profile.*') || request()->routeIs('admin.core-values.*') || request()->routeIs('admin.company-timelines.*') || request()->routeIs('admin.certifications.*') ? 'active pc-trigger' : '' }}">
                        <a href="#!" class="pc-link">
                            <span class="pc-micon"><i class="ti ti-building"></i></span>
                            <span class="pc-mtext">Company</span>
                            <span class="pc-arrow"><i class="ti ti-chevron-right"></i></span>
                        </a>
                        <ul class="pc-submenu">
                            <li class="pc-item {{ request()->routeIs('admin.company-profile.*') ? 'active' : '' }}">
                                <a class="pc-link" href="{{ route('admin.company-profile.edit') }}">Profile</a>
                            </li>
                            <li class="pc-item {{ request()->routeIs('admin.core-values.*') ? 'active' : '' }}">
                                <a class="pc-link" href="{{ route('admin.core-values.index') }}">Core Values</a>
                            </li>
                            <li class="pc-item {{ request()->routeIs('admin.company-timelines.*') ? 'active' : '' }}">
                                <a class="pc-link" href="{{ route('admin.company-timelines.index') }}">Timeline</a>
                            </li>
                            <li class="pc-item {{ request()->routeIs('admin.certifications.*') ? 'active' : '' }}">
                                <a class="pc-link" href="{{ route('admin.certifications.index') }}">Certifications</a>
                            </li>
                        </ul>
                    </li>

                    {{-- Blog --}}
                    <li
                        class="pc-item pc-hasmenu {{ request()->routeIs('admin.blog-categories.*') || request()->routeIs('admin.blog-posts.*') ? 'active pc-trigger' : '' }}">
                        <a href="#!" class="pc-link">
                            <span class="pc-micon"><i class="ti ti-book"></i></span>
                            <span class="pc-mtext">Blog</span>
                            <span class="pc-arrow"><i class="ti ti-chevron-right"></i></span>
                        </a>
                        <ul class="pc-submenu">
                            <li class="pc-item {{ request()->routeIs('admin.blog-categories.*') ? 'active' : '' }}">
                                <a class="pc-link" href="{{ route('admin.blog-categories.index') }}">Categories</a>
                            </li>
                            <li class="pc-item {{ request()->routeIs('admin.blog-posts.*') ? 'active' : '' }}">
                                <a class="pc-link" href="{{ route('admin.blog-posts.index') }}">Posts</a>
                            </li>
                        </ul>
                    </li>

                    <li class="pc-item pc-caption"><label>System Settings</label><i class="ti ti-settings"></i></li>
                    <li class="pc-item pc-hasmenu">
                        <a href="#!" class="pc-link">
                            <span class="pc-micon"><i class="ti ti-settings"></i></span>
                            <span class="pc-mtext">Global Settings</span>
                            <span class="pc-arrow"><i class="ti ti-chevron-right"></i></span>
                        </a>
                        <ul class="pc-submenu">
                            <li class="pc-item"><a class="pc-link"
                                    href="{{ route('admin.languages.index') }}">Languages</a></li>
                            <li class="pc-item"><a class="pc-link" href="{{ route('admin.ip-whitelists.index') }}">IP
                                    Whitelists</a></li>
                        </ul>
                    </li>
                    <li class="pc-item pc-hasmenu">
                        <a href="#!" class="pc-link">
                            <span class="pc-micon"><i class="ti ti-lock"></i></span>
                            <span class="pc-mtext">RBAC</span>
                            <span class="pc-arrow"><i class="ti ti-chevron-right"></i></span>
                        </a>
                        <ul class="pc-submenu">
                            <li class="pc-item"><a class="pc-link" href="{{ route('admin.roles.index') }}">Roles</a>
                            </li>
                            <li class="pc-item"><a class="pc-link" href="{{ route('admin.users.index') }}">Users</a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <!-- [ Sidebar Menu ] end -->

    <!-- [ Header Topbar ] start -->
    <header class="pc-header">
        <div class="header-wrapper">
            <div class="me-auto pc-mob-drp">
                <ul class="list-unstyled">
                    <li class="pc-h-item header-mobile-collapse">
                        <a href="#" class="pc-head-link head-link-secondary ms-0" id="sidebar-hide">
                            <i class="ti ti-menu-2"></i>
                        </a>
                    </li>
                    <li class="pc-h-item pc-sidebar-popup">
                        <a href="#" class="pc-head-link head-link-secondary ms-0" id="mobile-collapse">
                            <i class="ti ti-menu-2"></i>
                        </a>
                    </li>
                </ul>
            </div>

            <div class="ms-auto">
                <ul class="list-unstyled">
                    <li class="dropdown pc-h-item header-user-profile">
                        <a class="pc-head-link head-link-primary dropdown-toggle arrow-none me-0"
                            data-bs-toggle="dropdown" href="#" role="button" aria-haspopup="false"
                            aria-expanded="false">
                            <img src="{{ asset('company-dashboard/assets/images/user/avatar-2.jpg') }}" alt="user-image"
                                class="user-avtar" />
                            <span><i class="ti ti-settings"></i></span>
                        </a>
                        <div class="dropdown-menu dropdown-user-profile dropdown-menu-end pc-h-dropdown">
                            <div class="dropdown-header">
                                <h4>
                                    Hello, <span class="small text-muted">{{ Auth::user()->name ?? 'Guest' }}</span>
                                </h4>
                                <hr />
                                <a href="#!" class="dropdown-item">
                                    <i class="ti ti-user"></i>
                                    <span>My Profile</span>
                                </a>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="dropdown-item">
                                        <i class="ti ti-logout"></i>
                                        <span>Logout</span>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </header>
    <!-- [ Header ] end -->

    <!-- [ Main Content ] start -->
    <div class="pc-container">
        <div class="pc-content">
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            @if(session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif

            @yield('content')
        </div>
    </div>
    <!-- [ Main Content ] end -->

    <footer class="pc-footer">
        <div class="footer-wrapper container-fluid">
            <div class="row">
                <div class="col-sm-6 my-1">
                    <p class="m-0">Veridian Solutions CMS &#9829; Created by Dev Team</p>
                </div>
            </div>
        </div>
    </footer>

    <!-- Required Js -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="{{ asset('company-dashboard/assets/js/plugins/popper.min.js') }}"></script>
    <script src="{{ asset('company-dashboard/assets/js/plugins/simplebar.min.js') }}"></script>
    <script src="{{ asset('company-dashboard/assets/js/plugins/bootstrap.min.js') }}"></script>
    <script src="{{ asset('company-dashboard/assets/js/fonts/custom-font.js') }}"></script>
    <script src="{{ asset('company-dashboard/assets/js/script.js') }}"></script>
    <script src="{{ asset('company-dashboard/assets/js/theme.js') }}"></script>
    <script src="{{ asset('company-dashboard/assets/js/plugins/feather.min.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>layout_change('light');</script>
    <script>layout_caption_change('true');</script>
    <script>layout_rtl_change('false');</script>
    <script>preset_change('preset-1');</script>

    <script>
        // Global Toastr Configuration
        toastr.options = {
            "closeButton": true,
            "progressBar": true,
            "positionClass": "toast-top-right",
            "timeOut": "5000"
        };

        @if(session('success'))
            toastr.success("{{ session('success') }}");
        @endif

        @if(session('error'))
            toastr.error("{{ session('error') }}");
        @endif

        @if($errors->any())
            @foreach($errors->all() as $error)
                toastr.error("{{ $error }}");
            @endforeach
        @endif
    </script>

    @stack('scripts')
</body>

</html>