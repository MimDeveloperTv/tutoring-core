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
        Schema::create('appointments', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('booking_id');
            $table->uuid('operator_id');
            $table->foreign('operator_id')->references('id')->on('operators')->onDelete('cascade');
            $table->uuid('patient_id');
            $table->foreign('patient_id')->references('id')->on('patients')->onDelete('cascade');
            $table->string('service');
            $table->string('place');
            $table->string('address');
            $table->enum('payment_status',['PENDING','SUCCESS','FAILED'])->default('PENDING');
            $table->enum('status',['NEW','CANCELED','COMPLETED','REVIEWED'])->default('NEW');
            $table->decimal('amount',14,2,false);
            $table->string('currency');
            $table->integer('from');
            $table->integer('to');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('appointments');
    }
};
