<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdensTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ordems', function (Blueprint $table) {
            $table->id();
            // Campos relacionados ao cliente
            $table->string('cliente');
            $table->string('cidade');
            $table->string('cep');
            $table->string('rua');
            $table->string('numero');
            $table->string('bairro');
            // Outros campos da ordem de serviço
            $table->string('modelo');
            $table->text('problema');
            $table->string('tecnico');
            $table->string('atendente');
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
        Schema::dropIfExists('ordens');
    }
}
