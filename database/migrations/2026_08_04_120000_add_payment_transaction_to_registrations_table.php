<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('registrations', function (Blueprint $table) {
            $table->string('payment_transaction_id', 64)->nullable()->after('paid_at');
            $table->timestamp('payment_submitted_at')->nullable()->after('payment_transaction_id');
        });
    }

    public function down(): void
    {
        Schema::table('registrations', function (Blueprint $table) {
            $table->dropColumn(['payment_transaction_id', 'payment_submitted_at']);
        });
    }
};
