<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('works', function (Blueprint $table) {
            $table->id();
            $table->foreignId('client_id')->nullable()->constrained('clients')->nullOnDelete();
            $table->foreignId('architect_id')->nullable()->constrained('architects')->nullOnDelete();
            $table->string('name');
            $table->string('address')->nullable();
            $table->string('city')->nullable();
            $table->string('state', 2)->nullable();
            $table->decimal('built_area', 12, 2)->nullable();
            $table->string('finish_standard')->default('nao_identificado');
            $table->date('budget_base_date')->nullable();
            $table->string('proposal_version')->nullable();
            $table->date('proposal_valid_until')->nullable();
            $table->string('status')->default('rascunho');
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('works');
    }
};
