<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('prices', function (Blueprint $table) {
            $table->id();
            $table->foreignId('supplier_id')->nullable()->constrained('suppliers')->nullOnDelete();
            $table->string('item_name');
            $table->string('category')->nullable();
            $table->string('unit')->nullable();
            $table->decimal('unit_price', 14, 2)->default(0);
            $table->string('price_type')->default('estimado'); // referencial, cotado, historico, estimado
            $table->string('source')->nullable();
            $table->string('source_url')->nullable();
            $table->date('collected_at')->nullable();
            $table->date('valid_until')->nullable();
            $table->boolean('taxes_included')->default(false);
            $table->boolean('freight_included')->default(false);
            $table->string('validation_responsible')->nullable();
            $table->string('validation_status')->default('pending'); // pending, approved, rejected, needs_revision
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('prices');
    }
};
