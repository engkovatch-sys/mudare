<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('budget_alerts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('work_id')->constrained('works')->cascadeOnDelete();
            $table->foreignId('extracted_item_id')->nullable()->constrained('extracted_items')->nullOnDelete();
            $table->string('alert_type');
            $table->text('description')->nullable();
            $table->string('severity')->default('informativo'); // informativo, baixo, medio, alto, critico
            $table->string('category')->nullable();
            $table->string('environment')->nullable();
            $table->string('current_value')->nullable();
            $table->string('reference_value')->nullable();
            $table->decimal('deviation_percentage', 8, 2)->nullable();
            $table->text('evidence')->nullable();
            $table->text('recommended_action')->nullable();
            $table->boolean('human_validation_required')->default(true);
            $table->timestamp('resolved_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('budget_alerts');
    }
};
