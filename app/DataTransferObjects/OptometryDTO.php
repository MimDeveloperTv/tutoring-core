<?php

namespace App\DataTransferObjects;

class OptometryDTO
{
     public float $usva;
     public float $K1_D;
     public float $K2_D;
     public float $KM_D;
     public float $subjective_ref_sph;
     public float $subjective_ref_cyl;
     public float $subjective_ref_axis;
     public float $subjective_ref_bcva;



     public function __construct(array $optometry,public string $patient_id,public string $eye_type)
     {
        $this->usva = $optometry['usva'];
        $this->K1_D = $optometry['k_reading']['k1'];
        $this->K2_D = $optometry['k_reading']['k2'];
        $this->KM_D = ($optometry['k_reading']['k1'] + $optometry['k_reading']['k2']) / 2;
        $this->subjective_ref_sph = $optometry['subjectiveRef']['sph'];
         $this->subjective_ref_cyl = $optometry['subjectiveRef']['cyl'];
         $this->subjective_ref_axis = $optometry['subjectiveRef']['axis'];
         $this->subjective_ref_bcva = $optometry['subjectiveRef']['bcva'];
     }

}
