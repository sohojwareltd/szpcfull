<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('registrations', function (Blueprint $table) {
            $table->id();
            $table->string('reference_code', 16)->unique();
            $table->string('contest_type', 32);
            $table->string('team_name')->nullable();
            $table->string('university')->nullable();
            $table->string('institution_name')->nullable();
            $table->string('district')->nullable();
            $table->string('category')->nullable();
            $table->string('full_name')->nullable();
            $table->string('email')->nullable();
            $table->string('phone', 32);
            $table->text('address')->nullable();
            $table->boolean('is_contacted')->default(false);
            $table->timestamp('contacted_at')->nullable();
            $table->boolean('is_paid')->default(false);
            $table->timestamp('paid_at')->nullable();
            $table->boolean('is_confirmed')->default(false);
            $table->timestamp('confirmed_at')->nullable();
            $table->text('admin_notes')->nullable();
            $table->timestamp('last_sms_at')->nullable();
            $table->timestamps();

            $table->index(['contest_type', 'is_paid', 'is_confirmed']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('registrations');
    }
};
