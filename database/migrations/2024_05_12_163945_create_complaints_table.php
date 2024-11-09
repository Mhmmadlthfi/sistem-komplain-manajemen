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
        Schema::create('complaints', function (Blueprint $table) {
            $table->id();
            $table->string('reporter');
            $table->string('serial_number');
            $table->string('location');
            $table->text('description');
            $table->string('telp');
            $table->string('institution');
            $table->date('date');
            $table->enum('status', ['Diterima', 'Tidak Valid', 'Diproses', 'Tidak dapat diperbaiki', 'Selesai'])->default('Diterima');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('complaints');
    }
};
