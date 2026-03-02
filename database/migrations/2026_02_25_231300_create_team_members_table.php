<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('team_members', function (Blueprint $table) {
            $table->id('id_team_member');
            $table->string('name');
            $table->string('photo_path')->nullable();
            $table->string('email')->nullable();
            $table->string('linkedin_url')->nullable();
            $table->string('twitter_url')->nullable();
            $table->string('github_url')->nullable();
            $table->boolean('is_active')->default(true);
            $table->integer('sort_order')->default(0);
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->timestamps();
        });

        Schema::create('team_member_translations', function (Blueprint $table) {
            $table->id('id_team_member_translation');
            $table->unsignedBigInteger('id_team_member');
            $table->string('locale', 10)->index();
            $table->string('position')->nullable();       // e.g. "Senior Developer"
            $table->string('department')->nullable();     // e.g. "Engineering"
            $table->text('bio')->nullable();              // Short biography
            $table->unique(['id_team_member', 'locale']);
            $table->foreign('id_team_member')
                ->references('id_team_member')
                ->on('team_members')
                ->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('team_member_translations');
        Schema::dropIfExists('team_members');
    }
};
