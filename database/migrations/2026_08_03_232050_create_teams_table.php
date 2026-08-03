<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('teams', function (Blueprint $table) {
            $table->id();
            $table->foreignId('registration_id')->unique()->constrained()->cascadeOnDelete();
            $table->string('contest_type', 32);
            $table->string('name');
            $table->foreignId('leader_id')->nullable();
            $table->timestamps();

            $table->index('contest_type');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('teams');
    }
};
