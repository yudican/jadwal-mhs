<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDataMatakuliahsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('data_matakuliah', function (Blueprint $table) {
            $table->id();
            $table->string('kode_matakuliah', 50);
            $table->string('nama_matakuliah', 30);
            $table->integer('jumlah_sks');
            $table->foreignId('data_prodi_id')->index();
            $table->timestamps();
            $table->foreign('data_prodi_id')->references('id')->on('data_prodi')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('data_matakuliah');
    }
}
