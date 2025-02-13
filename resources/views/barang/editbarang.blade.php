<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Data Barang') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead>

                                <tr>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Nama Barang</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Stok</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Harga Beli</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Harga Jual</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Action</th>
                                </tr>
                            </thead>

                            <tbody class="bg-white divide-y divide-gray-200">
                                <form action="{{ route('barang.update', ['id' => $barangs->id]) }}" method="POST"
                                    enctype="multipart/form-data">
                                    @csrf
                                    @method('PUT')
                                    <tr>
                                        <td class="px-6 py-4 whitespace-no-wrap text-sm text-gray-900">
                                            <input type="text" class="form-control" name="nama_barang"
                                                value={{ $barangs->nama_barang }}>
                                        </td>
                                        <td class="px-6 py-4 whitespace-no-wrap text-sm text-gray-900">
                                            <input type="text" class="form-control" name="stok"
                                                value={{ $barangs->stok }}>
                                        </td>
                                        <td class="px-6 py-4 whitespace-no-wrap text-sm text-gray-900">
                                            <input type="text" class="form-control" name="harga_beli"
                                                value={{ $barangs->harga_beli }}>
                                        </td>
                                        <td class="px-6 py-4 whitespace-no-wrap text-sm text-gray-900">
                                            <input type="text" class="form-control" name="harga_jual"
                                                value={{ $barangs->harga_jual }}>
                                        </td>
                                        <td class="px-6 py-4 whitespace-no-wrap text-sm text-gray-900">

                                            <button class="btn btn-warning" name="submit" type="submit"
                                               ><i class="fa-solid fa-floppy-disk"></i> Save</button>
                                        </td>
                                    </tr>
                                </form>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
