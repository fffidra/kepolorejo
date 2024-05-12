<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;

class Pegawai extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'pegawai';

    protected $primaryKey = 'nik';

    protected $fillable = [
        'nik',
        'nama',        
        'password',
        'role',
    ];

    public $timestamps = false;
}
