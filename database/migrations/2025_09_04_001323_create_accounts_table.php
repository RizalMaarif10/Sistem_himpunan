<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
  public function up(): void {
    Schema::create('accounts', function (Blueprint $t) {
      $t->id();
      $t->string('name');
      $t->string('code')->nullable()->unique();
      $t->enum('type', ['cash','bank','other'])->default('cash');
      $t->bigInteger('opening_balance')->default(0);
      $t->timestamps();
    });
  }
  public function down(): void { Schema::dropIfExists('accounts'); }
};
