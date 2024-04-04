<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pekerjaan extends Model
{
    use HasFactory;

    protected $table = 'pekerjaan';

    protected $primaryKey = 'id_pekerjaan';

    protected $fillable = [
        'nama_pekerjaan'
    ];

    public function fk_pekerjaan()
    {
        return $this->hasMany(Surat::class, 'pekerjaan');
    }

    public $timestamps = false;
}
