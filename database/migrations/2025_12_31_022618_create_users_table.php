<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Check if table exists
        if (Schema::hasTable('users')) {
            Schema::table('users', function (Blueprint $table) {
                // Add new columns if they don't exist
                if (!Schema::hasColumn('users', 'username')) {
                    $table->string('username')->unique()->after('id');
                }
                if (!Schema::hasColumn('users', 'role')) {
                    $table->enum('role', ['admin', 'user'])->default('user')->after('password');
                }
                if (!Schema::hasColumn('users', 'is_active')) {
                    $table->boolean('is_active')->default(true)->after('role');
                }
                if (!Schema::hasColumn('users', 'remember_token')) {
                    $table->rememberToken();
                }
            });
        } else {
            // Create table if it doesn't exist
            Schema::create('users', function (Blueprint $table) {
                $table->id();
                $table->string('username')->unique();
                $table->string('password');
                $table->enum('role', ['admin', 'user'])->default('user');
                $table->boolean('is_active')->default(true);
                $table->rememberToken();
                $table->timestamps();
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('users')) {
            Schema::table('users', function (Blueprint $table) {
                // Remove columns that were added
                if (Schema::hasColumn('users', 'username')) {
                    $table->dropColumn('username');
                }
                if (Schema::hasColumn('users', 'role')) {
                    $table->dropColumn('role');
                }
                if (Schema::hasColumn('users', 'is_active')) {
                    $table->dropColumn('is_active');
                }
                if (Schema::hasColumn('users', 'remember_token')) {
                    $table->dropColumn('remember_token');
                }
            });
        }
    }
};