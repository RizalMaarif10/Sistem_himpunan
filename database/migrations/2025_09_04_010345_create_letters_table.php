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
        Schema::create('letters', function (Blueprint $t) {
  $t->id();
  $t->enum('type',['incoming','outgoing']);
  $t->string('number')->nullable();
  $t->date('date');
  $t->string('from_name')->nullable();
  $t->string('to_name')->nullable();
  $t->string('subject');
  $t->text('notes')->nullable();
  $t->string('file_path')->nullable();
  $t->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
  $t->timestamp('read_at')->nullable();
  $t->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('letters');
    }
};
