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
        Schema::create('pembayaran', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("pemesanan_id")->nullable(false);
            $table->enum("metode_pembayaran", ['transfer', 'cash'])->nullable(false);
            $table->string("bukti_pembayaran", 512)->nullable();
            $table->timestamps();

            $table->foreign("pemesanan_id")->on("pemesanan")->references("id");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pembayaran');
    }
};
