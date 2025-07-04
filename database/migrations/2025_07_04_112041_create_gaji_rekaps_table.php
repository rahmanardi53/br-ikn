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
        Schema::create('gaji_rekaps', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->date('periode_awal'); // contoh: 2025-07-01
            $table->date('periode_akhir'); // contoh: 2025-07-07
            $table->decimal('total_jam', 5, 2);
            $table->bigInteger('gaji_pokok');
            $table->bigInteger('bonus')->default(0);
            $table->bigInteger('total_gaji');
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gaji_rekaps');
    }
};
