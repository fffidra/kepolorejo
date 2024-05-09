<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
        'alamat',
        'keperluan',
        'status_surat',
        'tanggal',
    ];

    public $timestamps = false;

    // TANGGAL & WAKTU
    // protected static function boot()
    // {
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

    public function sk_tidak_mampu_ibfk_3()
    {
        return $this->belongsTo(Agama::class, 'agama', 'id_agama');
    }
    
    public function sk_tidak_mampu_ibfk_1()
    {
        return $this->belongsTo(Pekerjaan::class, 'pekerjaan', 'id_pekerjaan');
    }

    public function sk_tidak_mampu_ibfk_2()
    {
        return $this->belongsTo(JenisSurat::class, 'jenis_surat', 'id_jenis_surat');
    }

}
