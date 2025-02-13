<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Tambah Barang') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto flex justify-center sm:px-12 lg:px-18">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="overflow-hidden overflow-x-auto p-6 bg-white border-b border-gray-200">
                    <div class="min-w-full align-middle">
                        <table class="min-w-full divide-y divide-gray-200 border">
                            <thead>
                                <tr>
                                    <th class="px-6 py-3 bg-black-50 text-left">
                                        <span
                                            class="text-xs leading-4 font-medium text-black-500 uppercase tracking-wider">Nama
                                            Barang</span>
                                    </th>
                                    <th class="px-6 py-3 bg-black-50 text-left">
                                        <span
                                            class="text-xs leading-4 font-medium text-black-500 uppercase tracking-wider">Stok</span>
                                    </th>
                                    <th class="px-6 py-3 bg-black-50 text-left">
                                        <span
                                            class="text-xs leading-4 font-medium text-black-500 uppercase tracking-wider">Harga
                                            Beli</span>
                                    </th>
                                    <th class="px-6 py-3 bg-black-50 text-left">
                                        <span
                                            class="text-xs leading-4 font-medium text-black-500 uppercase tracking-wider">Harga
                                            Jual</span>
                                    </th>
                                </tr>
                            </thead>
                            <form action="{{ route('barang.store') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <tbody class="bg-white divide-y divide-gray-200 divide-solid">

                                    @for ($i=0; $i <5; $i++)

                                    <tr class="bg-white">
                                        <td class="px-6 py-4 whitespace-no-wrap text-sm leading-5 text-gray-900">
                                            <input type="text" class="form-control input" name="data[{{$i}}][nama_barang]"
                                                placeholder="Nama Barang">
                                        </td>
                                        <td class="px-6 py-4 whitespace-no-wrap text-sm leading-5 text-gray-900">
                                            <input type="text" class="form-control input" name="data[{{$i}}][stok]"
                                                placeholder="Stok">
                                        </td>
                                        <td class="px-6 py-4 whitespace-no-wrap text-sm leading-5 text-gray-900">
                                            <input type="text" class="form-control input" name="data[{{$i}}][harga_beli]"
                                                placeholder="Harga Beli">
                                        </td>
                                        <td class="px-6 py-4 whitespace-no-wrap text-sm leading-5 text-gray-900">
                                            <input type="text" class="form-control input" name="data[{{$i}}][harga_jual]"
                                                placeholder="Harga Jual">
                                        </td>
                                    </tr>
                                    @endfor

                                </tbody>
                        </table>
                    </div>
                    <br>
                    <button class="btn btn-info" type="submit" name="submit" value="submit"><i class="fa-solid fa-floppy-disk"></i> Simpan</button>
                    </form>

                </div>

            </div>
        </div>
    </div>
    </div>
</x-app-layout>
