<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('reviews', function (Blueprint $table) {
            $table->id();

            // FK relations
            $table->unsignedBigInteger('product_id');
            $table->unsignedBigInteger('user_id');

            // Review content
            $table->unsignedTinyInteger('rating'); // 1–5
            $table->string('title')->nullable();
            $table->text('comment')->nullable();

            // Status
            $table->boolean('is_approved')->default(false);

            $table->timestamps();

            // Foreign keys
            $table->foreign('product_id')
                ->references('id')->on('products')
                ->onDelete('cascade');

            $table->foreign('user_id')
                ->references('id')->on('users')
                ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reviews');
    }
};
