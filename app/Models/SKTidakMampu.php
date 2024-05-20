<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class SKTidakMampu extends Model
{
    use HasFactory;
    
    protected $table = 'sk_tidak_mampu';

    protected $primaryKey = 'id_sk_tidak_mampu';

    protected $fillable = [
        'jenis_surat',
        'nama',
        'nik',
        'ttl',
        'agama',
        'pekerjaan',
        'pekerjaan_lainnya',
        'alamat',
        'keperluan',
        'bukti_suket',
        'bukti_kk',
        'bukti_ktp',
        'status_surat',
        'tanggal',
        'pemohon',
        'verifikator',
        'pesan',
    ];

    public $timestamps = false;

    protected static function boot(){
        parent::boot();
    
        static::creating(function ($surat) {
            $surat->tanggal = Carbon::now('Asia/Jakarta')->format('Y-m-d H:i:s');
        });
    }

    public function sk_tidak_mampu_ibfk_1()
    {
        return $this->belongsTo(Pekerjaan::class, 'pekerjaan', 'id_pekerjaan');
    }

    public function sk_tidak_mampu_ibfk_2()
    {
        return $this->belongsTo(JenisSurat::class, 'jenis_surat', 'id_jenis_surat');
    }

    public function sk_tidak_mampu_ibfk_3()
    {
        return $this->belongsTo(Agama::class, 'agama', 'id_agama');
    }
    
    public function sk_tidak_mampu_ibfk_4()
    {
        return $this->belongsTo(Jabatan::class, 'nama', 'nip');
    }
}
