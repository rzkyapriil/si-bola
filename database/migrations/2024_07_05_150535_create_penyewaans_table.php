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
        Schema::create('penyewaan', function (Blueprint $table) {
            $table->id('penyewaan_id');
            $table->unsignedBigInteger('user_id')->nullable(false);
            $table->unsignedBigInteger('inventaris_id')->nullable(false);
            $table->dateTime('tanggal_mulai')->nullable(false);
            $table->dateTime('tanggal_selesai')->nullable(false);
            $table->integer('total_harga')->nullable(false);
            $table->enum('metode_pembayaran', ['transfer', 'cash'])->nullable();
            $table->string('bukti_pembayaran', 512)->nullable();
            $table->enum('status', ['belum dibayar', 'dibayar', 'dibatalkan', 'menunggu konfirmasi'])->nullable(false);
            $table->timestamps();

            $table->foreign("user_id")->on("users")->references("id");
            $table->foreign("inventaris_id")->on("inventaris")->references("id");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('penyewaan');
    }
};
