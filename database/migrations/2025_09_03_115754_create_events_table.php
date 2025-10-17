<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete(); // pembuat
            $table->string('title');
            $table->string('slug')->unique();
            $table->longText('description')->nullable();
            $table->string('location')->nullable();
            $table->dateTime('start_at')->nullable();
            $table->dateTime('end_at')->nullable();
            $table->string('registration_link')->nullable(); // (fix) ganti dari external_registration_url
            $table->string('cover_image')->nullable();       // (fix) ganti dari banner
            $table->enum('status', ['draft','published','finished','archived'])->default('draft');
            $table->timestamps();

            $table->index(['status','start_at']);
        });
    }
    public function down(): void {
        Schema::dropIfExists('events');
    }
};
