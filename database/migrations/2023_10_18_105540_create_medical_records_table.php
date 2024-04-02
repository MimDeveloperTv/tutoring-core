<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('medical_records', function (Blueprint $table) {
            $table->id();
            $table->uuid('patient_id');
            $table->uuid('prescriber_id');
            $table->unsignedBigInteger('prescription_id');
            $table->string('prescription_type');
            $table->string('prescription_name');
            $table->string('service_item')->nullable();
            $table->uuid('operator_id')->nullable();
            $table->enum('status',['NEW','DRAFT','SUBMIT'])->default('NEW');
            $table->uuid('created_by')->nullable();
            $table->text('record')->nullable();
            $table->string('calculation')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('medical_records');
    }
};
