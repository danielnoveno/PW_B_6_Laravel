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
        Schema::create('user', function (Blueprint $table) {
            $table->id();
            $table->string('nama_depan', 100);
            $table->string('nama_belakang', 100);
            $table->string('email', 150)->unique();
            $table->string('no_telp', 15)->nullable();
            $table->date('tgl_lahir')->nullable();
            $table->enum('jenis_kelamin', ['L', 'P']);
            $table->string('sandi');
            $table->text('bookmark')->nullable();
            $table->text('unduhan')->nullable();
            $table->integer('buku_terakhir_dibaca')->nullable();
            $table->text('rekomendasi')->nullable();
            $table->text('kategori')->nullable();
            $table->json('digilibrary')->nullable();
            $table->string('profilePic')->nullable();
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
        Schema::dropIfExists('user');
    }
};
