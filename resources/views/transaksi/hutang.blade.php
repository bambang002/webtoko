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
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead>
                            <tr>
                                <th class="px-6 py-3 bg-gray-50 text-left">#</th>
                                <th class="px-6 py-3 bg-gray-50 text-left">Nama</th>
                                
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($pelanggans as $pelanggan)
                                <tr>
                                    <td class="px-6 py-4 text-sm text-gray-900">{{ $loop->iteration }}</td>
                                    <td>
                                    <a href="{{ route('transaksi.detailhutang', $pelanggan->id) }}">{{ $pelanggan->nama }}</a>
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

