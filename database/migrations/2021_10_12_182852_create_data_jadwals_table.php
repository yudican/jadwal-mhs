<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDataJadwalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('data_jadwal', function (Blueprint $table) {
            $table->id();
            $table->string('kode_jadwal')->nullable();
            $table->string('waktu_jadwal')->nullable();
            $table->string('hari_jadwal')->nullable();
            $table->foreignId('data_matakuliah_id');
            $table->foreignId('data_kelas_id');
            $table->foreignId('data_dosen_id');
            $table->foreignId('data_prodi_id')->index();
            $table->foreignId('data_semester_id')->index()->nullable();
            $table->timestamps();
            $table->foreign('data_matakuliah_id')->references('id')->on('data_matakuliah')->onDelete('cascade');
            $table->foreign('data_kelas_id')->references('id')->on('data_kelas')->onDelete('cascade');
            $table->foreign('data_dosen_id')->references('id')->on('data_dosen')->onDelete('cascade');
            $table->foreign('data_prodi_id')->references('id')->on('data_prodi')->onDelete('cascade');
            $table->foreign('data_semester_id')->references('id')->on('data_semester')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('data_jadwal');
    }
}
