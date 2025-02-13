<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class hutang extends Model
{
    use HasFactory;

    protected $table = 'debt';

    protected $fillable = [
        'id_transaksi',
        'id_pelanggan',
        'jumlah_hutang',
        'tanggal',
    ];

    public function transaksi()
    {
        return $this->belongsTo(Transaksi::class, 'id_transaksi');
    }
    
    public function pelanggan()
    {
        return $this->belongsTo(Pelanggan::class, 'id_pelanggan');
    }
    
}
