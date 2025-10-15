<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('kendaraan_models', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->string('image')->nullable();
            $table->string('nama_pelapor');
            $table->string('id_kendaraan');
            $table->string('no_polisi');
            $table->string('merk')->nullable();
            $table->string('tahun')->nullable();
            $table->enum('jenis', ['Motor', 'Mobil', 'Truck'])->nullable();
            $table->date('tanggal');
            $table->enum('status', allowed: ['✔', '✖'])->nullable();
            $table->string('pemeriksa');
            $table->enum('oli_mesin', ['✔', '✖'])->nullable();
            $table->enum('oli_power_steering', ['✔', '✖'])->nullable();
            $table->enum('oli_rem', ['✔', '✖'])->nullable();
            $table->enum('body_kendaraan', ['✔', '✖'])->nullable();
            $table->enum('otomatis_starter', ['✔', '✖'])->nullable();
            $table->enum('radiator', ['✔', '✖'])->nullable();
            $table->enum('baterai_aki', ['✔', '✖'])->nullable();
            $table->enum('wipers_depan', ['✔', '✖'])->nullable();
            $table->enum('wipers_belakang', ['✔', '✖'])->nullable();
            $table->enum('ban_depan', ['✔', '✖'])->nullable();
            $table->enum('ban_belakang', ['✔', '✖'])->nullable();
            $table->enum('lampu_depan', ['✔', '✖'])->nullable();
            $table->enum('lampu_belakang', ['✔', '✖'])->nullable();
            $table->enum('lampu_rem', ['✔', '✖'])->nullable();
            $table->enum('klakson', ['✔', '✖'])->nullable();
            $table->enum('kebersihan', ['✔', '✖'])->nullable();
            $table->enum('kunci_roda', ['✔', '✖'])->nullable();
            $table->enum('dongkrak', ['✔', '✖'])->nullable();
            $table->enum('kotak_p3k', ['✔', '✖'])->nullable();
            $table->enum('segitiga_pengaman', ['✔', '✖'])->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kendaraan_models');
    }
};
