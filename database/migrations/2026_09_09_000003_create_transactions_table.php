<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->string('no_invoice', 50)->unique();
            $table->foreignId('user_id')->constrained('users')->restrictOnDelete();
            $table->integer('total_bayar');
            $table->integer('jumlah_bayar');
            $table->integer('kembalian');
            $table->string('metode_bayar', 50)->default('Cash');
            $table->dateTime('tanggal');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
