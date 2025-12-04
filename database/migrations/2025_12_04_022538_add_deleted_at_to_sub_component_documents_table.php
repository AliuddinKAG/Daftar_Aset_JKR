<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('sub_component_documents')) {
            Schema::table('sub_component_documents', function (Blueprint $table) {
                if (!Schema::hasColumn('sub_component_documents', 'deleted_at')) {
                    $table->softDeletes()->after('updated_at');
                }
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('sub_component_documents')) {
            Schema::table('sub_component_documents', function (Blueprint $table) {
                if (Schema::hasColumn('sub_component_documents', 'deleted_at')) {
                    $table->dropColumn('deleted_at');
                }
            });
        }
    }
};