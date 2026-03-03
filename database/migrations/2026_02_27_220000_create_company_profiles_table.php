<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('company_profiles', function (Blueprint $table) {
            $table->id('id_company_profile');

            // Stats
            $table->string('stat_projects')->default('500+');
            $table->string('stat_clients')->default('200+');
            $table->string('stat_retention')->default('95%');
            $table->string('stat_experience')->default('15+');
            $table->string('stat_languages')->default('50+');
            $table->string('stat_satisfaction')->default('98%');

            // Contact Info
            $table->string('address')->nullable();
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->string('whatsapp')->nullable();
            $table->string('google_maps_url')->nullable();

            // Social Media Links
            $table->string('social_facebook')->nullable();
            $table->string('social_instagram')->nullable();
            $table->string('social_twitter')->nullable();
            $table->string('social_linkedin')->nullable();
            $table->string('social_youtube')->nullable();
            $table->string('social_tiktok')->nullable();

            // Images
            $table->string('about_image_main')->nullable();
            $table->string('about_image_secondary')->nullable();

            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('company_profile_translations', function (Blueprint $table) {
            $table->id('id_company_profile_translation');
            $table->unsignedBigInteger('id_company_profile');
            $table->string('locale')->index();

            // Hero Section
            $table->string('hero_badge')->nullable();
            $table->string('hero_title')->nullable();
            $table->text('hero_description')->nullable();

            // About Section
            $table->string('about_title')->nullable();
            $table->string('about_subtitle')->nullable();
            $table->text('about_lead_text')->nullable();
            $table->text('about_description')->nullable();

            // Mission & Vision
            $table->string('mission_title')->nullable();
            $table->text('mission_description')->nullable();
            $table->string('vision_title')->nullable();
            $table->text('vision_description')->nullable();

            // Footer
            $table->text('footer_description')->nullable();

            $table->unique(['id_company_profile', 'locale']);
            $table->foreign('id_company_profile')
                ->references('id_company_profile')
                ->on('company_profiles')
                ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('company_profile_translations');
        Schema::dropIfExists('company_profiles');
    }
};
