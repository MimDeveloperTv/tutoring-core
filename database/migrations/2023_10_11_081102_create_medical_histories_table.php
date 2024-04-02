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
        Schema::create('medical_histories', function (Blueprint $table) {
            $table->id();
            $table->uuid('patient_id');
            $table->foreign('patient_id')->references('id')->on('patients')->onDelete('cascade');
            $table->boolean('dryness')->default(0);
            $table->boolean('chronic_tearing')->default(0);
            $table->boolean('chronic_allergy')->default(0);
            $table->boolean('blepharitis')->default(0);
            $table->boolean('contact_lens_use')->default(0);
            $table->boolean('recurrent_corneal_erosion')->default(0);
            $table->boolean('previous_ocular_trauma')->default(0);
            $table->boolean('previous_ocular_surgery')->default(0);
            $table->boolean('any_other_ocular_diseases')->default(0);
            $table->boolean('diabetes')->default(0);
            $table->boolean('blood_pressure')->default(0);
            $table->boolean('known_medication_allergy')->default(0);
            $table->boolean('known_allergy_to_food_metals_or_others')->default(0);
            $table->boolean('collagen_systemic_diseases')->default(0);
            $table->boolean('use_of_anti_coagulants')->default(0);
            $table->boolean('or_steroids')->default(0);
            $table->boolean('or_isotretinoin')->default(0);
            $table->boolean('or_immunosuppressant')->default(0);
            $table->boolean('or_sumatriptan')->default(0);
            $table->boolean('pregnancy')->default(0);
            $table->boolean('lactation')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('medical_histories');
    }
};
