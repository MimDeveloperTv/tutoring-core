<?php

namespace App\Http\Resources\Patient;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MedicalHistoryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
        "id" => $this->id,
        "dryness" => boolval($this->dryness),
        "chronic tearing" => boolval($this->chronic_tearing),
        "chronic allergy" => boolval($this->chronic_allergy) ,
        "blepharitis" => boolval($this->blepharitis),
        "contact lens_use" => boolval($this->contact_lens_use) ,
        "recurrent corneal_erosion" => boolval($this->recurrent_corneal_erosion) ,
        "previous ocular trauma" => boolval($this->previous_ocular_trauma) ,
        "previous ocular surgery" => boolval($this->previous_ocular_surgery) ,
        "any other ocular diseases" => boolval($this->any_other_ocular_diseases) ,
        "diabetes" => boolval($this->diabetes)  ,
        "blood pressure" => boolval($this->blood_pressure)  ,
        "known medication allergy" => boolval($this->known_medication_allergy)  ,
        "known allergy to food metals or others" => boolval($this->known_allergy_to_food_metals_or_others) ,
        "collagen systemic diseases" => boolval($this->collagen_systemic_diseases) ,
        "use of anti coagulants" => boolval($this->use_of_anti_coagulants) ,
        "or steroids" => boolval($this->or_steroids) ,
        "or isotretinoin" => boolval($this->or_isotretinoin) ,
        "or immunosuppressant" => boolval($this->or_immunosuppressant) ,
        "or sumatriptan" => boolval($this->or_sumatriptan) ,
        "pregnancy" => boolval($this->pregnancy) ,
        "lactation" => boolval($this->lactation)
        ];
    }
}
