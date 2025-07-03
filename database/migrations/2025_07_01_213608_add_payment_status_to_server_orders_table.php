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
        Schema::table('server_orders', function (Blueprint $table) {
            $table->enum('payment_status', ['non_payé', 'payé'])->default('non_payé');
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('server_orders', function (Blueprint $table) {
            //
        });
    }
};
