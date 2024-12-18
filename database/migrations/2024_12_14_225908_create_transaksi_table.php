<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transaksi', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('user')->onDelete('cascade');
            $table->foreignId('buku_id')->constrained('buku')->onDelete('cascade');
            $table->enum('jenis_transaksi', ['download', 'sewa']);
            $table->integer('durasi')->default(1);
            $table->enum('metode_pembayaran', ['qris', 'ovo', 'spay', 'bca', 'briva', 'mandiri']);
            $table->decimal('total_harga', 12, 2);
            $table->enum('status', ['pending', 'success', 'failed'])->default('pending');
            $table->string('payment_token')->nullable();
            $table->timestamp('tgl_transaksi')->useCurrent();
            $table->timestamp('tgl_expired')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('transaksi');
    }
};