<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Profit') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <form method="GET" action="{{ route('profit.filter') }}">
                        <div class="flex items-center">
                            <input type="text" name="filter_value" class="form-control"
                                   placeholder="Masukkan (YYYY-MM-DD / YYYY-MM / YYYY)" 
                                   value="{{ request('filter_value') }}" required>
                            <button type="submit" class="btn btn-primary ml-2">Filter</button>
                        </div>
                    </form>
                    

                    <br>

                    <table class="table-auto w-full border-collapse border border-gray-200">
                        <thead>
                            <tr class="bg-gray-200">
                                <th class="border px-4 py-2">Kode Transaksi</th>
                                <th class="border px-4 py-2">Tanggal</th>
                                <th class="border px-4 py-2">Total Harga</th>
                                <th class="border px-4 py-2">Profit</th>
                                <th class="border px-4 py-2">Detail Transaksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($profits as $profit)
                                <tr>
                                    <td class="border px-4 py-2">{{ $profit['kode_transaksi'] }}</td>
                                    <td class="border px-4 py-2">{{ \Carbon\Carbon::parse($profit['tanggal'])->format('d-m-Y H:i:s') }}</td>
                                    <td class="border px-4 py-2">Rp {{ number_format($profit['total_harga'], 2) }}</td>
                                    <td class="border px-4 py-2">Rp {{ number_format($profit['profit'], 2) }}</td>
                                    <td class="border px-4 py-2">
                                        <ul>
                                            @foreach ($profit['details'] as $detail)
                                                <li>
                                                    {{ $detail['nama_barang'] }} - {{ $detail['jumlah'] }} unit - 
                                                    Subtotal: Rp {{ number_format($detail['subtotal'], 2) }}
                                                </li>
                                            @endforeach
                                        </ul>
                                    </td>
                                </tr>
                            @endforeach
                            <tr>
                                <td class="border px-4 py-2"><b>Total Profit</td>
                                <td class="border px-4 py-2" colspan="5"><p class="text-xl font-bold text-green-600 text-end">Rp {{ number_format($totalProfit, 2) }}</p></td>
                            </tr>
                        </tbody>
                    </table>
                    
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
