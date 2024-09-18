<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKeterampilansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('keterampilans', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('dosen_id')->nullable();
            $table->unsignedBigInteger('tendik_id')->nullable();
            $table->string('golongan');
            $table->string('pangkat');
            $table->integer('umur');
            $table->string('lama_jabatan')->nullable();
            $table->timestamps();

            $table->foreign('dosen_id')->references('id')->on('dosens')->onDelete('cascade');
            $table->foreign('tendik_id')->references('id')->on('tendiks')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('keterampilans');
    }
}
