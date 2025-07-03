<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateServerOrdersTable extends Migration
{
    public function up()
    {
        Schema::create('server_orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('serveur_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('table_id')->constrained('tables')->onDelete('cascade');
            $table->foreignId('food_id')->constrained('food')->onDelete('cascade');
            $table->integer('quantite');
            $table->enum('statut', ['en_attente', 'servie', 'annulée'])->default('en_attente');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('server_orders');
    }
}
