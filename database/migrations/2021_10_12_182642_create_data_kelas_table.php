<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDataKelasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('data_kelas', function (Blueprint $table) {
            $table->id();
            $table->string('kode_kelas', 50);
            $table->string('nama_kelas', 30);
            $table->foreignId('data_prodi_id')->index();
            $table->foreignId('data_semester_id')->index()->nullable();
            $table->timestamps();
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
        Schema::dropIfExists('data_kelas');
    }
}
