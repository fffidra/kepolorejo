<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Surat extends Model
{
    use HasFactory;
    
    protected $table = 'surat';

    protected $primaryKey = 'id_surat';

    protected $fillable = [
        'nama_warga',
        'nik_warga',
        'agama',
        'jenis_surat',
        'pekerjaan',
        'status_nikah',
        'alamat',
        'alamat_dom',
        'ttl',
        'jenis_kelamin',
        'usaha',
        'keperluan'
    ];

    public $timestamps = false;

    public function fk_agama()
    {
        return $this->belongsTo(Agama::class, 'agama', 'id_agama');
    }
    
    public function fk_pekerjaan()
    {
        return $this->belongsTo(Pekerjaan::class, 'pekerjaan', 'id_pekerjaan');
    }

    public function fk_status()
    {
        return $this->belongsTo(Status::class, 'status_nikah', 'id_status_nikah');
    }

    public function fk_surat()
    {
        return $this->belongsTo(JenisSurat::class, 'jenis_surat', 'id_jenis_surat');
    }

}
