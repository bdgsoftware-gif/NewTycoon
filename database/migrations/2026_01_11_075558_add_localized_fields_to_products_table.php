<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations. Localized fields for Products
     */
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->string('name_en')->after('id');
            $table->string('name_bn')->nullable()->after('name_en');

            $table->text('short_description_en')->nullable();
            $table->text('short_description_bn')->nullable();

            $table->longText('description_en')->nullable();
            $table->longText('description_bn')->nullable();

            $table->string('meta_title_en')->nullable();
            $table->string('meta_title_bn')->nullable();

            $table->text('meta_description_en')->nullable();
            $table->text('meta_description_bn')->nullable();

            $table->index('name_en');
            $table->index('name_bn');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            //
        });
    }
};
