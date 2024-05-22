<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class JabatanStruktural extends Model
{
    use HasFactory, Notifiable;

    protected $table = 'jabatan_struktural';

    protected $primaryKey = 'id_jabatan_struktural';

    protected $fillable = [
        'nama_jabatan_struktural',
    ];

    public $timestamps = false;
}