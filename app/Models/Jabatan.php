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
    public $incrementing = false; // Menetapkan bahwa 'nik' bukan auto-incrementing

    protected $fillable = [
        'nip',
        'nama',
        'posisi',
        'peran',
    ];

    public $timestamps = false;
}