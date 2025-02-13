<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Daftar Hutang') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-12 lg:px-18">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="overflow-hidden overflow-x-auto p-6 bg-white border-b border-gray-200">
                    <table class="table">
                        <h1><b>Detail Hutang - {{ $pelanggan->nama }}</b></h1><br>
                        <thead>
                            <tr>
                                <th>Kode Transaksi</th>
                                <th>Tanggal</th>
                                <th>Total Harga</th>
                                <th>Status Pembayaran</th>
                                <th>Barang</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($transaksis as $transaksi)
                                <tr>
                                    <td>{{ $transaksi->kode_transaksi }}</td>
                                    <td>{{ $transaksi->tanggal }}</td>
                                    <td>Rp {{ number_format($transaksi->total_harga, 0, ',', '.') }}</td>
                                    <td>
                                        @if ($transaksi->status_pembayaran == 'hutang')
                                            <span class="badge bg-danger">Hutang</span>
                                        @else
                                            <span class="badge bg-success">Lunas</span>
                                        @endif
                                    </td>
                                    <td>
                                        <ul>
                                            @foreach ($transaksi->detailTransaksi as $detail)
                                                <li>{{ $detail->barang->nama_barang }} - {{ $detail->jumlah }} pcs</li>
                                            @endforeach
                                        </ul>
                                    </td>
                                    <td>
                                        <form action="{{ route('transaksi.updateStatus', $transaksi->id) }}"
                                            method="POST">
                                            @csrf
                                            @method('PUT')
                                            <select name="status_pembayaran">
                                                <option value="hutang"
                                                    {{ $transaksi->status_pembayaran == 'hutang' ? 'selected' : '' }}>
                                                    Hutang</option>
                                                <option value="lunas">Lunas</option>
                                            </select>
                                            <button class="btn btn-warning" type="submit"><i
                                                    class="fa-solid fa-pen"></i>Update</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <a href="{{ route('transaksi.hutang') }}" class="btn btn-primary">Kembali ke Daftar Pelanggan</a>

                </div>
            </div>
        </div>
</x-app-layout>

<script>
    function confirmDelete(id) {
        Swal.fire({
            title: 'Apakah Anda yakin?',
            text: 'Data transaksi ini akan dihapus!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Batal',
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('delete-form-' + id).submit();
            }
        });
    }
</script>
