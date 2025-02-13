<?php

namespace App\Imports;

use App\Models\Barang;
use Maatwebsite\Excel\Concerns\ToModel;

class BarangImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Barang([
            'nama_barang' => $row[0] ?? null, // Gunakan null jika data tidak ada
            'stok' => isset($row[1]) ? (int) $row[1] : 0,
            'harga_beli'=> isset($row[2]) ? (float) $row[2] : 0.0,
            'harga_jual' => isset($row[3]) ? (float) $row[3] : 0.0,
        ]);
        
        
    }
}
