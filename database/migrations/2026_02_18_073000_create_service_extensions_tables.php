<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        // 1. Service Benefits (Why Choose Us)
        Schema::create('service_benefits', function (Blueprint $table) {
            $table->id('id_service_benefit'); // Custom PK convention
            $table->unsignedBigInteger('id_service');
            $table->string('icon_class')->nullable();
            $table->integer('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->foreign('id_service')->references('id_service')->on('services')->onDelete('cascade');
        });

        Schema::create('service_benefit_translations', function (Blueprint $table) {
            $table->id('id_service_benefit_translation');
            $table->unsignedBigInteger('id_service_benefit');
            $table->string('locale')->index();
            $table->string('title');
            $table->text('description')->nullable();

            $table->unique(['id_service_benefit', 'locale']);
            $table->foreign('id_service_benefit')->references('id_service_benefit')->on('service_benefits')->onDelete('cascade');
        });

        // 2. Service Processes (Translation Process Steps)
        Schema::create('service_processes', function (Blueprint $table) {
            $table->id('id_service_process');
            $table->unsignedBigInteger('id_service');
            $table->integer('step_number');
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->foreign('id_service')->references('id_service')->on('services')->onDelete('cascade');
        });

        Schema::create('service_process_translations', function (Blueprint $table) {
            $table->id('id_service_process_translation');
            $table->unsignedBigInteger('id_service_process');
            $table->string('locale')->index();
            $table->string('title');
            $table->text('description')->nullable();

            $table->unique(['id_service_process', 'locale']);
            $table->foreign('id_service_process')->references('id_service_process')->on('service_processes')->onDelete('cascade');
        });

        // 3. Service Pricings (Pricing & Packages)
        Schema::create('service_pricings', function (Blueprint $table) {
            $table->id('id_service_pricing');
            $table->unsignedBigInteger('id_service');
            $table->boolean('is_featured')->default(false); // "Most Popular" badge
            $table->integer('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->foreign('id_service')->references('id_service')->on('services')->onDelete('cascade');
        });

        Schema::create('service_pricing_translations', function (Blueprint $table) {
            $table->id('id_service_pricing_translation');
            $table->unsignedBigInteger('id_service_pricing');
            $table->string('locale')->index();
            $table->string('name'); // "Standard", "Pro"
            $table->string('price_label')->nullable(); // "Starting at $0.12"
            $table->string('unit_label')->nullable(); // "/word"
            $table->json('features_list')->nullable(); // JSON array for bullet points

            $table->unique(['id_service_pricing', 'locale']);
            $table->foreign('id_service_pricing')->references('id_service_pricing')->on('service_pricings')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('service_pricing_translations');
        Schema::dropIfExists('service_pricings');
        Schema::dropIfExists('service_process_translations');
        Schema::dropIfExists('service_processes');
        Schema::dropIfExists('service_benefit_translations');
        Schema::dropIfExists('service_benefits');
    }
};
