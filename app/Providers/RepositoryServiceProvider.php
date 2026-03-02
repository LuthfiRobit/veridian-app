<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(
            \App\Interfaces\LanguageRepositoryInterface::class,
            \App\Repositories\LanguageRepository::class
        );
        $this->app->bind(
            \App\Interfaces\IpWhitelistRepositoryInterface::class,
            \App\Repositories\IpWhitelistRepository::class
        );
        $this->app->bind(
            \App\Interfaces\RoleRepositoryInterface::class,
            \App\Repositories\RoleRepository::class
        );
        $this->app->bind(
            \App\Interfaces\UserRepositoryInterface::class,
            \App\Repositories\UserRepository::class
        );
        $this->app->bind(
            \App\Interfaces\ServiceRepositoryInterface::class,
            \App\Repositories\ServiceRepository::class
        );
        $this->app->bind(
            \App\Interfaces\ProjectRepositoryInterface::class,
            \App\Repositories\ProjectRepository::class
        );
        $this->app->bind(
            \App\Interfaces\TestimonialRepositoryInterface::class,
            \App\Repositories\TestimonialRepository::class
        );
        $this->app->bind(
            \App\Interfaces\TeamMemberRepositoryInterface::class,
            \App\Repositories\TeamMemberRepository::class
        );
        $this->app->bind(
            \App\Interfaces\InquiryRepositoryInterface::class,
            \App\Repositories\InquiryRepository::class
        );
        $this->app->bind(
            \App\Interfaces\CoreValueRepositoryInterface::class,
            \App\Repositories\CoreValueRepository::class
        );
        $this->app->bind(
            \App\Interfaces\CompanyTimelineRepositoryInterface::class,
            \App\Repositories\CompanyTimelineRepository::class
        );
        $this->app->bind(
            \App\Interfaces\CertificationRepositoryInterface::class,
            \App\Repositories\CertificationRepository::class
        );
    }


    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
