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
        // 1. Project Images (Gallery + Hero)
        Schema::create('project_images', function (Blueprint $table) {
            $table->id('id_project_image');
            $table->foreignId('project_id')->constrained('projects', 'id_project')->onDelete('cascade');
            $table->string('image_path');
            $table->boolean('is_hero')->default(false);
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });

        Schema::create('project_image_translations', function (Blueprint $table) {
            $table->id('id_project_image_translation');
            $table->foreignId('id_project_image')->constrained('project_images', 'id_project_image')->onDelete('cascade');
            $table->string('locale')->index();
            $table->string('caption')->nullable();
            $table->unique(['id_project_image', 'locale'], 'proj_img_trans_unique');
        });

        // 2. Project Stats (Ribbon)
        Schema::create('project_stats', function (Blueprint $table) {
            $table->id('id_project_stat');
            $table->foreignId('project_id')->constrained('projects', 'id_project')->onDelete('cascade');
            $table->string('value');
            $table->string('icon_class')->nullable();
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });

        Schema::create('project_stat_translations', function (Blueprint $table) {
            $table->id('id_project_stat_translation');
            $table->foreignId('id_project_stat')->constrained('project_stats', 'id_project_stat')->onDelete('cascade');
            $table->string('locale')->index();
            $table->string('label');
            $table->unique(['id_project_stat', 'locale'], 'proj_stat_trans_unique');
        });

        // 3. Project Features (Sidebar)
        Schema::create('project_features', function (Blueprint $table) {
            $table->id('id_project_feature');
            $table->foreignId('project_id')->constrained('projects', 'id_project')->onDelete('cascade');
            $table->string('icon_class')->nullable();
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });

        Schema::create('project_feature_translations', function (Blueprint $table) {
            $table->id('id_project_feature_translation');
            $table->foreignId('id_project_feature')->constrained('project_features', 'id_project_feature')->onDelete('cascade');
            $table->string('locale')->index();
            $table->string('title');
            $table->string('description')->nullable();
            $table->unique(['id_project_feature', 'locale'], 'proj_feat_trans_unique');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('project_feature_translations');
        Schema::dropIfExists('project_features');
        Schema::dropIfExists('project_stat_translations');
        Schema::dropIfExists('project_stats');
        Schema::dropIfExists('project_image_translations');
        Schema::dropIfExists('project_images');
    }
};
