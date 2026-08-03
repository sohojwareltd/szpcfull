<?php

use App\Models\Registration;
use App\Models\RegistrationNote;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tags', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->string('color', 32)->default('gray');
            $table->timestamps();
        });

        Schema::create('registration_tag', function (Blueprint $table) {
            $table->foreignId('registration_id')->constrained()->cascadeOnDelete();
            $table->foreignId('tag_id')->constrained()->cascadeOnDelete();
            $table->primary(['registration_id', 'tag_id']);
        });

        Schema::create('registration_notes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('registration_id')->constrained()->cascadeOnDelete();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->text('body');
            $table->timestamps();

            $table->index(['registration_id', 'created_at']);
        });

        Registration::query()
            ->whereNotNull('admin_notes')
            ->where('admin_notes', '!=', '')
            ->orderBy('id')
            ->each(function (Registration $registration): void {
                RegistrationNote::query()->create([
                    'registration_id' => $registration->id,
                    'user_id' => null,
                    'body' => $registration->admin_notes,
                    'created_at' => $registration->updated_at ?? now(),
                    'updated_at' => $registration->updated_at ?? now(),
                ]);
            });
    }

    public function down(): void
    {
        Schema::dropIfExists('registration_notes');
        Schema::dropIfExists('registration_tag');
        Schema::dropIfExists('tags');
    }
};
