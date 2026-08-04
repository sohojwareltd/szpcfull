<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('site_settings', function (Blueprint $table) {
            $table->id();
            $table->string('site_name')->default('SZPC \'26');
            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();
            $table->string('meta_keywords')->nullable();
            $table->string('og_title')->nullable();
            $table->text('og_description')->nullable();
            $table->string('og_image')->nullable();
            $table->string('favicon')->nullable();
            $table->string('theme_color', 16)->default('#1a1d24');
            $table->string('twitter_site')->nullable();
            $table->boolean('robots_index')->default(true);
            $table->string('google_site_verification')->nullable();
            $table->string('contact_email')->nullable();
            $table->string('contact_phone')->nullable();
            $table->text('contact_address')->nullable();
            $table->string('register_meta_title')->nullable();
            $table->text('register_meta_description')->nullable();
            $table->string('success_meta_title')->nullable();
            $table->text('success_meta_description')->nullable();
            $table->string('analytics_measurement_id')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('site_settings');
    }
};
