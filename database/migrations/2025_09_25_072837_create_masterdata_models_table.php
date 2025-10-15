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
        Schema::create('masterdata_models', function (Blueprint $table) {
            $table->id();
            $table->string('no_polisi');
            $table->string('merk')->nullable();
            $table->string('tahun')->nullable();
            $table->enum('jenis', ['Motor', 'Mobil', 'Truck'])->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('masterdata_models');
    }
};
