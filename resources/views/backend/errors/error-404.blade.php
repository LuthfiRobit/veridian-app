<!doctype html>
<html lang="en">

<head>
    <title>404 Not Found | Veridian CMS</title>
    <!-- [Meta] -->
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="description" content="Page Not Found" />
    <meta name="author" content="Veridian Dev Team" />

    <!-- [Favicon] icon -->
    <link rel="icon" href="../assets/images/favicon.svg" type="image/x-icon" />
    <!-- [Google Font] Family -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700;900&display=swap"
        id="main-font-link" />
    <!-- [Tabler Icons] -->
    <link rel="stylesheet" href="../assets/fonts/tabler-icons.min.css" />
    <!-- [Template CSS Files] -->
    <link rel="stylesheet" href="../assets/css/style.css" id="main-style-link" />
    <link rel="stylesheet" href="../assets/css/style-preset.css" />
    <!-- [Error Page CSS] -->
    <link rel="stylesheet" href="../assets/css/error-costume.css" />
</head>

<body>
    <div class="error-container">
        <!-- Left Side - Error Code -->
        <div class="error-left error-bg-404">
            <i class="ti ti-file-x error-icon-large error-icon-float"></i>
            <div class="error-code-large">404</div>
        </div>

        <!-- Right Side - Message -->
        <div class="error-right">
            <h1 class="error-title">Page Not Found</h1>
            <p class="error-subtitle">
                The page you're looking for doesn't exist or has been moved.
                Please check the URL or navigate back to the dashboard.
            </p>
            <a href="index.html" class="btn-primary-custom btn-404">
                <i class="ti ti-arrow-left"></i>
                <span>Back to Dashboard</span>
            </a>

            <div class="error-info error-info-404">
                <div class="error-info-title">Common Causes</div>
                <div class="error-info-text">
                    • The page may have been removed or renamed<br>
                    • The URL might be typed incorrectly<br>
                    • The link you followed may be outdated
                </div>
            </div>
        </div>
    </div>

    <!-- Required Js -->
    <script src="../assets/js/plugins/popper.min.js"></script>
    <script src="../assets/js/plugins/bootstrap.min.js"></script>
</body>

</html>