<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('ad_banners', function (Blueprint $table) {
            $table->id();

            // Bilingual
            $table->string('title_en')->nullable();
            $table->string('title_bn')->nullable();
            $table->text('description_en')->nullable();
            $table->text('description_bn')->nullable();

            // Media
            $table->string('image_path');
            $table->string('alt_text_en')->nullable();
            $table->string('alt_text_bn')->nullable();

            // Link
            $table->string('link')->nullable();
            $table->enum('target', ['_self', '_blank'])->default('_self');

            // Placement
            $table->enum('placement', ['home_top', 'home_middle', 'home_bottom', 'category_page', 'product_page'])->default('home_middle');

            // Scheduling
            $table->timestamp('start_date')->nullable();
            $table->timestamp('end_date')->nullable();

            // Status
            $table->integer('order')->default(0);
            $table->boolean('is_active')->default(true);

            $table->timestamps();

            // Indexes
            $table->index(['is_active', 'placement', 'order']);
            $table->index(['start_date', 'end_date']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ad_banners');
    }
};
