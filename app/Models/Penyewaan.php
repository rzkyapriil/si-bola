<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penyewaan extends Model
{
    protected $table = "penyewaan";
    protected $primaryKey = "penyewaan_id";
    protected $keyType = "int";
    public $timestamps = true;
    public $incrementing = true;

    protected $fillable = [
        'user_id',
        'inventaris_id',
        'tanggal_mulai',
        'tanggal_selesai',
        'total_harga',
        'status',
    ];
}
