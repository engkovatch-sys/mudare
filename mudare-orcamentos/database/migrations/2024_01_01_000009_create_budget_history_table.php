<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('budget_history', function (Blueprint $table) {
            $table->id();
            $table->string('category')->nullable();
            $table->string('item_name');
            $table->string('environment')->nullable();
            $table->string('unit')->nullable();
            $table->decimal('unit_price', 14, 2)->default(0);
            $table->decimal('quantity_per_m2', 12, 4)->nullable();
            $table->string('finish_standard')->default('nao_identificado');
            $table->string('city')->nullable();
            $table->string('state', 2)->nullable();
            $table->date('base_date')->nullable();
            $table->string('source')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('budget_history');
    }
};
