<?php

namespace App\Services;

use App\Http\Resources\PatientResource;
use App\Lib\Http\Request as CustomRequest;
use App\Models\Patient;
use App\Models\User;
use App\Traits\ErrorBag;
use Illuminate\Support\Facades\DB;

class PatientService
{
    use ErrorBag;
     public function new($user_id) : ?Patient
     {
         $user = User::find($user_id);
         $fullname = $user->firstname." ".$user->lastname;
         if ($user && $consumer_id = $this->createNewBookingConsumer($user->id,$fullname,$user->user_collection_id)) {
             $booking_patient_id = $consumer_id;
                 return Patient::create([
                     'id' => $booking_patient_id,
                     'user_id' => $user->id,
                 ]);
         } else {
              return null;
         }
     }

     public function createNewBookingConsumer($user_id,$fullname,$user_collection_id) : ?string
     {
         try {
             $booking_patient_response = CustomRequest::post([
                  'api_key' => config("services.iam.api_key"),
             ],[
                'user_id' => $user_id,
             'fullname' => $fullname,
         ], 'booking', "collection/{$user_collection_id}/consumers");
         } catch (\Throwable $th) {
          $this->errors_push($th->getMessage());
          return 0;
          }
         if ($booking_patient_response->status() == 201)
         {
             return json_decode($booking_patient_response->body())->data->id;
         }
         else
         {
             return null;
         }
     }
}
