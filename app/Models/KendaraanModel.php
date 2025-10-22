<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;

class KendaraanModel extends Model
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'user_id',
        'image',
        'nama_pelapor',
        'id_kendaraan',
        'no_polisi',
        'merk',
        'tahun',
        'jenis',
        'tanggal',
        'status',
        'pemeriksa',
        'is_updated',
        'reject_reason',
        'oli_mesin',
        'oli_mesin_image',
        'oli_mesin_reason',
        'oli_power_steering',
        'oli_power_steering_image',
        'oli_power_steering_reason',
        'oli_rem',
        'oli_rem_image',
        'oli_rem_reason',
        'body_kendaraan',
        'body_kendaraan_image',
        'body_kendaraan_reason',
        'otomatis_starter',
        'otomatis_starter_image',
        'otomatis_starter_reason',
        'radiator',
        'radiator_image',
        'radiator_reason',
        'baterai_aki',
        'baterai_aki_image',
        'baterai_aki_reason',
        'wipers_depan',
        'wipers_depan_image',
        'wipers_depan_reason',
        'wipers_belakang',
        'wipers_belakang_image',
        'wipers_belakang_reason',
        'ban_depan',
        'ban_depan_image',
        'ban_depan_reason',
        'ban_belakang',
        'ban_belakang_image',
        'ban_belakang_reason',
        'lampu_depan',
        'lampu_depan_image',
        'lampu_depan_reason',
        'lampu_belakang',
        'lampu_belakang_image',
        'lampu_belakang_reason',
        'lampu_rem',
        'lampu_rem_image',
        'lampu_rem_reason',
        'klakson',
        'klakson_image',
        'klakson_reason',
        'kebersihan',
        'kebersihan_image',
        'kebersihan_reason',
        'kunci_roda',
        'kunci_roda_image',
        'kunci_roda_reason',
        'dongkrak',
        'dongkrak_image',
        'dongkrak_reason',
        'kotak_p3k',
        'kotak_p3k_image',
        'kotak_p3k_reason',
        'segitiga_pengaman',
        'segitiga_pengaman_image',
        'segitiga_pengaman_reason',
    ];
    
    public function kendaraan(){
        return $this->belongsTo(MasterdataModel::class, 'id_kendaraan','id');

    }

}
