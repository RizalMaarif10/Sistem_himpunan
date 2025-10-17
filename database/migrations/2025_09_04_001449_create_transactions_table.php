<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

// database/migrations/xxxx_xx_xx_000002_create_transactions_table.php
return new class extends Migration {
  public function up(): void {
    Schema::create('transactions', function (Blueprint $t) {
      $t->id();
      $t->date('date');
      $t->enum('type', ['income','expense']);
      $t->foreignId('category_id')->constrained()->cascadeOnDelete();
      $t->foreignId('account_id')->constrained()->cascadeOnDelete();
      $t->bigInteger('amount');                 // simpan rupiah sebagai integer
      $t->string('ref')->nullable();            // no bukti/kwitansi
      $t->text('description')->nullable();
      $t->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
      $t->timestamps();
      $t->index(['date','type']);
    });
  }
  public function down(): void { Schema::dropIfExists('transactions'); }
};
