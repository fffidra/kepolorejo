<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Pengguna extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'pengguna';

    protected $primaryKey = 'id_pengguna';

    protected $fillable = [
        'nik',
        'nama',
        'bidang',
        'password',
    ];

    public $timestamps = false;

    protected $username = 'nik';
    protected $hidden = 'password';


}