<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Pemesanan extends Model
{
    protected $table = "pemesanan";
    protected $primaryKey = "id";
    protected $keyType = "int";
    public $timestamps = true;
    public $incrementing = true;

    protected $fillable = [
        'kode_pemesanan',
        'user_id',
        'nama',
        'tanggal',
        'lapangan',
        'waktu_mulai',
        'waktu_selesai',
        'total_harga',
        'status',
    ];

    public function pembayaran(): BelongsTo
    {
        return $this->belongsTo(Pembayaran::class, 'pemesanan_id', 'id');
    }
}
