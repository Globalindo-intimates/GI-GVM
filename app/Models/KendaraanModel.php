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
        'oli_mesin',
        'oli_power_steering',
        'oli_rem',
        'body_kendaraan',
        'otomatis_starter',
        'radiator',
        'baterai_aki',
        'wipers_depan',
        'wipers_belakang',
        'ban_depan',
        'ban_belakang',
        'lampu_depan',
        'lampu_belakang',
        'lampu_rem',
        'klakson',
        'kebersihan',
        'kunci_roda',
        'dongkrak',
        'kotak_p3k',
        'segitiga_pengaman',
    ];
    
    public function kendaraan(){
        return $this->belongsTo(MasterdataModel::class, 'id_kendaraan','id');

    }

}
