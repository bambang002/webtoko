<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Tambah Transaksi') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto flex justify-center sm:px-12 lg:px-18">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="overflow-hidden overflow-x-auto p-6 bg-white border-b border-gray-200">
                    <form action="{{ route('transaksi.store') }}" method="POST">
                        @csrf
                        <div class="min-w-full align-middle">
                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

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
                                                class="text-xs leading-4 font-medium text-black-500 uppercase tracking-wider">Jumlah</span>
                                        </th>
                                        <th class="px-6 py-3 bg-black-50 text-left">
                                            <span
                                                class="text-xs leading-4 font-medium text-black-500 uppercase tracking-wider">Harga
                                                Jual</span>
                                        </th>
                                        <th class="px-6 py-3 bg-black-50 text-left">
                                            <span
                                                class="text-xs leading-4 font-medium text-black-500 uppercase tracking-wider">Subtotal</span>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200 divide-solid">
                                    <tr class="bg-white" id="barang-row-0">
                                        <td class="px-7 py-6 whitespace-no-wrap text-sm leading-5 text-gray-900">
                                            <!-- Dropdown Select2 -->
                                            <select class="form-control select-barang select2" name="barangs[0][id]"
                                                onchange="updateHarga(0)" required>
                                                <option value="">Pilih</option>
                                                @foreach ($barangs as $barang)
                                                    <option value="{{ $barang->id }}"
                                                        data-harga="{{ $barang->harga_jual }}">
                                                        {{ $barang->nama_barang }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td class="px-6 py-4 whitespace-no-wrap text-sm leading-5 text-gray-900">
                                            <input type="number" name="barangs[0][jumlah]" id="jumlah-0"
                                                value="1" min="1" onchange="updateHarga(0)" required>
                                        </td>
                                        <td class="px-6 py-4 whitespace-no-wrap text-sm leading-5 text-gray-900">
                                            <input type="text" class="form-control" id="harga-0" value="0"
                                                readonly>
                                        </td>
                                        <td class="px-6 py-4 whitespace-no-wrap text-sm leading-5 text-gray-900">
                                            <input type="text" class="form-control" id="subtotal-0"
                                                name="barangs[0][subtotal]" value="0" readonly>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <br>
                        <button type="button" class="btn btn-info" onclick="addBarangRow()">Tambah Barang</button>
                        <br><br>
                        <div class="flex justify-between">
                            <div class="flex items-center">
                                <label for="total_harga" class="mr-2">Total Harga:</label>
                                <input type="text" id="total_harga" name="total_harga" value="0" readonly
                                    class="form-control">
                            </div>
                        </div>

                        <!-- Status Pembayaran -->
                        <div class="form-group">
                            <label for="status_pembayaran">Status Pembayaran</label>
                            <select name="status_pembayaran" id="status_pembayaran" class="form-control"
                                onchange="togglePelangganInput()" required>
                                <option value="lunas">Lunas</option>
                                <option value="hutang">Hutang</option>
                            </select>
                        </div>

                        <!-- Input Pelanggan untuk Hutang -->
                        <div class="form-group" id="pelanggan-input" style="display: none;">
                            <label for="id_pelanggan">Pilih Pelanggan</label>
                            <select name="id_pelanggan" id="id_pelanggan" class="form-control"
                                onchange="toggleNewPelangganInput()">
                                <option value="">Pilih Pelanggan</option>
                                @foreach ($pelanggans as $pelanggan)
                                    <option value="{{ $pelanggan->id }}">{{ $pelanggan->nama }}</option>
                                @endforeach
                            </select>
                            <button type="button" class="btn btn-info mt-2" id="add-new-pelanggan-btn"
                                onclick="showNewPelangganForm()">Tambah Pelanggan Baru</button>
                        </div>

                        <!-- Form untuk Pelanggan Baru -->
                        <div id="new-pelanggan-form" class="form-group" style="display: none;">
                            <label for="new_pelanggan_nama">Nama Pelanggan Baru</label>
                            <input type="text" id="new_pelanggan_nama" name="new_pelanggan_nama"
                                class="form-control">
                        </div>



                        <br><br><br>
                        <button class="btn btn-success" type="submit" name="submit" value="submit">
                            <i class="fa-solid fa-floppy-disk"></i> Simpan
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

<script>
    const barangs = @json($barangs);

    $(document).ready(function() {
    $('.select2').select2({
        placeholder: "Cari nama barang...",
        allowClear: true
    });
});

// Fungsi pencarian untuk input eksternal
function searchBarang() {
    var input, filter, select, options, i;
    input = document.getElementById("searchBarang");
    filter = input.value.toUpperCase();
    select = document.querySelector("select[name='barangs[0][id]']");
    options = select.options;

    for (i = 0; i < options.length; i++) {
        var optionText = options[i].textContent || options[i].innerText;
        if (optionText.toUpperCase().indexOf(filter) > -1) {
            options[i].style.display = "";
        } else {
            options[i].style.display = "none";
        }
    }
}


    document.querySelector('form').addEventListener('submit', function(e) {
        console.log('Data yang dikirim:', {
            barangs: Array.from(document.querySelectorAll('[name^="barangs"]')).map(input => input
                .value),
            total_harga: document.getElementById('total_harga').value,
            tanggal: document.getElementById('tanggal').value,
            status_pembayaran: document.getElementById('status_pembayaran').value,
            id_pelanggan: document.getElementById('id_pelanggan').value,
            new_pelanggan_nama: document.getElementById('new_pelanggan_nama').value,
        });
        this.submit(); // Lanjutkan submit setelah debugging
    });

    function updateHarga(index) {
        const barangSelect = document.querySelector(`select[name="barangs[${index}][id]"]`);
        const jumlahInput = document.querySelector(`#jumlah-${index}`);
        const hargaBarang = barangSelect.options[barangSelect.selectedIndex].dataset.harga;
        const subtotalInput = document.querySelector(`#subtotal-${index}`);
        const hargaInput = document.querySelector(`#harga-${index}`);
        const jumlah = jumlahInput.value;

        if (hargaBarang && jumlah > 0) {
            const subtotal = hargaBarang * jumlah;
            subtotalInput.value = subtotal;
            hargaInput.value = hargaBarang;
            updateTotalHarga();
        }
    }

    function updateTotalHarga() {
        const subtotalInputs = document.querySelectorAll('[id^="subtotal-"]');
        let totalHarga = 0;

        subtotalInputs.forEach(input => {
            totalHarga += parseFloat(input.value || 0);
        });

        document.querySelector('#total_harga').value = totalHarga;
    }

    // Menyaring barang berdasarkan pencarian
function filterBarang() {
    const filter = document.getElementById("searchBarang").value.toUpperCase();
    const selects = document.querySelectorAll('.select-barang'); // Pilih semua dropdown barang
    
    selects.forEach(select => {
        const options = select.options;
        
        // Loop untuk menyaring nama barang dalam dropdown
        for (let i = 0; i < options.length; i++) {
            const optionText = options[i].textContent || options[i].innerText;
            if (optionText.toUpperCase().indexOf(filter) > -1) {
                options[i].style.display = ""; // Tampilkan opsi yang cocok
            } else {
                options[i].style.display = "none"; // Sembunyikan opsi yang tidak cocok
            }
        }
    });
}
function addBarangRow() {
    const container = document.querySelector('tbody');
    const index = container.children.length;

    let barangOptions = '<option value="">Pilih</option>';
    barangs.forEach(barang => {
        barangOptions +=
            `<option value="${barang.id}" data-harga="${barang.harga_jual}">${barang.nama_barang}</option>`;
    });

    const row = `
        <tr class="bg-white" id="barang-row-${index}">
            <td class="px-7 py-6 whitespace-no-wrap text-sm leading-5 text-gray-900">
                <select class="form-control select-barang select2" name="barangs[${index}][id]" onchange="updateHarga(${index})" required>
                    ${barangOptions}
                </select>
            </td>
            <td class="px-6 py-4 whitespace-no-wrap text-sm leading-5 text-gray-900">
                <input type="number" name="barangs[${index}][jumlah]" id="jumlah-${index}" value="1" min="1" onchange="updateHarga(${index})" required>
            </td>
            <td class="px-6 py-4 whitespace-no-wrap text-sm leading-5 text-gray-900">
                <input type="text" class="form-control" id="harga-${index}" value="0" readonly>
            </td>
            <td class="px-6 py-4 whitespace-no-wrap text-sm leading-5 text-gray-900">
                <input type="text" class="form-control" id="subtotal-${index}" name="barangs[${index}][subtotal]" value="0" readonly>
            </td>
        </tr>`;

    // Gunakan insertAdjacentHTML agar data sebelumnya tidak ter-reset
    container.insertAdjacentHTML('beforeend', row);

    // Re-inisialisasi Select2 setelah menambah baris baru
    $('.select2').select2({
        placeholder: "Cari nama barang...",
        allowClear: true
    });
}



    // Fungsi untuk mengatur visibilitas input pelanggan
    function togglePelangganInput() {
        const status = document.getElementById('status_pembayaran').value;
        const pelangganInput = document.getElementById('pelanggan-input');
        pelangganInput.style.display = status === 'hutang' ? 'block' : 'none';
    }

    // Fungsi untuk menampilkan form pelanggan baru jika diperlukan
    function toggleNewPelangganInput() {
        const pelangganSelect = document.getElementById('id_pelanggan');
        const addNewPelangganBtn = document.getElementById('add-new-pelanggan-btn');
        if (!pelangganSelect.value) {
            addNewPelangganBtn.style.display = 'inline-block';
        } else {
            addNewPelangganBtn.style.display = 'none';
        }
    }

    // Fungsi untuk menampilkan form pelanggan baru
    function showNewPelangganForm() {
        const newPelangganForm = document.getElementById('new-pelanggan-form');
        const pelangganSelect = document.getElementById('id_pelanggan');
        const addNewPelangganBtn = document.getElementById('add-new-pelanggan-btn');

        newPelangganForm.style.display = 'block';
        pelangganSelect.style.display = 'none';
        pelangganSelect.required = false;
        addNewPelangganBtn.style.display = 'none';
    }

    // Mengupdate harga dan subtotal barang
    function updateHarga(index) {
        const barangSelect = document.querySelector(`select[name="barangs[${index}][id]"]`);
        const jumlahInput = document.querySelector(`#jumlah-${index}`);
        const hargaBarang = barangSelect.options[barangSelect.selectedIndex].dataset.harga;
        const subtotalInput = document.querySelector(`#subtotal-${index}`);
        const hargaInput = document.querySelector(`#harga-${index}`);
        const jumlah = jumlahInput.value;

        if (hargaBarang && jumlah > 0) {
            const subtotal = hargaBarang * jumlah;
            subtotalInput.value = subtotal;
            hargaInput.value = hargaBarang;
            updateTotalHarga();
        }
    }

    // Menghitung total harga
    function updateTotalHarga() {
        const subtotalInputs = document.querySelectorAll('[id^="subtotal-"]');
        let totalHarga = 0;

        subtotalInputs.forEach(input => {
            totalHarga += parseFloat(input.value || 0);
        });

        document.querySelector('#total_harga').value = totalHarga;
    }
</script>
