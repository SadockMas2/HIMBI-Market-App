<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
   public function up()
{
    Schema::create('food_ingredients', function (Blueprint $table) {
        $table->id();
        $table->foreignId('food_id')->constrained('food')->onDelete('cascade');
        $table->foreignId('ingredient_id')->constrained('ingredients')->onDelete('cascade');
        $table->string('unit')->nullable();
        $table->decimal('quantity_required', 8, 2); // Quantité d'ingrédient pour 1 plat
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('food_ingredients');
    }
};
