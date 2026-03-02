<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('core_values', function (Blueprint $table) {
            $table->id('id_core_value');
            $table->string('icon_class')->default('bi bi-shield-check');
            $table->integer('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->timestamps();
        });

        Schema::create('core_value_translations', function (Blueprint $table) {
            $table->id('id_core_value_translation');
            $table->unsignedBigInteger('id_core_value');
            $table->string('locale')->index();
            $table->string('title')->nullable();
            $table->text('description')->nullable();

            $table->unique(['id_core_value', 'locale']);
            $table->foreign('id_core_value')
                ->references('id_core_value')
                ->on('core_values')
                ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('core_value_translations');
        Schema::dropIfExists('core_values');
    }
};
