<!doctype html>
<html lang="en">

<head>
    <title>403 Forbidden | Veridian CMS</title>
    <!-- [Meta] -->
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="description" content="Access Forbidden" />
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
    <!-- [Error Page CSS] -->
    <link rel="stylesheet" href="{{ asset('company-dashboard/assets/css/error-costume.css') }}" />
</head>

<body>
    <div class="error-container">
        <!-- Left Side - Error Code -->
        <div class="error-left error-bg-403">
            <i class="ti ti-shield-lock error-icon-large error-icon-pulse"></i>
            <div class="error-code-large">403</div>
        </div>

        <!-- Right Side - Message -->
        <div class="error-right">
            <h1 class="error-title">Access Forbidden</h1>
            <p class="error-subtitle">
                You don't have permission to access this resource.
                Please contact your administrator if you believe this is an error.
            </p>
            <a href="{{ route('admin.dashboard') }}" class="btn-primary-custom btn-403">
                <i class="ti ti-arrow-left"></i>
                <span>Back to Dashboard</span>
            </a>

            <div class="error-info error-info-403">
                <div class="error-info-title">What You Can Do</div>
                <div class="error-info-text">
                    • Verify your account permissions<br>
                    • Contact your system administrator<br>
                    • Return to the dashboard and try again
                </div>
            </div>
        </div>
    </div>

    <!-- Required Js -->
    <script src="{{ asset('company-dashboard/assets/js/plugins/popper.min.js') }}"></script>
    <script src="{{ asset('company-dashboard/assets/js/plugins/bootstrap.min.js') }}"></script>
</body>

</html>