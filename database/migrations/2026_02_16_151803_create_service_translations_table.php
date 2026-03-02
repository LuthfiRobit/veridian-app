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
        Schema::create('service_translations', function (Blueprint $table) {
            $table->id('id_service_translation');
            $table->unsignedBigInteger('id_service');
            $table->string('locale')->index();
            $table->string('slug');
            $table->string('name');
            $table->text('short_desc')->nullable();
            $table->text('content')->nullable(); // HTML
            $table->string('meta_title')->nullable();
            $table->string('meta_desc')->nullable();
            $table->timestamps();

            $table->unique(['id_service', 'locale']);
            $table->unique(['slug', 'locale']);
            $table->foreign('id_service')->references('id_service')->on('services')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('service_translations');
    }
};
