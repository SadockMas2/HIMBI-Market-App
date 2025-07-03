<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('tables', function (Blueprint $table) {
            $table->unsignedBigInteger('serveur_id')->nullable()->after('nom_table');

            // Clé étrangère vers la table users (serveurs)
            $table->foreign('serveur_id')->references('id')->on('users')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::table('tables', function (Blueprint $table) {
            $table->dropForeign(['serveur_id']);
            $table->dropColumn('serveur_id');
        });
    }
};
