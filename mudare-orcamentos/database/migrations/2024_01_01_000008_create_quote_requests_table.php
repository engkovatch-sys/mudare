<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('quote_requests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('work_id')->nullable()->constrained('works')->cascadeOnDelete();
            $table->foreignId('supplier_id')->nullable()->constrained('suppliers')->nullOnDelete();
            $table->foreignId('extracted_item_id')->nullable()->constrained('extracted_items')->nullOnDelete();
            $table->string('subject')->nullable();
            $table->longText('body')->nullable();
            $table->string('status')->default('draft'); // draft, sent, responded, cancelled
            $table->timestamp('sent_at')->nullable();
            $table->timestamp('response_received_at')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('quote_requests');
    }
};
