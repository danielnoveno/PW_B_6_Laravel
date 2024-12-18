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
        Schema::create('buku', function (Blueprint $table) {
            $table->id();
            $table->string('cover_imgpath', 255)->nullable();
            $table->string('file_buku', 255)->nullable();
            $table->string('judul', 255);
            $table->string('penulis', 150)->nullable();
            $table->string('penerbit', 150)->nullable();
            $table->string('ISBN', 20)->unique();
            $table->date('tgl_terbit')->nullable();
            $table->enum('jenis_buku', ['Scifi', 'Fantasy', 'Drama', 'Politik', 'Sejarah', 'Kamus', 'Jurnal ilmiah', 'Resep']);
            $table->string('bahasa', 50)->nullable();
            $table->integer('halaman')->nullable();
            $table->text('sinopsis')->nullable();
            $table->text('deskripsi')->nullable();
            $table->decimal('harga_download', 10, 2)->nullable();
            $table->decimal('harga_sewa', 10, 2)->nullable();
            $table->decimal('rating', 3, 2)->default(0.0);
            $table->integer('review_count')->default(0);
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
        Schema::dropIfExists('buku');
    }
};
