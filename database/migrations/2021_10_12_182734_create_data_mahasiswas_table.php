<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDataMahasiswasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('data_mahasiswa', function (Blueprint $table) {
            $table->id();
            $table->string('kode_mahasiswa')->nullable();
            $table->string('nama_mahasiswa')->nullable();
            $table->string('email_mahasiswa')->nullable();
            $table->string('telepon_mahasiswa')->nullable();
            $table->text('alamat_mahasiswa')->nullable();
            $table->foreignUuid('user_id');
            $table->foreignId('data_prodi_id')->index();
            $table->foreignId('data_semester_id')->index()->nullable();
            $table->timestamps();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
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
        Schema::dropIfExists('data_mahasiswa');
    }
}
