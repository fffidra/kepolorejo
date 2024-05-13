<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SKDomisili extends Model
{
    use HasFactory;
    
    protected $table = 'sk_domisili';

    protected $primaryKey = 'id_sk_domisili';

    protected $fillable = [
        'jenis_surat',
        'nama',
        'nik',
        'jenis_kelamin',
        'ttl',
        'agama',
        'status_nikah',
        'pekerjaan',
        'alamat',
        'alamat_dom',
        'keperluan',
        'bukti',
        'status_surat',
        'tanggal',
        'jabatan',
        'pemohon',
        'verifikator',
    ];

    public $timestamps = false;

    // TANGGAL & WAKTU
    // protected static function boot(){
    //     parent::boot();

    //     static::creating(function ($surat) {
    //         $surat->tanggal = now()->format('Y-m-d H:i:s'); 
    //     });
    // }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($surat) {
            $surat->tanggal = now()->format('Y-m-d'); 
        });
    }

    public function sk_domisili_ibfk_1()
    {
        return $this->belongsTo(Status::class, 'status_nikah', 'id_status_nikah');
    }

    public function sk_domisili_ibfk_2()
    {
        return $this->belongsTo(Agama::class, 'agama', 'id_agama');
    }
    
    public function sk_domisili_ibfk_3()
    {
        return $this->belongsTo(Pekerjaan::class, 'pekerjaan', 'id_pekerjaan');
    }

    public function sk_domisili_ibfk_4()
    {
        return $this->belongsTo(JenisSurat::class, 'jenis_surat', 'id_jenis_surat');
    }

    public function sk_domisili_ibfk_5()
    {
        return $this->belongsTo(JenisKelamin::class, 'jenis_kelamin', 'id_jenis_kelamin');
    }

    public function sk_domisili_ibfk_6()
    {
        return $this->belongsTo(Jabatan::class, 'nama', 'nip');
    }
}
