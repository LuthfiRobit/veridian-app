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
        Schema::create('blog_post_translations', function (Blueprint $table) {
            $table->id('id_blog_post_translation');
            $table->unsignedBigInteger('id_blog_post');
            $table->string('locale')->index();
            $table->string('slug')->unique();
            $table->string('title');
            $table->text('excerpt')->nullable();
            $table->longText('content')->nullable(); // HTML
            $table->string('meta_title')->nullable();
            $table->string('meta_desc')->nullable();
            $table->timestamps();

            $table->unique(['id_blog_post', 'locale']);
            $table->foreign('id_blog_post')->references('id_blog_post')->on('blog_posts')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('blog_post_translations');
    }
};
