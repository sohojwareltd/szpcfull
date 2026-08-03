<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('message_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('message_campaign_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('registration_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('team_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('team_member_id')->nullable()->constrained()->nullOnDelete();
            $table->string('message_type', 32)->default('campaign');
            $table->string('recipient_type', 32);
            $table->string('recipient_phone', 32);
            $table->string('recipient_name');
            $table->text('message_body');
            $table->text('template_body')->nullable();
            $table->string('status', 32);
            $table->text('error_message')->nullable();
            $table->text('provider_response')->nullable();
            $table->foreignId('sent_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('sent_at')->nullable();
            $table->timestamps();

            $table->index(['message_campaign_id', 'status']);
            $table->index(['registration_id', 'sent_at']);
            $table->index('sent_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('message_logs');
    }
};
