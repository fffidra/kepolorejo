<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jabatan extends Model
{
    use HasFactory;

    protected $table = 'jabatan';

    protected $primaryKey = 'nip';

    protected $fillable = [
        'nama',
        'posisi',
    ];

    public $timestamps = false;

    // public function fk_agama()
    // {
    //     return $this->hasMany(Surat::class, 'agama');
    // }
}