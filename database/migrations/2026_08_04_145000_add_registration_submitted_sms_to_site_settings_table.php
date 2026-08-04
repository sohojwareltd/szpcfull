<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('site_settings', function (Blueprint $table) {
            $table->boolean('registration_submitted_sms_enabled')->default(true)->after('analytics_measurement_id');
            $table->text('registration_submitted_sms_template')->nullable()->after('registration_submitted_sms_enabled');
        });
    }

    public function down(): void
    {
        Schema::table('site_settings', function (Blueprint $table) {
            $table->dropColumn([
                'registration_submitted_sms_enabled',
                'registration_submitted_sms_template',
            ]);
        });
    }
};
