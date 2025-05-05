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
        Schema::create('internships', function (Blueprint $table) {
            $table->id();
            $table->string('id_magang')->unique();
            $table->string('nama',100);
            $table->string('no_telepon',30);
            $table->string('email',100)->unique();
            $table->string('instansi',100);
            $table->enum('jenis_kelamin', ['Laki-laki', 'Perempuan']);
            $table->date('tanggal_mulai');
            $table->date('tanggal_berakhir');
            $table->unsignedBigInteger('departemen_id');
            $table->string('pas_foto');
            $table->string('surat_rekomendasi');
            $table->enum('status', ['Pending', 'Diterima', 'Ditolak'])->default('Pending');
            $table->timestamps();

            // Foreign key constraint
            $table->foreign('departemen_id')->references('id_departemen')->on('departemens')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('internships');
    }
};
