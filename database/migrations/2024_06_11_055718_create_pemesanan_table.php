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
        Schema::create('pemesanan', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable(false);
            $table->string('kode_pemesanan', 100)->nullable(false);
            $table->string('nama', 100)->nullable(false);
            $table->date('tanggal')->nullable(false);
            $table->enum('lapangan', ['Lapangan 1', 'Lapangan 2', 'Lapangan 3', 'Lapangan 4'])->nullable(false);
            $table->time('waktu_mulai')->nullable(false);
            $table->time('waktu_selesai')->nullable(false);
            $table->integer('total_harga')->nullable(false);
            $table->enum('status', ['belum dibayar', 'dibayar', 'dibatalkan', 'menunggu konfirmasi'])->nullable(false);
            $table->timestamps();

            $table->foreign("user_id")->on("users")->references("id");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pemesanan');
    }
};
