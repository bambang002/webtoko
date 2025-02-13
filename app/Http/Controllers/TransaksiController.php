<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaksi;
use App\Models\Barang;
use App\Models\DetailTransaksi;
use App\Models\Pelanggan;

class TransaksiController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->query('search');

        // Cek apakah ada pencarian
        if (!empty($search)) {
            $transaksi = Transaksi::with('pelanggan', 'detailTransaksi.barang')
                // Mencari berdasarkan nama_pelanggan pada tabel pelanggan
                ->whereHas('pelanggan', function ($query) use ($search) {
                    $query->where('nama', 'like', '%' . $search . '%');
                })
                // Mencari berdasarkan tanggal pada tabel transaksi
                ->orWhere('tanggal', 'like', '%' . $search . '%')
                ->sortable()
                ->paginate(30);
        } else {
            // Jika tidak ada pencarian, tampilkan transaksi dengan sortable
            $transaksi = Transaksi::with('pelanggan', 'detailTransaksi.barang')->sortable()->paginate(30);
        }

        // Kirim data ke view
        return view('transaksi.indextransaksi', compact('transaksi', 'search'));
    }

    public function show($id)
    {
        $transaksi = Transaksi::with('detailTransaksi.barang')->findOrFail($id);
        return view('transaksi.detailtransaksi', compact('transaksi'));
    }

    public function create()
    {
        // Mengambil transaksi terakhir untuk kode transaksi berikutnya
        $lastTransaksi = Transaksi::latest()->first();
        $nextKode = $lastTransaksi ? 'JTM-' . str_pad((int) substr($lastTransaksi->kode_transaksi, 4) + 1, 4, '0', STR_PAD_LEFT) : 'JTM-0001';

        // Mengambil data barang dan pelanggan
        $barangs = Barang::all();
        $pelanggans = Pelanggan::all();

        return view('transaksi.tambahtransaksi', compact('barangs', 'nextKode', 'pelanggans'));
    }

    public function store(Request $request)
    {
        // Debugging untuk melihat data yang dikirim dari form
        // Validasi input
        $request->validate([
            'status_pembayaran' => 'required|in:lunas,hutang',
            'total_harga' => 'required|numeric',
            'barangs' => 'required|array',
            'id_pelanggan' => 'nullable|exists:pelanggan,id',
            'new_pelanggan_nama' => 'nullable|string|max:255',
        ]);

        // Generate kode transaksi yang unik
        $kodeTransaksi = 'JTM-' . now()->format('YmdHis');

        // Inisialisasi id_pelanggan
        $pelangganId = null;

        // Jika status pembayaran adalah 'hutang', pastikan pelanggan dipilih atau dibuat
        if ($request->status_pembayaran === 'hutang') {
            if ($request->id_pelanggan) {
                $pelangganId = $request->id_pelanggan;
            } elseif ($request->new_pelanggan_nama) {
                $pelanggan = Pelanggan::create([
                    'nama' => $request->new_pelanggan_nama,
                ]);
                $pelangganId = $pelanggan->id;
            } else {
                return back()->withErrors(['id_pelanggan' => 'Pilih pelanggan atau tambah pelanggan baru.']);
            }
        }

        // Simpan transaksi utama
        $transaksi = Transaksi::create([
            'kode_transaksi' => $kodeTransaksi,
            'total_harga' => $request->total_harga,
            'status_pembayaran' => $request->status_pembayaran,
            'id_pelanggan' => $pelangganId, // Bisa null jika status lunas
        ]);
        \Log::info('Transaksi berhasil disimpan:', $transaksi->toArray()); // Debug hasil penyimpanan
        // Simpan detail transaksi (barang yang dibeli)
        foreach ($request->barangs as $barang) {
            $barangModel = Barang::find($barang['id']);

            if (!$barangModel || $barangModel->stok < $barang['jumlah']) {
                return back()->withErrors(['barangs' => 'Stok barang tidak mencukupi atau barang tidak ditemukan.']);
            }

            // Buat detail transaksi
            DetailTransaksi::create([
                'id_transaksi' => $transaksi->id,
                'id_barang' => $barang['id'],
                'jumlah' => $barang['jumlah'],
                'subtotal' => $barang['subtotal'],
            ]);

            // Kurangi stok barang
            $barangModel->stok -= $barang['jumlah'];
            $barangModel->save();
        }

        // Redirect dengan pesan sukses
        return redirect()->route('transaksi.indextransaksi')->with('success', 'Transaksi berhasil disimpan.');
    }

    public function destroy($id)
    {
        // Menghapus transaksi beserta detailnya
        $transaksi = Transaksi::with('detailTransaksi')->findOrFail($id);
        $transaksi->detailTransaksi()->delete();
        $transaksi->delete();

        return redirect()->route('transaksi.indextransaksi')->with('success', 'Transaksi berhasil dihapus!');
    }

    public function edit($id)
    {
        $transaksi = Transaksi::findOrFail($id);
        return view('transaksi.edithutang', compact('transaksi'));
    }

    public function update(Request $request, $id)
    {
        $transaksi = Transaksi::findOrFail($id);
        $transaksi->status_pembayaran = $request->input('status_pembayaran');

        $transaksi->save();
        return redirect()->route('transaksi.hutang')->with('success', 'Data Sudah Diubah');
    }

    public function hutang()
    {
        $pelanggans = Pelanggan::whereNotNull('nama')->get(); 

        return view('transaksi.hutang', compact('pelanggans'));
    }

    public function transaksiPelanggan(Pelanggan $pelanggan)
{
    // Ambil transaksi berdasarkan id_pelanggan
    $transaksis = Transaksi::with('detailTransaksi.barang')
        ->where('id_pelanggan', $pelanggan->id)
        ->get();

    return view('transaksi.detailhutang', compact('pelanggan', 'transaksis'));
}

    
public function updateStatus(Request $request, Transaksi $transaksi)
{
    // Validasi status pembayaran
    $request->validate([
        'status_pembayaran' => 'required|in:lunas',
    ]);

    // Update status pembayaran menjadi 'lunas'
    $transaksi->update([
        'status_pembayaran' => $request->status_pembayaran,
    ]);

    // Ambil pelanggan berdasarkan transaksi
    $pelanggan = Pelanggan::find($transaksi->id_pelanggan);

    // Jika pelanggan masih ada, redirect ke halaman detail hutang
    if ($pelanggan) {
        return redirect()->route('transaksi.detailhutang', $pelanggan)
            ->with('success', 'Status pembayaran berhasil diubah.');
    }

    // Jika pelanggan sudah tidak ada (misalnya null), redirect ke halaman hutang utama
    return redirect()->route('transaksi.hutang')
        ->with('success', 'Status pembayaran berhasil diubah.');
}

}
