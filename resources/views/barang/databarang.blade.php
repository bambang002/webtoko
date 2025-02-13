<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Data Barang') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">

                    <div class="flex justify-between mb-4">
                        <div>
                            <a href="{{ route('barang.create') }}" class="btn btn-outline-info mr-2"><i
                                    class="fa-solid fa-plus"></i> Barang</a>
                            <button class="btn btn-outline-success" data-toggle="modal" data-target="#importModal"><i
                                    class="mdi mdi-file-excel"></i><i class="fa-regular fa-file-excel"></i> Import Excel
                            </button>
                            <div class="modal fade" id="importModal" tabindex="-1" role="dialog"
                                aria-labelledby="importModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="importModalLabel">Import Excel</h5>
                                            <button type="button" class="close" data-dismiss="modal"
                                                aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <form action="{{ route('import-barang-excel') }}" method="POST"
                                            enctype="multipart/form-data">
                                            @csrf
                                            <div class="modal-body">
                                                <div class="form-group">
                                                    <label for="file">Choose Excel File</label>
                                                    <input type="file" class="form-control-file " id="file"
                                                        name="file" required>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-danger"
                                                    data-dismiss="modal">Close</button>
                                                <button type="submit" class="btn btn-primary">Import</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <form action="" method="GET">
                            <div class="input-group" style="max-width: 200px;">
                                <input type="text" name="search" id="search" value="{{ $search }}"
                                    class="form-control" placeholder="Cari.........." aria-label="Recipient's username"
                                    aria-describedby="basic-addon2" />
                                <div class="input-group-append">
                                    <button class="btn btn-sm btn-primary" type="submit"> <i class="fa-solid fa-magnifying-glass"></i> </button>
                                </div>
                            </div>
                        </form>
                    </div>

                    <!-- Tabel Responsif -->
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead>
                                @php
                                    $no = +1;
                                @endphp
                                <tr>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        No</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        @sortablelink('nama_barang', 'Nama Barang')</th>
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
                                @forelse ($barangs as $barang)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-no-wrap text-sm text-gray-900">
                                            {{ $no++ }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-no-wrap text-sm text-gray-900">
                                            {{ $barang->nama_barang }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-no-wrap text-sm text-gray-900">
                                            {{ $barang->stok }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-no-wrap text-sm text-gray-900">
                                            Rp {{ number_format($barang->harga_beli, 0, ',', '.') }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-no-wrap text-sm text-gray-900">
                                            Rp {{ number_format($barang->harga_jual, 0, ',', '.') }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-no-wrap text-sm text-gray-900">
                                            <!-- Form Delete -->
                                            <form id="delete-form-{{ $barang->id }}"
                                                action="{{ route('barang.destroy', $barang->id) }}" method="POST"
                                                style="display: none;">
                                                @csrf
                                                @method('DELETE')
                                            </form>
                                            <button type="button" onclick="confirmDelete({{ $barang->id }})"
                                                class="btn btn-danger">
                                                <i class="fa-solid fa-trash"></i>
                                            </button>

                                            <a class="btn btn-warning"
                                                href="{{ route('barang.editbarang', ['id' => $barang->id]) }}"><i
                                                    class="fa-solid fa-pen"></i></a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="px-6 py-4 text-center text-gray-500">Tidak ada data
                                            barang</td>
                                    </tr>
                                @endforelse
                            </tbody>

                            </tbody>
                        </table>
                    </div>

                    {!! $barangs->appends(Request::except('page'))->render() !!}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
<script>
    function confirmDelete(id) {
        Swal.fire({
            title: 'Yakin mau dihapus?',
            text: "Dah dihapus gak bisa di balikin!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, Hapus!'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('delete-form-' + id).submit();
            }
        });
    }
</script>
