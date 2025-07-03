<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaymentsTable extends Migration
{
    public function up()
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('order_id');   // Référence commande
            $table->unsignedBigInteger('serveur_id'); // Référence serveur
            $table->decimal('amount', 10, 2);          // Montant payé
            $table->timestamp('payment_date')->useCurrent(); // Date paiement
            $table->string('payment_method')->nullable(); // Optionnel (espèces, carte...)
            $table->enum('status', ['en_attente', 'payé', 'annulé'])->default('en_attente');
            $table->timestamps();

            // Clés étrangères
            $table->foreign('order_id')->references('id')->on('orders')->onDelete('cascade');
            $table->foreign('serveur_id')->references('id')->on('users')->onDelete('cascade'); // supposition users
        });
    }

    public function down()
    {
        Schema::dropIfExists('payments');
    }
}
