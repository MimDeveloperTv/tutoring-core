<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OperatorResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'firstname' => $this->user->firstname,
            'lastname' => $this->user->lastname,
            'fullname' => $this->user->firstname." ".$this->user->lastname,
            'mobile' => $this->user->mobile,
            'email' => $this->user->email,
            'national_id' => $this->user->national_code,
            'age' => Carbon::createFromFormat('Y-m-d',$this->user->birth_date)->diffInYears(Carbon::now()),
            'gender' => $this->user->gender,
            'specialty' => [
               [
                 'id' => 1,
                 'name' => 'متخصص قلب و عروق'
               ],
               [
                'id' => 2,
                'name' => 'جراح قلب'
               ]
            ],
            'address' => [
               'latitude' => '35.723619',
               'longitude' => '51.411327',
               'description' => 'ولیعصر ابتدای مطهری پلاک 482 طبقه سوم واحد غربی',
               'phone' => '+982178459635'
            ]
         ];
    }
}
