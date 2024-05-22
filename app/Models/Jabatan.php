<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Jabatan extends Model
{
    use HasFactory, Notifiable;

    protected $table = 'jabatan';

    protected $primaryKey = 'nip';
    public $incrementing = false;

    protected $fillable = [
        'nip',
        'nama',
        'nama_jabatan',
        'posisi',
        'peran',
    ];

    public $timestamps = false;
}