<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('certifications', function (Blueprint $table) {
            $table->id('id_certification');
            $table->string('icon_class')->default('bi bi-patch-check');
            $table->integer('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->timestamps();
        });

        Schema::create('certification_translations', function (Blueprint $table) {
            $table->id('id_certification_translation');
            $table->unsignedBigInteger('id_certification');
            $table->string('locale')->index();
            $table->string('name')->nullable();
            $table->string('description')->nullable();

            $table->unique(['id_certification', 'locale']);
            $table->foreign('id_certification')
                ->references('id_certification')
                ->on('certifications')
                ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('certification_translations');
        Schema::dropIfExists('certifications');
    }
};
