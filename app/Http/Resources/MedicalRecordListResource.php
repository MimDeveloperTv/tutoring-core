<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin \App\Models\MedicalRecord */
class MedicalRecordListResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'eye_type' => $this->service_item,
            'patient_id' => $this->patient_id,
            'prescriber_id' => $this->prescriber_id,
            'prescription_id' => $this->prescription_id,
            'prescription_name' => $this->prescription_name,
            'operator_id' => $this->operator_id,
            'status' => $this->status,
            'created_by' => $this->created_by
        ];
    }
}
