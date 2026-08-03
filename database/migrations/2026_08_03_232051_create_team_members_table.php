<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('team_members', function (Blueprint $table) {
            $table->id();
            $table->foreignId('team_id')->constrained()->cascadeOnDelete();
            $table->foreignId('registration_member_id')->nullable()->constrained()->nullOnDelete();
            $table->string('full_name');
            $table->string('phone', 32)->nullable();
            $table->string('email')->nullable();
            $table->string('tshirt_size', 8)->nullable();
            $table->boolean('is_leader')->default(false);
            $table->unsignedTinyInteger('sort_order')->default(1);
            $table->timestamps();

            $table->index(['team_id', 'is_leader']);
        });

        Schema::table('teams', function (Blueprint $table) {
            $table->foreign('leader_id')->references('id')->on('team_members')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('teams', function (Blueprint $table) {
            $table->dropForeign(['leader_id']);
        });

        Schema::dropIfExists('team_members');
    }
};
