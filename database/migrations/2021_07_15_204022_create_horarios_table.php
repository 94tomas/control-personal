<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHorariosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('horarios', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->id();
            $table->string('titulo');
            $table->time('hora_inicio');
            // $table->time('hora_descanso')->nullable();
            // $table->time('hora_fin_descanso')->nullable();
            $table->time('hora_fin');
            $table->integer('tolerancia');
            $table->boolean('estado')->default(true);
            $table->foreignId('cargo_id')->nullable();
            $table->foreign('cargo_id')->references('id')->on('cargos')->onDelete('set null');
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
        Schema::dropIfExists('horarios');
    }
}
