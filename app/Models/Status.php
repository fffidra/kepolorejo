<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
    use HasFactory;

    protected $table = 'status_nikah';

    protected $primaryKey = 'id_status_nikah';

    protected $fillable = [
        'nama_status_nikah'
    ];
    
    public $timestamps = false;
}