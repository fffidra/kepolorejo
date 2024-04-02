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
        'status',
        'alamat',
        'ttl',
        'jenis_kelamin',
    ];

    public $timestamps = false;
}
