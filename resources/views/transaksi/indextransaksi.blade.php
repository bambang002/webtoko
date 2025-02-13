<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Daftar Transaksi') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-12 lg:px-18">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="overflow-hidden overflow-x-auto p-6 bg-white border-b border-gray-200">
                    <div class="flex justify-between mb-4">
                        <div>
                            <a href="{{ route('transaksi.create') }}" class="btn btn-outline-info">
                                <i class="fa-solid fa-plus"></i> Buat Transaksi
                            </a>
                        </div>
                        <form action="" method="GET">
                            <div class="input-group" style="max-width: 200px;">
                                <input type="text" name="search" id="search" value="{{ $search }}"
                                    class="form-control" placeholder="Cari.........." aria-label="Recipient's username"
                                    aria-describedby="basic-addon2" />
                                <div class="input-group-append">
                                    <button class="btn btn-sm btn-primary" type="submit"> <i
                                            class="fa-solid fa-magnifying-glass"></i> </button>
                                </div>
                            </div>
                        </form>
                    </div>
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead>
                                <tr>
                                    <th class="px-6 py-3 bg-gray-50 text-left">Kode Transaksi</th>
                                    <th class="px-6 py-3 bg-gray-50 text-left">Tanggal</th>
                                    <th class="px-6 py-3 bg-gray-50 text-left">Total Harga</th>
                                    <th class="px-6 py-3 bg-gray-50 text-left">Nama Pelanggan</th>
                                    <th class="px-6 py-3 bg-gray-50 text-left">Status Pembayaran</th>
                                    <th class="px-6 py-3 bg-gray-50 text-left">Detail Transaksi</th>
                                    <th class="px-6 py-3 bg-gray-50 text-left">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach ($transaksi as $item)
                                    <tr>
                                        <td class="px-6 py-4 text-sm text-gray-900">{{ $item->kode_transaksi }}</td>
                                        <td class="px-6 py-4 text-sm text-gray-900">
                                            {{ \Carbon\Carbon::parse($item->tanggal)->format('d-m-Y H:i:s') }}
                                        </td>
                                        <td class="px-6 py-4 text-sm text-gray-900">
                                            {{ number_format($item->total_harga, 2) }}
                                        </td>
                                        <td class="px-6 py-4 text-sm text-gray-900">
                                            {{ optional($item->pelanggan)->nama ?? '-' }}

                                        </td>
                                        <td class="px-6 py-4 text-sm text-gray-900">
                                            {{ $item->status_pembayaran }}
                                        </td>

                                        <td class="px-6 py-4 text-sm text-gray-900">
                                            <ul>
                                                @foreach ($item->detailTransaksi as $detail)
                                                    <li>
                                                        {{ $detail->barang->nama_barang }} - {{ $detail->jumlah }} unit
                                                        -
                                                        Subtotal: {{ number_format($detail->subtotal, 2) }}
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            <a href="{{ route('transaksi.show', $item->id) }}" class="btn btn-info">
                                                <i class="fa-solid fa-eye"></i> Lihat</a>

                                            <form id="delete-form-{{ $item->id }}"
                                                action="{{ route('transaksi.destroy', $item->id) }}" method="POST"
                                                style="display: none;">
                                                @csrf
                                                @method('DELETE')
                                            </form>

                                            <button type="button" onclick="confirmDelete({{ $item->id }})"
                                                class="btn btn-danger">
                                                <i class="fa-solid fa-trash"></i>
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    @if (session('success'))
                        <div class="bg-green-100 text-green-800 p-4 mt-4 rounded-md">
                            {{ session('success') }}
                        </div>
                    @endif
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
