<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFoodIngredientsTable extends Migration
{
    public function up()
    {
        Schema::create('food_ingredients', function (Blueprint $table) {
            $table->id();
            $table->foreignId('food_id')->constrained()->onDelete('cascade');
            $table->foreignId('ingredient_id')->constrained()->onDelete('cascade');
            $table->decimal('quantity', 8, 2); // Quantité d'ingrédient pour ce plat
            $table->string('unit')->nullable(); // Ex: g, ml, pcs
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('food_ingredients');
    }
}
