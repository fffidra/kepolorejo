<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JenisKelamin extends Model
{
    use HasFactory;

    protected $table = 'jenis_kelamin';

    protected $primaryKey = 'id_jenis_kelamin';

    protected $fillable = [
        'nama_jenis_kelamin'
    ];

    public function fk_jenis_kelamin()
    {
        return $this->hasMany(Surat::class, 'jenis_kelamin');
    }

    public $timestamps = false;
}
