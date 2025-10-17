<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('event_clicks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('event_id')->constrained('events')->cascadeOnDelete();
            $table->timestamp('clicked_at');
            $table->string('ip', 45)->nullable();
            $table->string('user_agent', 255)->nullable();
        });
    }
    public function down(): void {
        Schema::dropIfExists('event_clicks');
    }
};
