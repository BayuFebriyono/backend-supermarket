<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('detail_transaksi', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('transaksi_id');
            $table->foreign('transaksi_id')->on('transaksis')->references('id')->onDelete('cascade');
            $table->foreignUuid('barang_id');
            $table->integer('harga_unit');
            $table->double('diskon');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detail_transaksi');
    }
};
