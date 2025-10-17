<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

// database/migrations/xxxx_xx_xx_000001_create_categories_table.php
return new class extends Migration {
  public function up(): void {
    Schema::create('categories', function (Blueprint $t) {
      $t->id();
      $t->string('name');
      $t->enum('type', ['income','expense']); // pisahkan kategori
      $t->timestamps();
      $t->unique(['name','type']);
    });
  }
  public function down(): void { Schema::dropIfExists('categories'); }
};
