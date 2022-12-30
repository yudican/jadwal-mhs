<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFormJadwalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('form_jadwal', function (Blueprint $table) {
            $table->id();
            $table->text('alasan_perubahan')->nullable();
            $table->string('hari_perubahan')->nullable();
            $table->string('jam_perubahan')->nullable();
            $table->char('status', 1)->nullable()->default(0);
            $table->text('keterangan')->nullable();
            $table->foreignId('data_kelas_id');
            $table->foreignId('data_dosen_id');
            $table->foreignId('data_jadwal_id');
            $table->timestamps();
            $table->foreign('data_kelas_id')->references('id')->on('data_kelas')->onDelete('cascade');
            $table->foreign('data_dosen_id')->references('id')->on('data_dosen')->onDelete('cascade');
            $table->foreign('data_jadwal_id')->references('id')->on('data_jadwal')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('form_jadwal');
    }
}
