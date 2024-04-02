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
        Schema::create('eye_variables', function (Blueprint $table) {
            $table->id();
            $table->uuid('patient_id');
            $table->foreign('patient_id')->references('id')->on('patients')->onDelete('cascade');
            $table->enum('eye_type',['od','os']);
            $table->enum('updated_by',['pentacam','optometry']);
            $table->float('K1_D',10,2)->nullable();
            $table->float('K2_D',10,2)->nullable();
            $table->float('pachy_min',10,2)->nullable();
            $table->float('KM_D',10,2)->nullable();
            $table->float('astig_topo',10,2)->nullable();
            $table->float('Axis_flat',10,2)->nullable();
            $table->float('ac_depth',10,2)->nullable();
            $table->float('subjective_ref_sph',10,2)->nullable();
            $table->float('subjective_ref_cyl',10,2)->nullable();
            $table->float('PupilX',10,2)->nullable();
            $table->float('PupilY',10,2)->nullable();
            $table->float('subjective_ref_axis',10,2)->nullable();
            $table->float('subjective_ref_bcva',10,2)->nullable();
            $table->float('optometry_ucva',10,2)->nullable();
            $table->text('mixed_data')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('eye_variables');
    }
};
