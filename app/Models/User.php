<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'user';

    protected $primaryKey = 'nik';
    public $incrementing = false; 
    
    protected $fillable = [
        'nik',
        'nama',        
        'password',
        'role',
    ];

    public $timestamps = false;
}
