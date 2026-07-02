<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('extracted_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('work_id')->constrained('works')->cascadeOnDelete();
            $table->foreignId('memorial_id')->nullable()->constrained('memorials')->nullOnDelete();
            $table->string('item_identified')->nullable();
            $table->string('category')->nullable();
            $table->string('subcategory')->nullable();
            $table->string('environment')->nullable();
            $table->text('technical_description')->nullable();
            $table->string('suggested_unit')->nullable();
            $table->string('identified_quantity')->nullable();
            $table->string('budget_impact')->default('nao_identificado');
            $table->string('criticality')->default('nao_identificado');
            $table->string('finish_standard')->default('nao_identificado');
            $table->boolean('requires_specific_quote')->default(false);
            $table->text('textual_evidence')->nullable();
            $table->string('source_page')->nullable();
            $table->unsignedTinyInteger('confidence_score')->default(0);
            $table->text('specification_gaps')->nullable();
            $table->text('human_validation_note')->nullable();
            $table->string('validation_status')->default('pending'); // pending, approved, rejected, needs_revision
            $table->string('validated_by')->nullable();
            $table->timestamp('validated_at')->nullable();
            $table->longText('raw_payload_json')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('extracted_items');
    }
};
