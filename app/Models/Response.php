<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Response extends Model
{
    use HasFactory;
    protected $fillable = [
        'report_id',
        'status',
        'pesan',
    ];
    // BelongsTo : disambungkan denga table nama (PK nya ada dimana)
    // Table yang berperan sebagai FK
    // Nama fungsi -- nama model PK
    public function report()
    {
        return $this->belongTo
        (Report::class);
    }
}
