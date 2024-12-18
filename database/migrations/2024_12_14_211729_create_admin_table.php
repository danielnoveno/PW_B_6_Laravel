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
        Schema::create('admin', function (Blueprint $table) {
            $table->id();
            $table->string('nama', 100);
            $table->string('email', 150)->unique();
            $table->string('no_telp', 15)->nullable();
            $table->string('sandi');
            $table->integer('total_pengguna')->default(0);
            $table->integer('total_buku_terpinjam')->default(0);
            $table->integer('total_buku_terunduh')->default(0);
            $table->integer('total_buku_terunggah')->default(0);
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
        Schema::dropIfExists('admin');
    }
};
