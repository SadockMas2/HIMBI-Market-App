<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            if (!Schema::hasColumn('orders', 'food_id')) {
                $table->unsignedBigInteger('food_id')->nullable()->after('id');
                $table->foreign('food_id')->references('id')->on('food')->onDelete('set null');
            }

            if (!Schema::hasColumn('orders', 'quantity')) {
                $table->integer('quantity')->default(1);
            }
        });
    }

    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            if (Schema::hasColumn('orders', 'food_id')) {
                $table->dropForeign(['food_id']);
                $table->dropColumn('food_id');
            }

            if (Schema::hasColumn('orders', 'quantity')) {
                $table->dropColumn('quantity'); // ou revenir à string si besoin
            }
        });
    }
};
