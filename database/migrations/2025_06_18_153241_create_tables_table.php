<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTablesTable extends Migration
{
    public function up()
    {
        Schema::create('tables', function (Blueprint $table) {
        $table->id();
        $table->string('nom_table')->unique(); // ex: T1, T2, etc.
        $table->integer('capacite'); // nombre de personnes
        $table->enum('statut', ['Disponible', 'Occupée', 'Réservée'])->default('Disponible');
        $table->text('description')->nullable(); // ex: près de la fenêtre
        $table->timestamps();
});

    }

    public function down()
    {
        Schema::dropIfExists('tables');
    }
}

