<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('main_components', function (Blueprint $table) {
            $table->string('kod_ptj')->nullable()->after('id'); 
            $table->string('no_perolehan_1gfmas')->nullable()->after('kod_ptj');
        });
    }

    public function down(): void
    {
        Schema::table('main_components', function (Blueprint $table) {
            $table->dropColumn('kod_ptj');
            $table->dropColumn('no_perolehan_1gfmas');
        });
    }
};
