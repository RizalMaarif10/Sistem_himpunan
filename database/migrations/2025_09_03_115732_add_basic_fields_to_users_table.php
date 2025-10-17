<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::table('users', function (Blueprint $table) {
            if (!Schema::hasColumn('users','username')) {
                $table->string('username')->unique()->nullable()->after('email');
            }
            if (!Schema::hasColumn('users','phone')) {
                $table->string('phone')->nullable()->after('username');
            }
            if (!Schema::hasColumn('users','avatar')) {
                $table->string('avatar')->nullable()->after('phone');
            }
            if (!Schema::hasColumn('users','status')) {
                $table->enum('status',['active','inactive'])->default('active')->after('avatar');
            }
        });
    }
    public function down(): void {
        Schema::table('users', function (Blueprint $table) {
            if (Schema::hasColumn('users','status')) $table->dropColumn('status');
            if (Schema::hasColumn('users','avatar')) $table->dropColumn('avatar');
            if (Schema::hasColumn('users','phone')) $table->dropColumn('phone');
            if (Schema::hasColumn('users','username')) $table->dropColumn('username');
        });
    }
};
