<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterTableIdNullableOnServerOrdersTable extends Migration
{
    public function up()
    {
        Schema::table('server_orders', function (Blueprint $table) {
            // Ne supprime pas la clé étrangère, elle n'existe pas
            // $table->dropForeign(['table_id']);

            // Modifie la colonne pour la rendre nullable
            $table->unsignedBigInteger('table_id')->nullable()->change();

            // Optionnel : si tu veux, tu peux remettre la contrainte étrangère
            // $table->foreign('table_id')->references('id')->on('tables')->onDelete('cascade');
            // Mais comme elle n'existait pas, tu peux aussi la laisser comme ça
        });
    }

    public function down()
    {
        Schema::table('server_orders', function (Blueprint $table) {
            // $table->dropForeign(['table_id']);

            $table->unsignedBigInteger('table_id')->nullable(false)->change();

            // $table->foreign('table_id')->references('id')->on('tables')->onDelete('cascade');
        });
    }
}
