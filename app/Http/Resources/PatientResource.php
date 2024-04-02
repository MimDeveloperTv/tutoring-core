<?php

namespace App\Http\Resources;

use App\Models\Patient;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin Patient */
class PatientResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'patient_file_id' => '58587585251',
            'firstname' => $this->user->firstname,
            'lastname' => $this->user->lastname,
            'fullname' => $this->user->firstname." ".$this->user->lastname,
            'national_id' => $this->user->national_code,
            'age' => Carbon::createFromFormat('Y-m-d',$this->user->birth_date)->diffInYears(Carbon::now()),
            'gender' => $this->user->gender,
            'insurance_number' => '8795684582',
            'insurance_type' => 'نیروهای مسلح',
            'mobile' => $this->user->mobile,
            'email' => $this->user->email,
            'address' => [
                'latitude' => '35.723619',
                'longitude' => '51.411327',
                'description' => 'ولیعصر ابتدای مطهری پلاک 482 طبقه سوم واحد غربی',
                'phone' => '+982178459635'
            ]
        ];
    }
}
