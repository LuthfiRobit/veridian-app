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
        Schema::create('project_category_translations', function (Blueprint $table) {
            $table->id('id_project_category_translation');
            $table->unsignedBigInteger('id_project_category');
            $table->string('locale')->index();
            $table->string('name');
            $table->string('slug')->unique();

            $table->unique(['id_project_category', 'locale']);
            $table->foreign('id_project_category', 'fk_proj_cat_trans_proj_cat')->references('id_project_category')->on('project_categories')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('project_category_translations');
    }
};
