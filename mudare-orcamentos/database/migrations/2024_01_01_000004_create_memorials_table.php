<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('memorials', function (Blueprint $table) {
            $table->id();
            $table->foreignId('work_id')->constrained('works')->cascadeOnDelete();
            $table->string('original_filename')->nullable();
            $table->string('stored_path')->nullable();
            $table->longText('extracted_text')->nullable();
            $table->longText('manual_text')->nullable();
            $table->string('extraction_mode')->default('manual_text'); // pdf_auto, manual_text, mixed
            $table->string('processing_status')->default('pending'); // pending, processing, processed, failed
            $table->timestamp('processed_at')->nullable();
            $table->text('error_message')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('memorials');
    }
};
