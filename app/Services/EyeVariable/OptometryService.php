<?php

namespace App\Services\EyeVariable;

use App\DataTransferObjects\OptometryDTO;

class OptometryService
{
     public EyeVariableService $eyeVariableService;

     public function __construct(public OptometryDTO $optometryDTO)
     {
         $this->eyeVariableService = new EyeVariableService('optometry',$this->optometryDTO->patient_id,$this->optometryDTO->eye_type);
     }

     public function updateEyeVariable() : void
     {
          $this->eyeVariableService->set('usva',$this->optometryDTO->usva);
          $this->eyeVariableService->set('K1_D',$this->optometryDTO->K1_D);
          $this->eyeVariableService->set('K2_D',$this->optometryDTO->K2_D);
          $this->eyeVariableService->set('KM_D',$this->optometryDTO->KM_D);
          $this->eyeVariableService->set('subjective_ref_sph',$this->optometryDTO->subjective_ref_sph);
          $this->eyeVariableService->set('subjective_ref_cyl',$this->optometryDTO->subjective_ref_cyl);
          $this->eyeVariableService->set('subjective_ref_axis',$this->optometryDTO->subjective_ref_axis);
          $this->eyeVariableService->set('subjective_ref_bcva',$this->optometryDTO->subjective_ref_bcva);
     }
}
