<?php

namespace App\Http\Controllers;
use App\Models\Barang;
use App\Imports\BarangImport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class BarangController extends Controller
{
    public function index(Request $request)
{
    $search = $request->query('search');

    // Cek apakah ada pencarian
    if (!empty($search)) {
        $barangs = Barang::sortable()
            ->where('barang.nama_barang', 'like', '%' . $search . '%')
            ->paginate(30);
    } else {
        $barangs = Barang::sortable()->paginate(30);
    }

    // Kirim data ke view
    return view('barang.databarang', compact('barangs', 'search'));
}


    public function create()
    {
        return view('barang.inputbarang');
    }

    public function store(Request $request)
{
    // Validasi semua data array
    $request->validate([
        'data.*.nama_barang' => 'nullable|string',
        'data.*.stok' => 'nullable|numeric',
        'data.*.harga_beli' => 'nullable|numeric',
        'data.*.harga_jual' => 'nullable|numeric',
    ]);

    // Ambil semua data dari input
    $barangs = $request->input('data');

    // Filter data: Hanya masukkan baris yang memiliki minimal 1 kolom terisi
    $filteredBarangs = array_filter($barangs, function ($barang) {
        return array_filter($barang); // Menghapus baris jika semua kolom kosong
    });

    // Simpan data yang sudah difilter
    foreach ($filteredBarangs as $barang) {
        Barang::create($barang);
    }

    return redirect()->route('barang.databarang')->with('success', 'Data berhasil disimpan!');
}

    public function importExcel(Request $request)
    {
        // validasi
        $this->validate($request, [
            'file' => 'required|mimes:csv,xls,xlsx',
        ]);

        $file = $request->file('file');

        $file_name = rand() . $file->getClientOriginalName();

        $file->move('file', $file_name);

        Excel::import(new BarangImport(), public_path('/file/' . $file_name));

        return redirect()->route('barang.databarang')->with('success', 'Data Berhasil Diimport');
    }

    public function destroy($id)
    {
        $barangs = Barang::find($id);

        if (!$barangs) {
            return redirect()->back()->with('error', 'data not found.');
        }

        $barangs->delete();
        return redirect()->back()->with('success', 'Data Berhasil Dihapus.');
    }

    public function edit($id)
    {
        $barangs = Barang::findOrFail($id);
        return view('barang.editbarang', compact('barangs'));
    }   

    public function update(Request $request, $id)
    {
        $barangs = Barang::findOrFail($id);
        $barangs->nama_barang = $request->input('nama_barang');
        $barangs->stok = $request->input('stok');
        $barangs->harga_beli = $request->input('harga_beli');
        $barangs->harga_jual = $request->input('harga_jual');

        $barangs->save();
        return redirect()->route('barang.databarang')->with('success', 'Data Berhasil Diedit');
    }
}
