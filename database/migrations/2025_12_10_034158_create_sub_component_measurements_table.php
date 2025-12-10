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
        Schema::create('sub_component_measurements', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('sub_component_id');
            $table->enum('type', ['saiz', 'kadaran', 'kapasiti'])
                  ->comment('Jenis pengukuran: saiz fizikal, kadaran elektrik, kapasiti');
            $table->string('value')->nullable()
                  ->comment('Nilai pengukuran (contoh: 1200x400x500 atau 15)');
            $table->string('unit', 50)->nullable()
                  ->comment('Unit pengukuran (contoh: mm, cm, m, kW, HP, A, V, L, kg, ton, BTU)');
            $table->unsignedTinyInteger('order')->default(1)
                  ->comment('Urutan paparan untuk multiple measurements');
            $table->timestamps();
            
            // Foreign key constraint
            $table->foreign('sub_component_id')
                  ->references('id')
                  ->on('sub_components')
                  ->onDelete('cascade')
                  ->onUpdate('cascade');
            
            // Indexes untuk performance
            $table->index(['sub_component_id', 'type'], 'idx_sub_comp_measurement_type');
            $table->index('type', 'idx_sub_measurement_type');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sub_component_measurements');
    }
};