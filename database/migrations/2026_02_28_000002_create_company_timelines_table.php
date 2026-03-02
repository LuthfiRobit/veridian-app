<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('company_timelines', function (Blueprint $table) {
            $table->id('id_company_timeline');
            $table->string('year', 10);
            $table->string('icon_class')->default('bi bi-flag');
            $table->integer('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->timestamps();
        });

        Schema::create('company_timeline_translations', function (Blueprint $table) {
            $table->id('id_company_timeline_translation');
            $table->unsignedBigInteger('id_company_timeline');
            $table->string('locale')->index();
            $table->string('title')->nullable();
            $table->text('description')->nullable();

            $table->unique(['id_company_timeline', 'locale']);
            $table->foreign('id_company_timeline')
                ->references('id_company_timeline')
                ->on('company_timelines')
                ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('company_timeline_translations');
        Schema::dropIfExists('company_timelines');
    }
};
