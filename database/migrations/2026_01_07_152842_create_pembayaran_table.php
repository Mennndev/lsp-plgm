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
            $table->unsignedInteger('pengajuan_skema_id');
            $table->foreign('pengajuan_skema_id')->references('id')->on('pengajuan_skema')->onDelete('cascade');
            $table->unsignedInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->decimal('nominal', 12, 2);
            $table->string('metode_pembayaran')->default('transfer_bank');
            $table->string('bank_tujuan')->nullable();
            $table->string('nomor_rekening')->nullable();
            $table->string('atas_nama')->nullable();
            $table->string('bukti_pembayaran')->nullable();
            $table->timestamp('tanggal_upload')->nullable();
            $table->timestamp('tanggal_verifikasi')->nullable();
            $table->enum('status', ['pending', 'uploaded', 'verified', 'rejected'])->default('pending');
            $table->text('catatan_admin')->nullable();
            $table->unsignedInteger('verified_by')->nullable();
            $table->foreign('verified_by')->references('id')->on('users')->onDelete('set null');
            $table->timestamp('batas_waktu_bayar')->nullable();
            $table->timestamps();
            
            $table->index(['user_id', 'status']);
            $table->index('pengajuan_skema_id');
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
