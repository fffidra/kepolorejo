<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class SKUsaha extends Model
{
    use HasFactory;
    
    protected $table = 'sk_usaha';

    protected $primaryKey = 'id_sk_usaha';

    protected $fillable = [
        'jenis_surat',
        'nama',
        'nik',
        'ttl',
        'status_nikah',
        'agama',
        'pekerjaan',
        'pekerjaan_lainnya',
        'alamat',
        'usaha',
        'keperluan',
        'bukti',
        'status_surat',
        'tanggal',
        'jabatan',
        'pemohon',
        'verifikator',
        'pesan',
    ];

    public $timestamps = false;

    // TANGGAL & WAKTU
    protected static function boot(){
        parent::boot();
    
        static::creating(function ($surat) {
            $surat->tanggal = Carbon::now('Asia/Jakarta')->format('Y-m-d H:i:s');
        });
    }

    // protected static function boot()
    // {
    //     parent::boot();

    //     static::creating(function ($surat) {
    //         $surat->tanggal = now()->format('Y-m-d'); 
    //     });
    // }

    public function sk_usaha_ibfk_1()
    {
        return $this->belongsTo(Pekerjaan::class, 'pekerjaan', 'id_pekerjaan');
    }

    public function sk_usaha_ibfk_2()
    {
        return $this->belongsTo(JenisSurat::class, 'jenis_surat', 'id_jenis_surat');
    }

    public function sk_usaha_ibfk_3()
    {
        return $this->belongsTo(Agama::class, 'agama', 'id_agama');
    }
    

    public function sk_usaha_ibfk_4()
    {
        return $this->belongsTo(Status::class, 'status_nikah', 'id_status_nikah');
    }

    public function sk_usaha_ibfk_5()
    {
        return $this->belongsTo(Jabatan::class, 'nama', 'nip');
    }
}
