<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaksi;

class ProfitController extends Controller
{
    public function index()
    {
        // Default: Tampilkan semua data profit tanpa filter
        $profits = $this->calculateProfit();

        // Hitung total profit
        $totalProfit = $profits->sum('profit');

        return view('profit.profit', compact('profits', 'totalProfit'));
    }

    public function filter(Request $request)
    {
        $filterValue = $request->input('filter_value');

        // Tentukan tipe filter berdasarkan panjang input
        $filterType = null;
        if (preg_match('/^\d{4}-\d{2}-\d{2}$/', $filterValue)) {
            $filterType = 'hari'; // Format tanggal (YYYY-MM-DD)
        } elseif (preg_match('/^\d{4}-\d{2}$/', $filterValue)) {
            $filterType = 'bulan'; // Format bulan-tahun (YYYY-MM)
        } elseif (preg_match('/^\d{4}$/', $filterValue)) {
            $filterType = 'tahun'; // Format tahun (YYYY)
        } else {
            return redirect()->back()->with('error', 'Format input tidak valid.');
        }

        // Panggil fungsi untuk menghitung profit berdasarkan tipe filter
        $profits = $this->calculateProfit($filterType, $filterValue);

        // Hitung total profit setelah filter
        $totalProfit = $profits->sum('profit');

        return view('profit.profit', compact('profits', 'filterType', 'filterValue', 'totalProfit'));
    }

    private function calculateProfit($filterType = null, $filterValue = null)
    {
        $query = Transaksi::with('detailTransaksi.barang');

        if ($filterType && $filterValue) {
            if ($filterType == 'hari') {
                $query->whereDate('tanggal', $filterValue);
            } elseif ($filterType == 'bulan') {
                [$year, $month] = explode('-', $filterValue);
                $query->whereYear('tanggal', $year)->whereMonth('tanggal', $month);
            } elseif ($filterType == 'tahun') {
                $query->whereYear('tanggal', $filterValue);
            }
        }

        $transaksi = $query->get();

        return $transaksi->map(function ($trx) {
            $totalProfit = $trx->detailTransaksi->reduce(function ($carry, $detail) {
                $profitPerItem = ($detail->barang->harga_jual - $detail->barang->harga_beli) * $detail->jumlah;
                return $carry + $profitPerItem;
            }, 0);

            return [
                'kode_transaksi' => $trx->kode_transaksi,
                'tanggal' => $trx->tanggal,
                'total_harga' => $trx->total_harga,
                'profit' => $totalProfit,
                'details' => $trx->detailTransaksi->map(function ($detail) {
                    return [
                        'nama_barang' => $detail->barang->nama_barang,
                        'jumlah' => $detail->jumlah,
                        'subtotal' => $detail->subtotal,
                    ];
                }),
            ];
        });
    }
}
