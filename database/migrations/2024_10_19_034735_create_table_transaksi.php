<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('transaksi', function (Blueprint $table) {
            $table->id();
            $table->string('kode_transaksi')->unique();
            $table->decimal('total_harga', 15, 2);
            $table->timestamp('tanggal')->useCurrent();
            $table->enum('status_pembayaran', ['lunas', 'hutang']);
            $table->unsignedBigInteger('id_pelanggan')->nullable();
            $table->foreign('id_pelanggan')->references('id')->on('pelanggan')->onDelete('set null');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaksi'); // Perbaiki nama tabel yang dihapus
    }
};
