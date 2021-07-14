<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmpleadosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('empleados', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->id();
            $table->string('cod_empleado')->unique();
            $table->string('nombres');
            $table->string('apellidos', 100);
            $table->string('direccion');
            $table->string('tel_cel', 20);
            $table->date('fecha_nacimiento');
            $table->enum('genero', ['hombre', 'mujer']);
            $table->boolean('estado')->default(true);
            $table->foreignId('cargo_id');
            $table->foreign('cargo_id')->references('id')->on('cargos')->onDelete('cascade');
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
        Schema::dropIfExists('empleados');
    }
}
