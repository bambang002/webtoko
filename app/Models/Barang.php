<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

class Barang extends Model
{
    use HasFactory;
    use Sortable;

    protected $table = 'barang';

    protected $fillable = [
        'nama_barang',
        'stok',
        'harga_beli',
        'harga_jual'

    ];

    public $sortable = ['nama_barang'];

    public function detailTransaksi()
    {
        return $this->hasMany(DetailTransaksi::class, 'id_barang');
    }
}
