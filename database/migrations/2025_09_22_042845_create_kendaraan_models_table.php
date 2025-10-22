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
            $table->text('reject_reason')->nullable()->after('status');
            $table->boolean('is_updated')->default(false)->after('reject_reason');
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
            $table->string('oli_mesin_image')->nullable()->after('oli_mesin');
            $table->string('oli_power_steering_image')->nullable()->after('oli_power_steering');
            $table->string('oli_rem_image')->nullable()->after('oli_rem');
            $table->string('body_kendaraan_image')->nullable()->after('body_kendaraan');
            $table->string('otomatis_starter_image')->nullable()->after('otomatis_starter');
            $table->string('radiator_image')->nullable()->after('radiator');
            $table->string('baterai_aki_image')->nullable()->after('baterai_aki');
            $table->string('wipers_depan_image')->nullable()->after('wipers_depan');
            $table->string('wipers_belakang_image')->nullable()->after('wipers_belakang');
            $table->string('ban_depan_image')->nullable()->after('ban_depan');
            $table->string('ban_belakang_image')->nullable()->after('ban_belakang');
            $table->string('lampu_depan_image')->nullable()->after('lampu_depan');
            $table->string('lampu_belakang_image')->nullable()->after('lampu_belakang');
            $table->string('lampu_rem_image')->nullable()->after('lampu_rem');
            $table->string('klakson_image')->nullable()->after('klakson');
            $table->string('kebersihan_image')->nullable()->after('kebersihan');
            $table->string('kunci_roda_image')->nullable()->after('kunci_roda');
            $table->string('dongkrak_image')->nullable()->after('dongkrak');
            $table->string('kotak_p3k_image')->nullable()->after('kotak_p3k');
            $table->string('segitiga_pengaman_image')->nullable()->after('segitiga_pengaman');
            $table->text('oli_mesin_reason')->nullable()->after('oli_mesin_image');
            $table->text('oli_power_steering_reason')->nullable()->after('oli_power_steering_image');
            $table->text('oli_rem_reason')->nullable()->after('oli_rem_image');
            $table->text('body_kendaraan_reason')->nullable()->after('body_kendaraan_image');
            $table->text('otomatis_starter_reason')->nullable()->after('otomatis_starter_image');
            $table->text('radiator_reason')->nullable()->after('radiator_image');
            $table->text('baterai_aki_reason')->nullable()->after('baterai_aki_image');
            $table->text('wipers_depan_reason')->nullable()->after('wipers_depan_image');
            $table->text('wipers_belakang_reason')->nullable()->after('wipers_belakang_image');
            $table->text('ban_depan_reason')->nullable()->after('ban_depan_image');
            $table->text('ban_belakang_reason')->nullable()->after('ban_belakang_image');
            $table->text('lampu_depan_reason')->nullable()->after('lampu_depan_image');
            $table->text('lampu_belakang_reason')->nullable()->after('lampu_belakang_image');
            $table->text('lampu_rem_reason')->nullable()->after('lampu_rem_image');
            $table->text('klakson_reason')->nullable()->after('klakson_image');
            $table->text('kebersihan_reason')->nullable()->after('kebersihan_image');
            $table->text('kunci_roda_reason')->nullable()->after('kunci_roda_image');
            $table->text('dongkrak_reason')->nullable()->after('dongkrak_image');
            $table->text('kotak_p3k_reason')->nullable()->after('kotak_p3k_image');
            $table->text('segitiga_pengaman_reason')->nullable()->after('segitiga_pengaman_image');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('kendaraan_models', function (Blueprint $table) {
            $table->dropColumn([
                'is_updated',
                'oli_mesin_image',
                'oli_power_steering_image',
                'oli_rem_image',
                'body_kendaraan_image',
                'otomatis_starter_image',
                'radiator_image',
                'baterai_aki_image',
                'wipers_depan_image',
                'wipers_belakang_image',
                'ban_depan_image',
                'ban_belakang_image',
                'lampu_depan_image',
                'lampu_belakang_image',
                'lampu_rem_image',
                'klakson_image',
                'kebersihan_image',
                'kunci_roda_image',
                'dongkrak_image',
                'kotak_p3k_image',
                'segitiga_pengaman_image',
                'oli_mesin_reason',
                'oli_power_steering_reason',
                'oli_rem_reason',
                'body_kendaraan_reason',
                'otomatis_starter_reason',
                'radiator_reason',
                'baterai_aki_reason',
                'wipers_depan_reason',
                'wipers_belakang_reason',
                'ban_depan_reason',
                'ban_belakang_reason',
                'lampu_depan_reason',
                'lampu_belakang_reason',
                'lampu_rem_reason',
                'klakson_reason',
                'kebersihan_reason',
                'kunci_roda_reason',
                'dongkrak_reason',
                'kotak_p3k_reason',
                'segitiga_pengaman_reason',
                
            ]);
        });
    }
};