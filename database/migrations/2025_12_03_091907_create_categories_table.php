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
        Schema::create('categories', function (Blueprint $table) {
            $table->id();

            // $table->string('name');
            $table->string('slug')->unique();
            // $table->text('description')->nullable();
            $table->string('image')->nullable();

            $table->unsignedBigInteger('parent_id')->nullable();

            // Navigation-specific
            $table->boolean('show_in_nav')->default(false);
            $table->integer('nav_order')->default(0);

            // General ordering
            $table->integer('order')->default(0);

            // Marketing / Homepage
            $table->boolean('is_featured')->default(false);

            // System
            $table->boolean('is_active')->default(true);

            // SEO
            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();
            $table->string('meta_keywords')->nullable();

            $table->timestamps();
            $table->softDeletes();

            $table->foreign('parent_id')
                ->references('id')
                ->on('categories')
                ->onDelete('cascade');

            $table->index('is_active');
            $table->index('slug');
            $table->index('parent_id');
            $table->index(['is_active', 'parent_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('categories');
    }
};
