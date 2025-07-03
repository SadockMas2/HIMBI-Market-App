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
    Schema::table('food', function (Blueprint $table) {
        $table->decimal('price', 10, 2)->change(); // 10 chiffres, dont 2 après la virgule
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
