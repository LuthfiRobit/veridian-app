<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('testimonials', function (Blueprint $table) {
            $table->id('id_testimonial');
            $table->unsignedBigInteger('id_project')->nullable();

            // Un-translated fields
            $table->string('client_name');
            $table->string('avatar_path')->nullable();
            $table->tinyInteger('rating')->default(5);
            $table->boolean('is_active')->default(true);
            $table->integer('sort_order')->default(0);

            // Audit & Foreign Keys
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->timestamps();

            $table->foreign('id_project')->references('id_project')->on('projects')->onDelete('set null');
        });

        Schema::create('testimonial_translations', function (Blueprint $table) {
            $table->id('id_testimonial_translation');
            $table->unsignedBigInteger('id_testimonial');
            $table->string('locale')->index();

            // Translated fields
            $table->string('client_position')->nullable();
            $table->text('content')->nullable();

            $table->unique(['id_testimonial', 'locale']);
            $table->foreign('id_testimonial')->references('id_testimonial')->on('testimonials')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('testimonial_translations');
        Schema::dropIfExists('testimonials');
    }
};
