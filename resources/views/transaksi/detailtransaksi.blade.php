<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Detail Transaksi') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <!-- Informasi Transaksi -->
                    <div class="mb-6">
                        <h3 class="text-lg font-medium text-gray-800">Informasi Transaksi</h3>
                        <table class="min-w-full divide-y divide-gray-200 mt-4">
                            <tr>
                                <th class="text-left px-4 py-2">Kode Transaksi:</th>
                                <td class="px-4 py-2">{{ $transaksi->kode_transaksi }}</td>
                            </tr>
                            <tr>
                                <th class="text-left px-4 py-2">Tanggal:</th>
                                <td class="px-4 py-2">{{ $transaksi->tanggal }}</td>
                            </tr>
                            <tr>
                                <th class="text-left px-4 py-2">Status Pembayaran:</th>
                                <td class="px-4 py-2">{{ $transaksi->status_pembayaran }}</td>
                            </tr>
                            <tr>
                                <th class="text-left px-4 py-2">Total Harga:</th>
                                <td class="px-4 py-2">Rp {{ number_format($transaksi->total_harga, 0, ',', '.') }}</td>
                            </tr>
                        </table>
                    </div>

                    <!-- Detail Barang -->
                    <div>
                        <h3 class="text-lg font-medium text-gray-800">Detail Barang</h3>
                        <table class="min-w-full divide-y divide-gray-200 mt-4 border">
                            <thead>
                                <tr>
                                    <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Nama Barang
                                    </th>
                                    <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Jumlah
                                    </th>
                                    <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Harga Satuan
                                    </th>
                                    <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Subtotal
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach ($transaksi->detailTransaksi as $detail)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            {{ $detail->barang->nama_barang }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            {{ $detail->jumlah }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            Rp {{ number_format($detail->barang->harga_jual, 0, ',', '.') }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            Rp {{ number_format($detail->subtotal, 0, ',', '.') }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
