<?php

namespace App\Services\EyeVariable;

use App\Models\Hard\Eye\EyeVariable;

class EyeVariableService
{
     public function __construct(public string $update_type,public string $patient_id,public string $eye)
     {
     }

     public function set($key,$value) : void
     {
         $eyeVariable = EyeVariable::firstOrCreate([
             'patient_id' => $this->patient_id,
             'eye_type' => $this->eye,
         ],[]);

         if($this->allowUpdate($key))
         {
             $eyeVariable->update([
                 $key => $value
             ]);
         }
     }

     public function  allowUpdate($key) : bool
     {
         return true;
     }
}
