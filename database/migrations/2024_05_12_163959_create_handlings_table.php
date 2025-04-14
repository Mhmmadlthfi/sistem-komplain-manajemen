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
        Schema::create('handlings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('complaint_id');
            $table->foreignId('sale_id');
            $table->foreignId('user_id');
            $table->date('handling_date');
            $table->date('reschedule_date')->nullable();
            $table->text('description')->nullable();
            $table->text('initial_condition')->nullable(); // Kondsi Awal
            $table->text('action')->nullable(); // Tindakan yang dilakukan
            $table->text('repair_result')->nullable(); // Hasil Perbaikan
            $table->text('repair_notes')->nullable(); // Catatan Perbaikan
            $table->string('repair_evidence')->nullable(); // Bukti Perbaikan
            $table->enum('status', ['Dalam penanganan', 'Tidak dapat diperbaiki', 'Penjadwalan ulang', 'Sudah diperbaiki'])->default('Dalam penanganan');
            $table->string('handling_location')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('handlings');
    }
};
