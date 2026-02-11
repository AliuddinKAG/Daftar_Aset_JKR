<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('components', function (Blueprint $table) {
            // Check if columns don't exist before adding
            if (!Schema::hasColumn('components', 'sistem_id')) {
                $table->unsignedBigInteger('sistem_id')->nullable()->after('user_id');
                $table->foreign('sistem_id')->references('id')->on('sistems')->onDelete('set null');
            }
            
            if (!Schema::hasColumn('components', 'subsistem_id')) {
                $table->unsignedBigInteger('subsistem_id')->nullable()->after('sistem_id');
                $table->foreign('subsistem_id')->references('id')->on('subsistems')->onDelete('set null');
            }
        });
    }

    public function down(): void
    {
        Schema::table('components', function (Blueprint $table) {
            $table->dropForeign(['sistem_id']);
            $table->dropForeign(['subsistem_id']);
            $table->dropColumn(['sistem_id', 'subsistem_id']);
        });
    }
};