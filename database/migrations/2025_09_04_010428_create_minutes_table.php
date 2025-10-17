<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('minutes', function (Blueprint $t) {
  $t->id();
  $t->string('title');
  $t->date('meeting_date');
  $t->text('notes')->nullable();
  $t->string('file_path')->nullable();
  $t->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
  $t->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('minutes');
    }
};
