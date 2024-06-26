<?php

namespace App\Services;

use App\Lib\Http\Request as CustomRequest;
use App\Models\Operator;
use App\Models\Patient;
use App\Models\User;
use App\Traits\ErrorBag;

class OperatorService
{
    use ErrorBag;
    public function new($user_id) : ?Operator
    {
        $user = User::find($user_id);
        $fullname = $user->firstname." ".$user->lastname;
        if ($user && $operator_id = $this->createNewBookingOperator($user->id,$fullname,$user->user_collection_id)) {
            $booking_operator_id = $operator_id;
            return Operator::create([
                'id' => $booking_operator_id,
                'user_id' => $user->id,
            ]);
        } else {
            return null;
        }
    }

    public function createNewBookingOperator($user_id,$fullname,$user_collection_id) : ?string
    {
        try {
            $booking_operator_response = CustomRequest::post([
                'api_key' => config("services.iam.api_key"),
            ],[
                'fullname' => $fullname,
                'user_id' => $user_id,

            ], 'booking', "collection/{$user_collection_id}/operators");
        } catch (\Throwable $th) {
            $this->errors_push($th->getMessage());
            return 0;
        }
        if ($booking_operator_response->status() == 201)
        {
            return json_decode($booking_operator_response->body())->data->id;
        }
        else
        {
            return null;
        }
    }
}
