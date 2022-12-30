<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDataDosensTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('data_dosen', function (Blueprint $table) {
            $table->id();
            $table->string('kode_dosen')->nullable();
            $table->string('nama_dosen')->nullable();
            $table->string('email_dosen')->nullable();
            $table->string('telepon_dosen')->nullable();
            $table->text('alamat_dosen')->nullable();
            $table->string('jabatan_dosen')->nullable();
            $table->foreignUuid('user_id');
            $table->timestamps();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('data_dosen');
    }
}
