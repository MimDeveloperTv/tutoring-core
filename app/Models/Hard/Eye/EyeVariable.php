<?php

namespace App\Models\Hard\Eye;

use App\Models\Patient;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EyeVariable extends Model
{
    use HasFactory;

    protected $fillable = [
        'patient_id',
        'eye_type',
        'updated_by', // pentacam | optometry                            //done
        'K1_D', // from optometry & pentacam                             //done
        'K2_D', // from optometry & pentacam                             //done
        'pachy_min',                                                     //todo
        'KM_D', // average K1_D & K2_D - from optometry & pentacam       //done
        'astig_topo', // K1_D - K2_D                                     //todo
        'Axis_flat', //Axis (flat)                                       //todo
        'ac_depth', // just from pentacam                                //done
        'subjective_ref_sph', // just from optometry                     //done
        'subjective_ref_cyl',  // just from optometry                    //done
        'subjective_ref_axis', // just from optometry                    //done
        'subjective_ref_bcva', // just from optometry                    //done
        'optometry_ucva', // just from optometry                         //done
        'mixed_data',   //                                               //done
        'PupilX', // just from pentacam                                  //done
        'PupilY', // just from pentacam                                  //done
    ];

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }
}
