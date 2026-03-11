<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Frontend\AboutController;
use App\Http\Controllers\Frontend\ServiceController;
use App\Http\Controllers\Frontend\PortfolioController;
use App\Http\Controllers\Frontend\BlogController;
use App\Http\Controllers\Frontend\ContactController;

/*
|--------------------------------------------------------------------------
| Root Redirect
|--------------------------------------------------------------------------
| Redirect / to /{defaultLocale} using the default language from DB.
*/
Route::get('/', fn() => redirect('/' . \App\Models\Language::getDefaultCode()));

/*
|--------------------------------------------------------------------------
| Landing Page Routes (public, no auth)
|--------------------------------------------------------------------------
| All public-facing routes are prefixed with {locale} (2-letter code).
| The 'localization' middleware validates the locale and sets app locale.
*/
Route::prefix('{locale}')
    ->where(['locale' => '[a-z]{2}'])
    ->middleware('localization')
    ->group(function () {
        Route::get('/', [HomeController::class, 'index'])->name('home');
        Route::get('/about', [AboutController::class, 'index'])->name('about');
        Route::get('/about/team', [AboutController::class, 'team'])->name('about.team');
        Route::get('/services/{slug}', [ServiceController::class, 'show'])->name('services.show');
        Route::get('/portfolio/{slug}', [PortfolioController::class, 'show'])->name('portfolio.show');
        Route::get('/blog', [BlogController::class, 'index'])->name('blog.index');
        Route::get('/blog/{slug}', [BlogController::class, 'show'])->name('blog.show');
    });

/*
|--------------------------------------------------------------------------
| Contact Form (AJAX POST — excluded from cache)
|--------------------------------------------------------------------------
*/
Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');

// Authentication Routes
Route::get('login', [App\Http\Controllers\Backend\AuthController::class, 'showLoginForm'])->name('login');
Route::post('login', [App\Http\Controllers\Backend\AuthController::class, 'login'])->name('login.post');
Route::post('logout', [App\Http\Controllers\Backend\AuthController::class, 'logout'])->name('logout');

// Admin Routes
Route::middleware(['auth', 'ip.whitelist'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [App\Http\Controllers\Backend\DashboardController::class, 'index'])
        ->middleware('permission:view dashboard')
        ->name('dashboard');

    // Settings
    Route::middleware(['permission:manage settings'])->group(function () {
        Route::post('languages/{language}/set-default', [App\Http\Controllers\Backend\LanguageController::class, 'setDefault'])->name('languages.set-default');
        Route::resource('languages', App\Http\Controllers\Backend\LanguageController::class);
        Route::resource('ip-whitelists', App\Http\Controllers\Backend\IpWhitelistController::class);
    });

    // RBAC
    Route::resource('roles', App\Http\Controllers\Backend\RoleController::class)->middleware('permission:manage roles');
    Route::post('users/{user}/reset-password', [App\Http\Controllers\Backend\UserController::class, 'resetPassword'])->name('users.reset-password')->middleware('permission:manage users');
    Route::resource('users', App\Http\Controllers\Backend\UserController::class)->middleware('permission:manage users');

    // Content Management
    Route::resource('services', App\Http\Controllers\Backend\ServiceController::class)->middleware('permission:manage content');

    // Service Child Modules
    Route::prefix('services/{service}')->name('services.')->middleware('permission:manage content')->group(function () {
        Route::resource('benefits', App\Http\Controllers\Backend\ServiceBenefitController::class);
        Route::resource('processes', App\Http\Controllers\Backend\ServiceProcessController::class);
        Route::resource('pricings', App\Http\Controllers\Backend\ServicePricingController::class);
    });

    // Project Categories
    Route::resource('project-categories', App\Http\Controllers\Backend\ProjectCategoryController::class)->middleware('permission:manage content');

    // Projects
    Route::resource('projects', App\Http\Controllers\Backend\ProjectController::class)->middleware('permission:manage content');

    // Project Child Modules
    Route::prefix('projects/{project}')->name('projects.')->middleware('permission:manage content')->group(function () {
        Route::resource('images', App\Http\Controllers\Backend\ProjectImageController::class);
        Route::resource('stats', App\Http\Controllers\Backend\ProjectStatController::class);
        Route::resource('features', App\Http\Controllers\Backend\ProjectFeatureController::class);
    });

    // Blog Module
    Route::resource('blog-categories', App\Http\Controllers\Backend\BlogCategoryController::class)->middleware('permission:manage content');
    Route::resource('blog-posts', App\Http\Controllers\Backend\BlogPostController::class)->middleware('permission:manage content');

    // Testimonials (Module 6.A)
    Route::resource('testimonials', \App\Http\Controllers\Backend\TestimonialController::class)->except(['show'])->middleware('permission:manage content');

    // Our Team (Module 6.B)
    Route::resource('team-members', \App\Http\Controllers\Backend\TeamMemberController::class)->except(['show'])->middleware('permission:manage content');

    // Contact & Inquiries (Module 6.C)
    Route::resource('inquiries', \App\Http\Controllers\Backend\InquiryController::class)->only(['index', 'show', 'destroy'])->middleware('permission:manage content');

    // Company Profile (Singleton)
    Route::middleware(['permission:manage content'])->prefix('company-profile')->name('company-profile.')->group(function () {
        Route::get('/', [\App\Http\Controllers\Backend\CompanyProfileController::class, 'edit'])->name('edit');
        Route::put('/', [\App\Http\Controllers\Backend\CompanyProfileController::class, 'update'])->name('update');
    });

    // Core Values (CRUD)
    Route::resource('core-values', \App\Http\Controllers\Backend\CoreValueController::class)->except(['show'])->middleware('permission:manage content');

    // Company Timeline (CRUD)
    Route::resource('company-timelines', \App\Http\Controllers\Backend\CompanyTimelineController::class)->except(['show'])->middleware('permission:manage content');

    // Certifications (CRUD)
    Route::resource('certifications', \App\Http\Controllers\Backend\CertificationController::class)->except(['show'])->middleware('permission:manage content');

    // Profile Management
    Route::get('profile', [App\Http\Controllers\Backend\ProfileController::class, 'index'])->name('profile.index');
    Route::put('profile', [App\Http\Controllers\Backend\ProfileController::class, 'update'])->name('profile.update');
});
