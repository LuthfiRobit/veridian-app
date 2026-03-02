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
        Schema::create('blog_posts', function (Blueprint $table) {
            $table->id('id_blog_post');
            $table->unsignedBigInteger('id_blog_category')->nullable();
            $table->unsignedBigInteger('id_author')->nullable(); // references user
            $table->string('image_featured')->nullable();
            $table->enum('status', ['draft', 'published'])->default('draft');
            $table->timestamp('published_at')->nullable();
            $table->integer('reading_time')->default(0)->comment('Estimated reading time in minutes');
            $table->unsignedInteger('views_count')->default(0);
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->timestamps();

            $table->foreign('id_blog_category')->references('id_blog_category')->on('blog_categories')->onDelete('set null');
            $table->foreign('id_author')->references('id_user')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('blog_posts');
    }
};
