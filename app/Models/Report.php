<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    use HasFactory; 
    protected $fillable = [
        'nik',
        'nama',
        'no_telp',
        'pengaduan',
        'foto',
    ];
    
    // hasOne : one to one realtion
    // Table yang berperan sebagai PK
    // nama fungsi == nama model FK
    public function response()
    {
        return $this->hasOne
        (Response::class);
    }
}
