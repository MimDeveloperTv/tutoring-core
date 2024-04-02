<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MedicalHistory extends Model
{
    use HasFactory;

    protected $fillable = [
        "dryness",
        "chronic_tearing" ,
        "chronic_allergy" ,
        "blepharitis",
        "contact_lens_use" ,
        "recurrent_corneal_erosion" ,
        "previous_ocular_trauma" ,
        "previous_ocular_surgery" ,
        "any_other_ocular_diseases" ,
        "diabetes"  ,
        "blood_pressure"  ,
        "known_medication_allergy"  ,
        "known_allergy_to_food_metals_or_others" ,
        "collagen_systemic_diseases" ,
        "use_of_anti_coagulants" ,
        "or_steroids" ,
        "or_isotretinoin" ,
        "or_immunosuppressant" ,
        "or_sumatriptan" ,
        "pregnancy" ,
        "lactation"
    ];


}
