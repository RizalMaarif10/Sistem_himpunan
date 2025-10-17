<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->string('title');
            $table->string('slug')->unique();
            $table->string('excerpt')->nullable();
            $table->longText('content')->nullable();      // boleh pakai 'body' jika kamu prefer
            $table->string('cover_image')->nullable();
            $table->enum('status',['draft','published'])->default('draft');
            $table->timestamp('published_at')->nullable();
            $table->timestamps();

            $table->index(['status','published_at']);
        });
    }
    public function down(): void {
        Schema::dropIfExists('posts');
    }
};
