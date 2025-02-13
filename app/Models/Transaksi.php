<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

class Transaksi extends Model
{
    use HasFactory;
    use sortable;

    protected $table = 'transaksi';
    protected $primaryKey = 'id';
    protected $fillable = ['kode_transaksi', 'total_harga', 'tanggal', 'status_pembayaran', 'id_pelanggan'];

    public $sortable = ['tanggal', 'status_pembayaran'];

    public function detailTransaksi()
    {
        return $this->hasMany(DetailTransaksi::class, 'id_transaksi');
    }

    public function pelanggan()
    {
        return $this->belongsTo(Pelanggan::class, 'id_pelanggan', 'id');
    }
}
