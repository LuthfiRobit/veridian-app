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
        Schema::create('blog_category_translations', function (Blueprint $table) {
            $table->id('id_blog_category_translation');
            $table->unsignedBigInteger('id_blog_category');
            $table->string('locale')->index();
            $table->string('name');
            $table->string('slug')->unique();

            $table->unique(['id_blog_category', 'locale']);
            $table->foreign('id_blog_category', 'fk_blog_cat_trans_blog_cat')->references('id_blog_category')->on('blog_categories')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('blog_category_translations');
    }
};
