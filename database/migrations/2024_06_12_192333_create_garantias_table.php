<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGarantiasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('garantias', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->nullable();
            $table->string('phone_number')->nullable();
            $table->string('cep')->nullable();
            $table->string('city')->nullable();
            $table->string('neighborhood')->nullable();
            $table->string('street')->nullable();
            $table->string('house_number')->nullable();
            $table->string('tipoGarantia')->nullable();
            $table->string('nomeProduto')->nullable();
            $table->integer('tempoGarantiaProduto')->nullable();
            $table->string('servicoRealizado')->nullable();
            $table->string('modeloAparelho')->nullable();
            $table->integer('tempoGarantiaServico')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('garantias');
    }
}
