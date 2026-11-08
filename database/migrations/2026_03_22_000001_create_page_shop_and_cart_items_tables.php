<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('page_shop_items', function (Blueprint $table) {
            $table->id();
            $table->string('page_title')->nullable();
            $table->string('seo_title')->nullable();
            $table->text('seo_meta_description')->nullable();
            $table->timestamps();
        });

        Schema::create('page_cart_items', function (Blueprint $table) {
            $table->id();
            $table->string('cart_page_title')->nullable();
            $table->string('checkout_page_title')->nullable();
            $table->string('seo_title')->nullable();
            $table->text('seo_meta_description')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('page_shop_items');
        Schema::dropIfExists('page_cart_items');
    }
};
